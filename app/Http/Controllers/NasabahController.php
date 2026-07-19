<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NasabahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        // Data Trash
        if ($request->status == 'trash') {
            $nasabah = Nasabah::onlyTrashed();
        } else {
            $nasabah = Nasabah::query();

            // Filter Status
            if ($request->status) {
                $nasabah->where(
                    'status',
                    $request->status
                );
            }
        }

        // Petugas hanya boleh melihat nasabah yang dia input
        if ($user->role === 'petugas') {
            $nasabah->where('created_by', $user->id);
        }

        // Ambil data
        $nasabah = $nasabah
            ->latest()
            ->get();

        // ==============================
        // Generate Kode Nasabah Otomatis
        // ==============================

        $lastNasabah = Nasabah::latest('id')->first();

        if ($lastNasabah) {

            $lastNumber = (int) substr($lastNasabah->kode_nasabah, 3);

            $kodeNasabah = 'NSB' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {

            $kodeNasabah = 'NSB0001';
        }

        return view(
            'nasabah.index',
            compact(
                'nasabah',
                'kodeNasabah'
            )
        );
    }

    private function generateKodeNasabah()
    {
        $lastNasabah = Nasabah::latest('id')->first();

        if (!$lastNasabah) {
            return 'NSB0001';
        }

        $lastNumber = (int) substr($lastNasabah->kode_nasabah, 3);

        return 'NSB' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        if ($redirect = $this->denyPimpinan()) {
            return $redirect;
        }

        $request->validate([
            'nik'            => 'required|digits:16|unique:nasabah,nik',
            'nama'           => 'required|string|max:100',
            'jenis_kelamin'  => 'required',
            'no_hp'          => 'nullable|digits_between:10,15',
            // 'no_hp'          => 'nullable|unique:nasabah,no_hp',

            'foto'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'foto_ktp'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // ===========================
        // Generate Kode Nasabah
        // ===========================

        $kodeNasabah = $this->generateKodeNasabah();

        $foto = null;
        $fotoKtp = null;

        /*
    |--------------------------------------------------------------------------
    | Folder
    |--------------------------------------------------------------------------
    */

        $folderFoto = public_path('anggota/foto');
        $folderKtp  = public_path('anggota/ktp');

        if (!file_exists($folderFoto)) {
            mkdir($folderFoto, 0777, true);
        }

        if (!file_exists($folderKtp)) {
            mkdir($folderKtp, 0777, true);
        }

        /*
    |--------------------------------------------------------------------------
    | Upload Foto
    |--------------------------------------------------------------------------
    */

        if ($request->hasFile('foto')) {

            $file = $request->file('foto');

            $foto = time() . '_foto.' . $file->getClientOriginalExtension();

            $file->move($folderFoto, $foto);
        }

        /*
    |--------------------------------------------------------------------------
    | Kamera Realtime
    |--------------------------------------------------------------------------
    */

        if ($request->filled('foto_camera')) {

            $image = str_replace(
                'data:image/png;base64,',
                '',
                $request->foto_camera
            );

            $image = str_replace(' ', '+', $image);

            $imageName = time() . '_camera.png';

            file_put_contents(
                $folderFoto . '/' . $imageName,
                base64_decode($image)
            );

            $foto = $imageName;
        }

        /*
    |--------------------------------------------------------------------------
    | Upload KTP
    |--------------------------------------------------------------------------
    */

        if ($request->hasFile('foto_ktp')) {

            $fileKtp = $request->file('foto_ktp');

            $fotoKtp = time() . '_ktp.' . $fileKtp->getClientOriginalExtension();

            $fileKtp->move($folderKtp, $fotoKtp);
        }

        /*
    |--------------------------------------------------------------------------
    | Simpan Database
    |--------------------------------------------------------------------------
    */

        Nasabah::create([

            'kode_nasabah'   => $kodeNasabah,

            'nik'            => $request->nik,
            'nama'           => $request->nama,
            'jenis_kelamin'  => $request->jenis_kelamin,
            'tempat_lahir'   => $request->tempat_lahir,
            'tanggal_lahir'  => $request->tanggal_lahir,

            'alamat'         => $request->alamat,
            'no_hp'          => $request->no_hp,
            'pekerjaan'      => $request->pekerjaan,
            'pendapatan'     => $request->pendapatan,

            'foto'           => $foto,
            'foto_ktp'       => $fotoKtp,

            'tanggal_daftar' => $request->tanggal_daftar,
            'status'         => $request->status,

            'created_by'     => Auth::id(),
        ]);

        return redirect()
            ->route('nasabah.index')
            ->with('success', 'Data nasabah berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {
        if ($redirect = $this->denyPimpinan()) {
            return $redirect;
        }

        $nasabah = Nasabah::findOrFail($id);

        $request->validate([
            'nik'            => 'required|digits:16|unique:nasabah,nik,' . $id,
            'nama'           => 'required|string|max:100',
            'jenis_kelamin'  => 'required',
            'no_hp'          => 'nullable|digits_between:10,15',
            // 'no_hp'          => 'nullable|unique:nasabah,no_hp,' . $id,

            'foto'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'foto_ktp'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        /*
    |--------------------------------------------------------------------------
    | FOTO NASABAH
    |--------------------------------------------------------------------------
    */

        $foto = $nasabah->foto;

        if ($request->hasFile('foto')) {

            if ($nasabah->foto) {

                $path = public_path('anggota/foto/' . $nasabah->foto);

                if (file_exists($path)) {
                    unlink($path);
                }
            }

            $file = $request->file('foto');

            $foto = time() . '_foto.' . $file->getClientOriginalExtension();

            $file->move(public_path('anggota/foto'), $foto);
        }

        /*
    |--------------------------------------------------------------------------
    | FOTO KTP
    |--------------------------------------------------------------------------
    */

        $fotoKtp = $nasabah->foto_ktp;

        if ($request->hasFile('foto_ktp')) {

            if ($nasabah->foto_ktp) {

                $path = public_path('anggota/ktp/' . $nasabah->foto_ktp);

                if (file_exists($path)) {
                    unlink($path);
                }
            }

            $fileKtp = $request->file('foto_ktp');

            $fotoKtp = time() . '_ktp.' . $fileKtp->getClientOriginalExtension();

            $fileKtp->move(public_path('anggota/ktp'), $fotoKtp);
        }

        /*
    |--------------------------------------------------------------------------
    | UPDATE DATA
    |--------------------------------------------------------------------------
    */

        $nasabah->update([

            'nik'            => $request->nik,
            'nama'           => $request->nama,
            'jenis_kelamin'  => $request->jenis_kelamin,
            'tempat_lahir'   => $request->tempat_lahir,
            'tanggal_lahir'  => $request->tanggal_lahir,
            'alamat'         => $request->alamat,
            'no_hp'          => $request->no_hp,
            'pekerjaan'      => $request->pekerjaan,
            'pendapatan'     => $request->pendapatan,
            'tanggal_daftar' => $request->tanggal_daftar,
            'status'         => $request->status,
            'foto'           => $foto,
            'foto_ktp'       => $fotoKtp,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Data nasabah berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if ($redirect = $this->denyPimpinan()) {
            return $redirect;
        }

        $nasabah = Nasabah::findOrFail($id);

        /*
    |--------------------------------------------------------------------------
    | SOFT DELETE
    |--------------------------------------------------------------------------
    */

        $nasabah->delete();

        return redirect()->back()
            ->with('success', 'Data nasabah berhasil dihapus');
    }

    public function forceDelete($id)
    {
        if ($redirect = $this->denyPimpinan()) {
            return $redirect;
        }

        $nasabah = Nasabah::onlyTrashed()->findOrFail($id);

        /*
    |--------------------------------------------------------------------------
    | HAPUS FOTO
    |--------------------------------------------------------------------------
    */

        // FOTO NASABAH
        if ($nasabah->foto) {

            $pathFoto = public_path(
                'anggota/foto/' . $nasabah->foto
            );

            if (file_exists($pathFoto)) {
                unlink($pathFoto);
            }
        }

        // FOTO KTP
        if ($nasabah->foto_ktp) {

            $pathKtp = public_path(
                'anggota/ktp/' . $nasabah->foto_ktp
            );

            if (file_exists($pathKtp)) {
                unlink($pathKtp);
            }
        }

        /*
    |--------------------------------------------------------------------------
    | HAPUS PERMANEN
    |--------------------------------------------------------------------------
    */

        $nasabah->forceDelete();

        return redirect()->back()
            ->with('success', 'Data nasabah dihapus permanen');
    }

    public function restore($id)
    {
        if ($redirect = $this->denyPimpinan()) {
            return $redirect;
        }

        /*
    |--------------------------------------------------------------------------
    | AMBIL DATA DARI TRASH
    |--------------------------------------------------------------------------
    */

        $nasabah = Nasabah::onlyTrashed()
            ->findOrFail($id);

        /*
    |--------------------------------------------------------------------------
    | RESTORE DATA
    |--------------------------------------------------------------------------
    */

        $nasabah->restore();

        /*
    |--------------------------------------------------------------------------
    | REDIRECT
    |--------------------------------------------------------------------------
    */

        return redirect()->back()
            ->with('success', 'Data nasabah berhasil direstore');
    }
}
