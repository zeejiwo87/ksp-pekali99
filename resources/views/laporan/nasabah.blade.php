@extends('layouts.app')

@section('title', 'Laporan Data Nasabah')

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">

        <h4 class="font-weight-bold py-3 mb-0">Laporan Data Nasabah</h4>

        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#"><i class="feather icon-home"></i></a>
                </li>
                <li class="breadcrumb-item active">Laporan Data Nasabah</li>
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

                            <a href="{{ route('laporan.nasabah.pdf') }}" class="btn btn-danger btn-sm mr-2 mb-2">
                                <i class="feather icon-file-text"></i> 
                                PDF
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
                                <th>Foto</th>
                                <th>Kode Nasabah</th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>No HP</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($data as $item)
                                <tr>

                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="text-center">

                                        @if ($item->foto)
                                            <img src="{{ asset('anggota/foto/' . $item->foto) }}" width="50"
                                                height="50" class="rounded-circle" style="object-fit:cover;">
                                        @else
                                            <img src="{{ asset('assets/img/avatars/1.png') }}" width="50" height="50"
                                                class="rounded-circle">
                                        @endif

                                    </td>

                                    <td>{{ $item->kode_nasabah }}</td>

                                    <td>{{ $item->nik }}</td>

                                    <td>{{ $item->nama }}</td>

                                    <td>
                                        {{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                    </td>

                                    <td>{{ $item->no_hp }}</td>

                                    <td class="text-center">

                                        @if ($item->status == 'aktif')
                                            <span class="badge badge-success">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="badge badge-danger">
                                                Nonaktif
                                            </span>
                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="8" class="text-center">
                                        Tidak ada data nasabah.
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
