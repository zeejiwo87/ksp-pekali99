@extends('layouts.app')

@section('title', 'Laporan Data Tunggakan')

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">

        <h4 class="font-weight-bold py-3 mb-0">Laporan Data Tunggakan</h4>

        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#"><i class="feather icon-home"></i></a>
                </li>
                <li class="breadcrumb-item active">Laporan Data Tunggakan</li>
            </ol>
        </div>

        <div class="card">

            <div class="card-header">
                <h6 class="mb-0">Filter Laporan</h6>
            </div>

            <div class="card-body">

                <form method="GET" action="{{ route('laporan.index') }}">

                    <div class="col-md-12 mt-3">

                        <div class="d-flex flex-wrap gap-2">

                            <a href="{{ route('laporan.index') }}" class="btn btn-secondary btn-sm mr-2 mb-2">
                                <i class="feather icon-refresh-cw"></i> Reset
                            </a>

                            <a href="{{ route('laporan.tunggakan.pdf') }}" class="btn btn-danger btn-sm mr-2 mb-2">
                                <i class="feather icon-file-text"></i> PDF
                            </a>

                            {{-- <a href="#" class="btn btn-success btn-sm mb-2">
                                <i class="feather icon-download"></i> Excel
                            </a> --}}

                        </div>

                    </div>

                </form>

            </div>

        </div>

        <div class="card mt-4">

            <div class="card-header">
                <h6 class="mb-0">Hasil Laporan</h6>
            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table id="example" class="table table-bordered table-hover">

                        <thead class="text-center">
                            <tr>
                                <th width="5%">No</th>
                                <th>Kode Pinjaman</th>
                                <th>Nama Nasabah</th>
                                <th>Angsuran Ke</th>
                                <th>Tanggal Jatuh Tempo</th>
                                <th>Jumlah Tagihan</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($data as $item)
                                <tr>

                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>
                                        {{ $item->pinjaman->kode_pinjaman }}
                                    </td>

                                    <td>
                                        {{ $item->pinjaman->nasabah->nama }}
                                    </td>

                                    <td class="text-center">
                                        {{ $item->angsuran_ke }}
                                    </td>

                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d-m-Y') }}
                                    </td>

                                    <td class="text-right">
                                        Rp {{ number_format($item->jumlah_tagihan, 0, ',', '.') }}
                                    </td>

                                    <td class="text-center">

                                        @if ($item->status == 'lunas')
                                            <span class="badge badge-success">
                                                Lunas
                                            </span>
                                        @elseif($item->status == 'belum_bayar' && \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->lt(\Carbon\Carbon::today()))
                                            <span class="badge badge-danger">
                                                Tunggakan
                                            </span>
                                        @else
                                            <span class="badge badge-warning">
                                                Belum Bayar
                                            </span>
                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="7" class="text-center">
                                        Tidak ada data tunggakan.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>
@endsection
