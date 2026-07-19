@extends('layouts.app')

@section('title', 'Laporan Data Angsuran')

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">

        <h4 class="font-weight-bold py-3 mb-0">
            Laporan Data Angsuran
        </h4>

        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#"><i class="feather icon-home"></i></a>
                </li>
                <li class="breadcrumb-item active">
                    Laporan Data Angsuran
                </li>
            </ol>
        </div>

        <div class="card">

            <div class="card-header">
                <h6 class="mb-0">
                    Menu Laporan
                </h6>
            </div>

            <div class="card-body">

                <a href="{{ route('laporan.index') }}" class="btn btn-secondary btn-sm mr-2">

                    <i class="feather icon-refresh-cw"></i>
                    Reset

                </a>

                <a href="{{ route('laporan.angsuran.pdf') }}" class="btn btn-danger btn-sm mr-2">

                    <i class="feather icon-file-text"></i>
                    PDF

                </a>

                {{-- <a href="#" class="btn btn-success btn-sm">

                    <i class="feather icon-download"></i>
                    Excel

                </a> --}}

            </div>

        </div>

        <div class="card mt-4">

            <div class="card-header">
                <h6 class="mb-0">
                    Hasil Laporan
                </h6>
            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table id="example" class="table table-bordered table-hover">

                        <thead class="text-center">

                            <tr>

                                <th>No</th>

                                <th>Kode Pinjaman</th>

                                <th>Nama Nasabah</th>

                                <th>Total Angsuran</th>

                                <th>Sudah Dibayar</th>

                                <th>Sisa</th>

                                <th>Jatuh Tempo Berikutnya</th>

                                <th>Status</th>

                                <th width="8%">
                                    Detail
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($data as $item)
                                @php

                                    $total = $item->angsuran->count();

                                    $dibayar = $item->angsuran->where('status', 'lunas')->count();

                                    $sisa = $total - $dibayar;

                                    $berikutnya = $item->angsuran
                                        ->where('status', '!=', 'lunas')
                                        ->sortBy('angsuran_ke')
                                        ->first();

                                @endphp

                                <tr>

                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>
                                        {{ $item->kode_pinjaman }}
                                    </td>

                                    <td>
                                        {{ $item->nasabah->nama }}
                                    </td>

                                    <td class="text-center">
                                        {{ $total }}
                                    </td>

                                    <td class="text-center">
                                        {{ $dibayar }}
                                    </td>

                                    <td class="text-center">
                                        {{ $sisa }}
                                    </td>

                                    <td class="text-center">

                                        @if ($berikutnya)
                                            {{ \Carbon\Carbon::parse($berikutnya->tanggal_jatuh_tempo)->format('d-m-Y') }}
                                        @else
                                            -
                                        @endif

                                    </td>

                                    <td class="text-center">

                                        @if ($item->status == 'lunas')
                                            <span class="badge badge-success">
                                                Lunas
                                            </span>
                                        @elseif($berikutnya && $berikutnya->tanggal_jatuh_tempo < now())
                                            <span class="badge badge-danger">
                                                Menunggak
                                            </span>
                                        @else
                                            <span class="badge badge-primary">
                                                Aktif
                                            </span>
                                        @endif

                                    </td>

                                    <td class="text-center">

                                        <button class="btn btn-info btn-sm" data-toggle="modal"
                                            data-target="#detail{{ $item->id }}">

                                            <i class="feather icon-eye"></i>

                                        </button>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="9" class="text-center">

                                        Tidak ada data angsuran.

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

    {{-- ================= MODAL DETAIL ================= --}}

    @foreach ($data as $item)
        <div class="modal fade" id="detail{{ $item->id }}" tabindex="-1">

            <div class="modal-dialog modal-lg">

                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title">

                            Detail Angsuran

                        </h5>

                        <button type="button" class="close" data-dismiss="modal">

                            <span>&times;</span>

                        </button>

                    </div>

                    <div class="modal-body">

                        <table class="table table-bordered">

                            <thead class="text-center">

                                <tr>

                                    <th>Ke</th>

                                    <th>Jatuh Tempo</th>

                                    <th>Tanggal Bayar</th>

                                    <th>Jumlah</th>

                                    <th>Status</th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach ($item->angsuran as $a)
                                    <tr>

                                        <td class="text-center">

                                            {{ $a->angsuran_ke }}

                                        </td>

                                        <td class="text-center">

                                            {{ \Carbon\Carbon::parse($a->tanggal_jatuh_tempo)->format('d-m-Y') }}

                                        </td>

                                        <td class="text-center">

                                            @if ($a->tanggal_bayar)
                                                {{ \Carbon\Carbon::parse($a->tanggal_bayar)->format('d-m-Y') }}
                                            @else
                                                -
                                            @endif

                                        </td>

                                        <td class="text-right">

                                            Rp {{ number_format($a->jumlah_angsuran, 0, ',', '.') }}

                                        </td>

                                        <td class="text-center">

                                            @if ($a->status == 'lunas')
                                                <span class="badge badge-success">

                                                    Lunas

                                                </span>
                                            @elseif($a->tanggal_jatuh_tempo < now())
                                                <span class="badge badge-danger">

                                                    Menunggak

                                                </span>
                                            @else
                                                <span class="badge badge-warning">

                                                    Belum Bayar

                                                </span>
                                            @endif

                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>
    @endforeach

@endsection
