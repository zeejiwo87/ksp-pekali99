@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">

        <h4 class="font-weight-bold py-3 mb-0">Laporan</h4>

        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#"><i class="feather icon-home"></i></a>
                </li>
                <li class="breadcrumb-item active">Laporan</li>
            </ol>
        </div>

        <div class="card">

            <div class="card-header">
                <h6 class="mb-0">Filter Laporan</h6>
            </div>

            <div class="card-body">

                <form method="GET" action="{{ route('laporan.index') }}">

                    <div class="row">

                        <div class="col-md-4">
                            <label>Jenis Laporan</label>
                            <select name="jenis" class="form-control">
                                <option value="">-- Pilih Jenis Laporan --</option>
                                <option value="nasabah">Data Nasabah</option>
                                <option value="pinjaman">Data Pinjaman</option>
                                <option value="angsuran">Data Angsuran</option>
                                <option value="tunggakan">Data Tunggakan</option>
                                <option value="pelunasan">Data Pelunasan</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Tanggal Awal</label>
                            <input type="date" name="tanggal_awal" class="form-control"
                                value="{{ request('tanggal_awal') }}">
                        </div>

                        <div class="col-md-3">
                            <label>Tanggal Akhir</label>
                            <input type="date" name="tanggal_akhir" class="form-control"
                                value="{{ request('tanggal_akhir') }}">
                        </div>

                        <div class="col-md-2 d-flex align-items-end">

                            <button class="btn btn-primary mr-2">
                                <i class="feather icon-search"></i> Tampilkan
                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>

        <div class="card mt-4">

            <div class="card-header d-flex justify-content-between">

                <h6 class="mb-0">Hasil Laporan</h6>

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    @if ($jenis == 'nasabah')
                        @include('laporan.nasabah')
                    @elseif($jenis == 'pinjaman')
                        @include('laporan.pinjaman')
                    @elseif($jenis == 'angsuran')
                        @include('laporan.angsuran')
                    @elseif($jenis == 'tunggakan')
                        @include('laporan.tunggakan')
                    @elseif($jenis == 'pelunasan')
                        @include('laporan.pelunasan')
                    @else
                        <div class="text-center py-5">
                            <h5>Silakan pilih jenis laporan terlebih dahulu.</h5>
                        </div>
                    @endif

                </div>

            </div>

        </div>

    </div>
@endsection
