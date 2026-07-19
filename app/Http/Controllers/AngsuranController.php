<?php

namespace App\Http\Controllers;

use App\Models\Angsuran;
use App\Models\Pinjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AngsuranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = $request->filter;
        $user = auth()->user();

        $query = Angsuran::with('pinjaman.nasabah')
            ->whereHas('pinjaman', function ($q) use ($user) {

                // Hanya tampilkan pinjaman yang masih aktif
                $q->where('status', 'aktif');

                // Jika petugas, hanya tampilkan pinjaman miliknya
                if ($user->role === 'petugas') {
                    $q->where('created_by', $user->id);
                }
            });

        if ($filter == 'tunggakan') {

            $query->where('status', 'belum_bayar')
                ->whereDate('tanggal_jatuh_tempo', '<', Carbon::today());
        } else {

            $tanggal = $request->tanggal ?? Carbon::today()->toDateString();

            $query->whereDate('tanggal_jatuh_tempo', $tanggal);
        }

        $angsuran = $query
            ->orderBy('tanggal_jatuh_tempo')
            ->get();

        // ==========================
        // Statistik
        // ==========================

        $statistik = Angsuran::whereHas('pinjaman', function ($q) use ($user) {

            $q->where('status', 'aktif');

            if ($user->role === 'petugas') {
                $q->where('created_by', $user->id);
            }
        });

        $tagihanHariIni = (clone $statistik)
            ->whereDate('tanggal_jatuh_tempo', Carbon::today())
            ->count();

        $belumBayar = (clone $statistik)
            ->where('status', 'belum_bayar')
            ->count();

        $dibayar = (clone $statistik)
            ->where('status', 'lunas')
            ->count();

        $tunggakan = (clone $statistik)
            ->where('status', 'belum_bayar')
            ->whereDate('tanggal_jatuh_tempo', '<', Carbon::today())
            ->count();

        return view(
            'angsuran.index',
            compact(
                'angsuran',
                'tagihanHariIni',
                'belumBayar',
                'dibayar',
                'tunggakan'
            )
        );
    }

    public function bayar($id)
    {
        if ($redirect = $this->denyPimpinan()) {
            return $redirect;
        }

        $angsuran = Angsuran::with('pinjaman.nasabah')->findOrFail($id);

        $angsuran->update([
            'status' => 'lunas',
            'tanggal_bayar' => now(),
        ]);

        $pinjaman = $angsuran->pinjaman;

        $sisa = $pinjaman->angsuran()
            ->where('status', '!=', 'lunas')
            ->count();

        if ($sisa == 0) {
            $pinjaman->update([
                'status' => 'lunas'
            ]);
        }

        // ============================
        // Kirim WA Konfirmasi Pembayaran
        // ============================
        $this->kirimWaPembayaran($angsuran);

        return back()->with(
            'success',
            'Angsuran berhasil dibayar dan WhatsApp berhasil dikirim.'
        );
    }

    public function kirimWa($id)
    {
        if ($redirect = $this->denyPimpinan()) {
            return $redirect;
        }

        $angsuran = Angsuran::with('pinjaman.nasabah')->findOrFail($id);

        $token = env('FONNTE_TOKEN');

        $nasabah = $angsuran->pinjaman->nasabah;

        // 🔥 FIX NOMOR 0 → 62
        $noHp = $nasabah->no_hp;
        if (substr($noHp, 0, 1) == '0') {
            $noHp = '62' . substr($noHp, 1);
        }

        // 🔥 PESAN
        $message =
            "Halo {$nasabah->nama}\n" .
            "Tagihan angsuran ke {$angsuran->angsuran_ke}\n" .
            "Kode: {$angsuran->pinjaman->kode_pinjaman}\n" .
            "Jumlah: Rp " . number_format($angsuran->jumlah_tagihan, 0, ',', '.') . "\n\n" .
            "Mohon segera dilakukan pembayaran.";

        // 🔥 KIRIM KE FONNTE
        $response = Http::withHeaders([
            'Authorization' => $token
        ])->post('https://api.fonnte.com/send', [
            'target' => $noHp,
            'message' => $message,
        ]);

        $result = $response->json();

        // 🔥 DEBUG ERROR (kalau gagal)
        if (!$response->successful() || ($result['status'] ?? false) == false) {
            return back()->with('error', 'Gagal kirim WA: ' . json_encode($result));
        }

        return back()->with('success', 'WA berhasil dikirim');
    }

    private function kirimWaPembayaran($angsuran)
    {
        $token = env('FONNTE_TOKEN');

        $nasabah = $angsuran->pinjaman->nasabah;

        // Ubah nomor 08xxxx menjadi 628xxxx
        $noHp = $nasabah->no_hp;

        if (substr($noHp, 0, 1) == '0') {
            $noHp = '62' . substr($noHp, 1);
        }

        $message =
            "Halo {$nasabah->nama}\n\n" .
            "Pembayaran angsuran Anda telah kami terima.\n\n" .
            "Kode Pinjaman : {$angsuran->pinjaman->kode_pinjaman}\n" .
            "Angsuran Ke : {$angsuran->angsuran_ke}\n" .
            "Jumlah Bayar : Rp " . number_format($angsuran->jumlah_tagihan, 0, ',', '.') . "\n" .
            "Tanggal Bayar : " . now()->format('d-m-Y H:i') . "\n\n" .
            "Terima kasih telah melakukan pembayaran.\n\n" .
            "KSP Pekali 99";

        Http::withHeaders([
            'Authorization' => $token
        ])->post('https://api.fonnte.com/send', [
            'target' => $noHp,
            'message' => $message,
        ]);
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
