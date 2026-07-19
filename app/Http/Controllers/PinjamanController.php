<?php

namespace App\Http\Controllers;

use App\Models\Angsuran;
use App\Models\AturanPinjaman;
use App\Models\Nasabah;
use App\Models\Pinjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PinjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $pinjaman = Pinjaman::with([
            'nasabah',
            'user',
            'angsuran'
        ]);

        if ($user->role === 'petugas') {
            $pinjaman->where('created_by', $user->id);
        }

        $pinjaman = $pinjaman->latest()->get();

        $kodePinjaman = $this->generateKodePinjaman();

        // 🔒 FIX: filter nasabah only for pinjaman selection
        $nasabah = Nasabah::query()
            ->whereDoesntHave('pinjaman', function ($query) {
                $query->whereIn('status', ['aktif', 'macet']);
            });

        if ($user->role === 'petugas') {
            $nasabah->where('created_by', $user->id);
        }

        $nasabah = $nasabah->get();

        return view('pinjaman.index', compact(
            'pinjaman',
            'kodePinjaman',
            'nasabah'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    private function generateKodePinjaman()
    {
        $lastPinjaman = Pinjaman::latest('id')->first();

        if (!$lastPinjaman) {
            return 'PJM0001';
        }

        $lastNumber = (int) substr($lastPinjaman->kode_pinjaman, 3);

        return 'PJM' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
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
            'nasabah_id'       => 'required',
            'jumlah_pinjaman'  => 'required|numeric|min:1',
            'tenor'            => 'required|numeric|min:1',
            'tenor_satuan'     => 'required',
            'bunga_persen'     => 'required|numeric|min:0',
            'tanggal_pinjam'   => 'required|date',
        ]);

        // Ambil data nasabah
        $nasabah = Nasabah::findOrFail($request->nasabah_id);

        // Cari aturan pinjaman berdasarkan pendapatan
        $aturan = AturanPinjaman::where('penghasilan_min', '<=', $nasabah->pendapatan)
            ->where('penghasilan_max', '>=', $nasabah->pendapatan)
            ->first();

        // Jika belum ada aturan
        if (!$aturan) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Belum ada aturan pinjaman untuk pendapatan nasabah ini.');
        }

        // Validasi maksimal pinjaman
        if ($request->jumlah_pinjaman > $aturan->maksimal_pinjaman) {
            return redirect()->back()
                ->withInput()
                ->with(
                    'error',
                    'Pendapatan nasabah Rp ' .
                        number_format($nasabah->pendapatan, 0, ',', '.') .
                        ', sehingga maksimal pinjaman hanya Rp ' .
                        number_format($aturan->maksimal_pinjaman, 0, ',', '.')
                );
        }

        // Konversi tenor menjadi total periode
        $totalPeriode = match ($request->tenor_satuan) {
            'minggu' => (int) $request->tenor,
            'bulan'  => (int) $request->tenor * 4,
            'tahun'  => (int) $request->tenor * 52,
        };

        // Bunga per periode
        $bungaPerPeriode = ($request->bunga_persen / 100) * $request->jumlah_pinjaman;

        // Total bunga
        $totalBunga = $bungaPerPeriode * $totalPeriode;

        // Total pinjaman
        $totalPinjaman = $request->jumlah_pinjaman + $totalBunga;

        // Angsuran per periode
        $angsuran = $totalPinjaman / $totalPeriode;

        // Tanggal jatuh tempo
        $tanggalJatuhTempo = match ($request->tenor_satuan) {
            'minggu' => Carbon::parse($request->tanggal_pinjam)
                ->addWeeks((int) $request->tenor),

            'bulan' => Carbon::parse($request->tanggal_pinjam)
                ->addMonths((int) $request->tenor),

            'tahun' => Carbon::parse($request->tanggal_pinjam)
                ->addYears((int) $request->tenor),
        };

        // Simpan pinjaman
        $pinjaman = Pinjaman::create([
            'nasabah_id'            => $request->nasabah_id,
            'created_by'            => Auth::id(),
            'kode_pinjaman'         => $this->generateKodePinjaman(),
            'jumlah_pinjaman'       => $request->jumlah_pinjaman,
            'tenor'                 => $request->tenor,
            'tenor_satuan'          => $request->tenor_satuan,
            'bunga_persen'          => $request->bunga_persen,
            'total_pinjaman'        => round($totalPinjaman),
            'angsuran_per_periode'  => round($angsuran),
            'tanggal_pinjam'        => $request->tanggal_pinjam,
            'tanggal_jatuh_tempo'   => $tanggalJatuhTempo,
            'status'                => 'aktif',
        ]);

        // Generate angsuran otomatis
        for ($i = 1; $i <= $totalPeriode; $i++) {

            $jatuhTempo = match ($request->tenor_satuan) {
                'minggu' => Carbon::parse($request->tanggal_pinjam)->addWeeks($i),
                'bulan'  => Carbon::parse($request->tanggal_pinjam)->addMonths($i),
                'tahun'  => Carbon::parse($request->tanggal_pinjam)->addYears($i),
            };

            Angsuran::create([
                'pinjaman_id'         => $pinjaman->id,
                'angsuran_ke'         => $i,
                'tanggal_jatuh_tempo' => $jatuhTempo,
                'jumlah_tagihan'      => round($angsuran),
                'status'              => 'belum_bayar',
            ]);
        }

        return redirect()
            ->route('pinjaman.index')
            ->with('success', 'Pinjaman berhasil ditambahkan');
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
    public function update(Request $request, string $id)
    {
        if ($redirect = $this->denyPimpinan()) {
            return $redirect;
        }

        $request->validate([
            'nasabah_id'      => 'required',
            'jumlah_pinjaman' => 'required|numeric|min:1',
            'tenor'           => 'required|numeric|min:1',
            'tenor_satuan'    => 'required',
            'bunga_persen'    => 'required|numeric|min:0',
            'tanggal_pinjam'  => 'required|date',
        ]);

        $pinjaman = Pinjaman::findOrFail($id);

        // Ambil data nasabah
        $nasabah = Nasabah::findOrFail($request->nasabah_id);

        // Cek aturan pinjaman
        $aturan = AturanPinjaman::where('penghasilan_min', '<=', $nasabah->pendapatan)
            ->where('penghasilan_max', '>=', $nasabah->pendapatan)
            ->first();

        if (!$aturan) {
            return back()
                ->withInput()
                ->with('error', 'Belum ada aturan pinjaman untuk pendapatan nasabah ini.');
        }

        if ($request->jumlah_pinjaman > $aturan->maksimal_pinjaman) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Pendapatan nasabah Rp ' .
                        number_format($nasabah->pendapatan, 0, ',', '.') .
                        ', sehingga maksimal pinjaman hanya Rp ' .
                        number_format($aturan->maksimal_pinjaman, 0, ',', '.')
                );
        }

        // Hitung total periode
        $totalPeriode = match ($request->tenor_satuan) {
            'minggu' => (int) $request->tenor,
            'bulan'  => (int) $request->tenor * 4,
            'tahun'  => (int) $request->tenor * 52,
        };

        // Hitung bunga
        $bungaPerPeriode = ($request->bunga_persen / 100) * $request->jumlah_pinjaman;
        $totalBunga = $bungaPerPeriode * $totalPeriode;

        // Total pinjaman
        $totalPinjaman = $request->jumlah_pinjaman + $totalBunga;

        // Angsuran
        $angsuran = $totalPinjaman / $totalPeriode;

        // Jatuh tempo terakhir
        $tenor = (int) $request->tenor;

        $tanggalJatuhTempo = Carbon::parse($request->tanggal_pinjam);

        switch ($request->tenor_satuan) {
            case 'minggu':
                $tanggalJatuhTempo->addWeeks($tenor);
                break;

            case 'bulan':
                $tanggalJatuhTempo->addMonths($tenor);
                break;

            case 'tahun':
                $tanggalJatuhTempo->addYears($tenor);
                break;

            default:
                return back()->with('error', 'Satuan tenor tidak valid.');
        }

        // Update pinjaman
        $pinjaman->update([
            'nasabah_id'           => $request->nasabah_id,
            'jumlah_pinjaman'      => $request->jumlah_pinjaman,
            'tenor'                => $request->tenor,
            'tenor_satuan'         => $request->tenor_satuan,
            'bunga_persen'         => $request->bunga_persen,
            'total_pinjaman'       => round($totalPinjaman),
            'angsuran_per_periode' => round($angsuran),
            'tanggal_pinjam'       => $request->tanggal_pinjam,
            'tanggal_jatuh_tempo'  => $tanggalJatuhTempo,
        ]);

        // Hapus seluruh angsuran lama
        Angsuran::where('pinjaman_id', $pinjaman->id)->delete();

        // Generate ulang angsuran
        for ($i = 1; $i <= $totalPeriode; $i++) {

            $jatuhTempo = Carbon::parse($request->tanggal_pinjam);

            switch ($request->tenor_satuan) {
                case 'minggu':
                    $jatuhTempo->addWeeks($i);
                    break;

                case 'bulan':
                    $jatuhTempo->addMonths($i);
                    break;

                case 'tahun':
                    $jatuhTempo->addYears($i);
                    break;
            }

            Angsuran::create([
                'pinjaman_id'         => $pinjaman->id,
                'angsuran_ke'         => $i,
                'tanggal_jatuh_tempo' => $jatuhTempo,
                'jumlah_tagihan'      => round($angsuran),
                'status'              => 'belum_bayar',
            ]);
        }

        return redirect()
            ->route('pinjaman.index')
            ->with('success', 'Data pinjaman berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if ($redirect = $this->denyPimpinan()) {
            return $redirect;
        }

        $pinjaman = Pinjaman::findOrFail($id);

        // Cek apakah sudah ada angsuran yang dibayar
        $sudahDibayar = $pinjaman->angsuran()
            ->where('status', 'lunas')
            ->exists();

        if ($sudahDibayar) {
            return redirect()
                ->route('pinjaman.index')
                ->with('error', 'Pinjaman tidak dapat dihapus karena sudah memiliki pembayaran angsuran.');
        }

        // Hapus permanen seluruh angsuran
        $pinjaman->angsuran()->forceDelete();

        // Hapus permanen pinjaman
        $pinjaman->forceDelete();

        return redirect()
            ->route('pinjaman.index')
            ->with('success', 'Data pinjaman berhasil dihapus.');
    }
}
