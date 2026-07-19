<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if ($redirect = $this->authorizeRoles(['admin'])) {
            return $redirect;
        }

        $users = User::latest()->get();

        return view('pengguna.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function profil()
    {
        $user = auth()->user();

        return view('pengguna.profil', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($redirect = $this->authorizeRoles(['admin'])) {
            return $redirect;
        }

        // VALIDASI
        $request->validate([
            'kode_user'       => 'required|unique:users,kode_user',
            'name'            => 'required',
            'username'        => 'required|unique:users,username',
            'email'           => 'nullable|email|unique:users,email',
            'nik'             => 'nullable|unique:users,nik',
            'jenis_kelamin'   => 'required',
            'tempat_lahir'    => 'nullable',
            'tanggal_lahir'   => 'nullable',
            'alamat'          => 'nullable',
            'no_hp'           => 'nullable',
            'password'        => 'required|min:6',
            'role'            => 'required',
            'status'          => 'required',
            'foto'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // DEFAULT FOTO
        $namaFoto = null;

        // UPLOAD FOTO
        if ($request->hasFile('foto')) {

            $file = $request->file('foto');

            // nama file unik
            $namaFoto = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // pastikan folder public/user ada
            $tujuan = public_path('user');

            if (!file_exists($tujuan)) {
                mkdir($tujuan, 0777, true);
            }

            // simpan langsung ke public/user
            $file->move($tujuan, $namaFoto);
        }

        // SIMPAN USER
        User::create([
            'kode_user'      => $request->kode_user,
            'name'           => $request->name,
            'username'       => $request->username,
            'email'          => $request->email,
            'nik'            => $request->nik,
            'jenis_kelamin'  => $request->jenis_kelamin,
            'tempat_lahir'   => $request->tempat_lahir,
            'tanggal_lahir'  => $request->tanggal_lahir,
            'alamat'         => $request->alamat,
            'no_hp'          => $request->no_hp,
            'foto'           => $namaFoto,
            'password'       => Hash::make($request->password),
            'role'           => $request->role,
            'status'         => $request->status,
        ]);

        return redirect()->back()->with('success', 'Data pengguna berhasil ditambahkan');
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
        if ($redirect = $this->authorizeRoles(['admin'])) {
            return $redirect;
        }

        $request->validate([
            'kode_user'       => 'required',
            'name'            => 'required',
            'username'        => 'required',
            'email'           => 'nullable|email',
            'nik'             => 'nullable',
            'jenis_kelamin'   => 'required',
            'tempat_lahir'    => 'nullable',
            'tanggal_lahir'   => 'nullable',
            'alamat'          => 'nullable',
            'no_hp'           => 'nullable',
            'password'        => 'nullable|min:6|confirmed',
            'role'            => 'required',
            'status'          => 'required',
            'foto'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $user = User::findOrFail($id);

        // update foto kalau ada
        if ($request->hasFile('foto')) {

            $file = $request->file('foto');
            $namaFoto = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $tujuan = public_path('user');

            if (!file_exists($tujuan)) {
                mkdir($tujuan, 0777, true);
            }

            $file->move($tujuan, $namaFoto);

            // hapus foto lama (opsional)
            if ($user->foto && file_exists(public_path('user/' . $user->foto))) {
                unlink(public_path('user/' . $user->foto));
            }

            $user->foto = $namaFoto;
        }

        // update data
        $data = [
            'kode_user'      => $request->kode_user,
            'name'           => $request->name,
            'username'       => $request->username,
            'email'          => $request->email,
            'nik'            => $request->nik,
            'jenis_kelamin'  => $request->jenis_kelamin,
            'tempat_lahir'   => $request->tempat_lahir,
            'tanggal_lahir'  => $request->tanggal_lahir,
            'alamat'         => $request->alamat,
            'no_hp'          => $request->no_hp,
            'role'           => $request->role,
            'status'         => $request->status,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->back()->with('success', 'Data pengguna berhasil diupdate');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        // Cek password lama
        if (!Hash::check($request->password_lama, $user->password)) {
            return back()->with('error', 'Password lama tidak sesuai.');
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password_baru),
        ]);

        return back()->with('success', 'Password berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if ($redirect = $this->authorizeRoles(['admin'])) {
            return $redirect;
        }

        $user = User::findOrFail($id);

        // hapus foto kalau ada
        if ($user->foto && file_exists(public_path('user/' . $user->foto))) {
            unlink(public_path('user/' . $user->foto));
        }

        $user->delete();

        return redirect()->back()->with('success', 'Data pengguna berhasil dihapus');
    }
}
