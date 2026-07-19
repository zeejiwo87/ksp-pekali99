<?php

namespace App\Http\Controllers;

use App\Models\Angsuran;
use App\Models\Nasabah;
use App\Models\Pinjaman;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $totalUser = User::count();

        if ($user->role == 'petugas') {

            // Statistik
            $totalNasabah = Nasabah::where('created_by', $user->id)->count();

            $totalPinjaman = Pinjaman::where('created_by', $user->id)
                ->where('status', 'aktif')
                ->count();

            $pinjamanLunas = Pinjaman::where('created_by', $user->id)
                ->where('status', 'lunas')
                ->count();

            // Grafik
            $grafikPinjaman = Pinjaman::where('created_by', $user->id)
                ->selectRaw('MONTH(tanggal_pinjam) as bulan, COUNT(*) as total')
                ->groupByRaw('MONTH(tanggal_pinjam)')
                ->pluck('total', 'bulan')
                ->toArray();

            // Angsuran Jatuh Tempo
            $angsuranJatuhTempo = Angsuran::with('pinjaman.nasabah')
                ->whereHas('pinjaman', function ($q) use ($user) {
                    $q->where('created_by', $user->id);
                })
                ->whereNull('tanggal_bayar')
                ->whereDate('tanggal_jatuh_tempo', '<=', now()->toDateString())
                ->orderBy('tanggal_jatuh_tempo', 'asc')
                ->take(15)
                ->get();

            // Nasabah Terbaru
            $nasabahTerbaru = Nasabah::where('created_by', $user->id)
                ->latest()
                ->take(5)
                ->get();
        } else {

            // Admin & Pimpinan
            $totalNasabah = Nasabah::count();

            $totalPinjaman = Pinjaman::where('status', 'aktif')->count();

            $pinjamanLunas = Pinjaman::where('status', 'lunas')->count();

            $grafikPinjaman = Pinjaman::selectRaw('MONTH(tanggal_pinjam) as bulan, COUNT(*) as total')
                ->groupByRaw('MONTH(tanggal_pinjam)')
                ->pluck('total', 'bulan')
                ->toArray();

            $angsuranJatuhTempo = Angsuran::with('pinjaman.nasabah')
                ->whereNull('tanggal_bayar')
                ->orderBy('tanggal_jatuh_tempo')
                ->take(5)
                ->get();

            $nasabahTerbaru = Nasabah::latest()
                ->take(5)
                ->get();
        }

        // Label grafik
        $label = [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'Mei',
            'Jun',
            'Jul',
            'Agu',
            'Sep',
            'Okt',
            'Nov',
            'Des'
        ];

        // Isi data grafik Januari–Desember
        $data = [];

        for ($i = 1; $i <= 12; $i++) {
            $data[] = $grafikPinjaman[$i] ?? 0;
        }

        return view('dashboard', compact(
            'totalNasabah',
            'totalUser',
            'totalPinjaman',
            'pinjamanLunas',
            'label',
            'data',
            'angsuranJatuhTempo',
            'nasabahTerbaru'
        ));
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
