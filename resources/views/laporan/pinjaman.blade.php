@extends('layouts.app')

@section('title', 'Laporan Data Pinjaman')

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">

        <h4 class="font-weight-bold py-3 mb-0">Laporan Data Pinjaman</h4>

        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#"><i class="feather icon-home"></i></a>
                </li>
                <li class="breadcrumb-item active">Laporan Data Pinjaman</li>
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

                            <a href="{{ route('laporan.pinjaman.pdf') }}" class="btn btn-danger btn-sm mr-2 mb-2">
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
                                <th>Kode Nasabah</th>
                                <th>Nama Nasabah</th>
                                <th>Tanggal Pinjam</th>
                                <th>Jumlah Pinjaman</th>
                                <th>Tenor</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($data as $item)
                                <tr>

                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>{{ $item->kode_pinjaman }}</td>

                                    <td>{{ $item->nasabah->kode_nasabah }}</td>

                                    <td>{{ $item->nasabah->nama }}</td>

                                    <td>
                                        {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d-m-Y') }}
                                    </td>

                                    <td>
                                        Rp {{ number_format($item->jumlah_pinjaman, 0, ',', '.') }}
                                    </td>

                                    <td>
                                        {{ $item->tenor }} {{ ucfirst($item->tenor_satuan) }}
                                    </td>

                                    <td class="text-center">

    @if($item->status == 'aktif')

        <span class="badge badge-primary">
            Aktif
        </span>

    @elseif($item->status == 'lunas')

        <span class="badge badge-success">
            Lunas
        </span>

    @else

        <span class="badge badge-danger">
            Macet
        </span>

    @endif

</td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="8" class="text-center">
                                        Tidak ada data pinjaman.
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
