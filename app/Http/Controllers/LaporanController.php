<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Nasabah;
use App\Models\Pinjaman;
use App\Models\Angsuran;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        if ($redirect = $this->authorizeRoles(['admin', 'pimpinan'])) {
            return $redirect;
        }

        $jenis = $request->jenis;
        $data = collect();

        switch ($jenis) {

            case 'nasabah':

                $query = Nasabah::query();

                if ($request->filled('status')) {
                    $query->where('status', $request->status);
                }

                if ($request->filled('tanggal_awal')) {
                    $query->whereDate('created_at', '>=', $request->tanggal_awal);
                }

                if ($request->filled('tanggal_akhir')) {
                    $query->whereDate('created_at', '<=', $request->tanggal_akhir);
                }

                $data = $query->orderBy('created_at', 'desc')->get();

                break;

            case 'pinjaman':

                $query = Pinjaman::with('nasabah');

                if ($request->filled('tanggal_awal')) {
                    $query->whereDate('tanggal_pinjam', '>=', $request->tanggal_awal);
                }

                if ($request->filled('tanggal_akhir')) {
                    $query->whereDate('tanggal_pinjam', '<=', $request->tanggal_akhir);
                }

                $data = $query->get();

                break;

            case 'angsuran':

                $query = Pinjaman::with([
                    'nasabah',
                    'angsuran'
                ]);

                if ($request->filled('tanggal_awal')) {
                    $query->whereDate('tanggal_pinjam', '>=', $request->tanggal_awal);
                }

                if ($request->filled('tanggal_akhir')) {
                    $query->whereDate('tanggal_pinjam', '<=', $request->tanggal_akhir);
                }

                $data = $query->get();

                break;

            case 'tunggakan':

                $data = Angsuran::with('pinjaman.nasabah')
                    ->where('status', 'belum_bayar')
                    ->whereDate('tanggal_jatuh_tempo', '<=', now())
                    ->get();

                break;

            case 'pelunasan':

                $data = Pinjaman::with('nasabah')
                    ->where('status', 'Lunas')
                    ->get();

                break;
        }

        return view('laporan.index', compact('jenis', 'data'));
    }

    public function pdfNasabah()
    {
        $data = Nasabah::all();

        $pdf = Pdf::loadView('laporan.pdf.nasabah', compact('data'))
            ->setPaper('A4', 'landscape');

        return $pdf->stream('Laporan_Data_Nasabah.pdf');
    }

    public function pdfPinjaman()
    {
        $data = Pinjaman::with('nasabah')
            ->orderBy('tanggal_pinjam', 'desc')
            ->get();

        $pdf = Pdf::loadView('laporan.pdf.pinjaman', compact('data'))
            ->setPaper('A4', 'landscape');

        return $pdf->stream('Laporan_Data_Pinjaman.pdf');
    }

    public function pdfAngsuran()
    {
        $data = Angsuran::with('pinjaman.nasabah')
            ->orderBy('tanggal_jatuh_tempo', 'desc')
            ->get();

        $pdf = Pdf::loadView('laporan.pdf.angsuran', compact('data'))
            ->setPaper('A4', 'landscape');

        return $pdf->stream('Laporan_Data_Angsuran.pdf');
    }

    public function pdfTunggakan()
    {
        $data = Angsuran::with('pinjaman.nasabah')
            ->where('status', 'belum_bayar')
            ->whereDate('tanggal_jatuh_tempo', '<=', now())
            ->orderBy('tanggal_jatuh_tempo')
            ->get();

        $pdf = Pdf::loadView('laporan.pdf.tunggakan', compact('data'))
            ->setPaper('A4', 'landscape');

        return $pdf->stream('Laporan_Data_Tunggakan.pdf');
    }

    public function pdfPelunasan()
    {
        $data = Pinjaman::with('nasabah')
            ->where('status', 'Lunas')
            ->orderBy('tanggal_pinjam', 'desc')
            ->get();

        $pdf = Pdf::loadView('laporan.pdf.pelunasan', compact('data'))
            ->setPaper('A4', 'landscape');

        return $pdf->stream('Laporan_Data_Pelunasan.pdf');
    }
}
