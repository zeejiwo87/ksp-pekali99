@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
        <h4 class="font-weight-bold py-3 mb-0">Dashboard</h4>
        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a>
                </li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>

        @php
            \Carbon\Carbon::setLocale('id');
        @endphp

        <div class="d-flex justify-content-end mb-2">
            <small class="text-muted">
                <i class="feather icon-calendar"></i>
                {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
            </small>
        </div>

        <div class="alert alert-dark-dark alert-dismissible fade show" role="alert">
            <h4 class="mb-1">
                Selamat Datang, <strong><u>{{ Auth::user()->name }}</u></strong>
            </h4>

            <p class="mb-0">
                Selamat bekerja di <strong class="text-warning">Sistem Informasi Penagihan Angsuran Berbasis Web</strong>
                KSP Pekali 99.
            </p>
        </div>

        <div class="row">
            <!-- 1st row Start -->
            <div class="col-lg-5">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="">
                                        <h2 class="mb-2">{{ $totalNasabah }}</h2>
                                        <p class="text-muted mb-0"><span class="badge badge-primary">NASABAH</span></p>
                                    </div>
                                    <div class="lnr lnr-users display-4 text-primary"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="">
                                        <h2 class="mb-2">{{ $totalUser }}</h2>
                                        <p class="text-muted mb-0"><span class="badge badge-warning">PENGGUNA</span></p>
                                    </div>
                                    <div class="lnr lnr-user display-4 text-warning"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h2>{{ $totalPinjaman }}</h2>
                                        <p class="mb-0">
                                            <span class="badge badge-success">PINJAMAN AKTIF</span>
                                        </p>
                                    </div>
                                    <div class="lnr lnr-license display-4 text-success"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h2>{{ $pinjamanLunas }}</h2>
                                        <p class="mb-0">
                                            <span class="badge badge-info">PINJAMAN LUNAS</span>
                                        </p>
                                    </div>
                                    <div class="lnr lnr-checkmark-circle display-4 text-info"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-lg-7">
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0">Grafik Pinjaman Bulanan</h6>
                    </div>

                    <div class="card-body">
                        <canvas id="statistics-chart-1" height="120"></canvas>
                    </div>
                </div>
            </div>
            <!-- 1st row Start -->
        </div>
        <div class="row">

            <!-- Angsuran Jatuh Tempo -->
            <div class="col-lg-7">
                <div class="card mb-4">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Angsuran Jatuh Tempo</h6>

                        <a href="{{ route('angsuran.index') }}" class="btn btn-sm btn-primary">
                            Lihat Semua
                        </a>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">

                            <table class="table table-bordered table-hover mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Nasabah</th>
                                        <th>Jatuh Tempo</th>
                                        <th>Tagihan</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($angsuranJatuhTempo as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->pinjaman->nasabah->nama }}</td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d-m-Y') }}
                                            </td>
                                            <td>
                                                Rp {{ number_format($item->jumlah_tagihan, 0, ',', '.') }}
                                            </td>
                                            <td>
                                                <span class="badge badge-danger">
                                                    Belum Bayar
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                Tidak ada angsuran yang jatuh tempo.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>
            </div>

            <!-- Nasabah Terbaru -->
            <div class="col-lg-5">

                <div class="card mb-4">

                    <div class="card-header">
                        <h6 class="mb-0">Nasabah Terbaru</h6>
                    </div>

                    <div class="card-body table-responsive">

                        <table id="tableNasabahTerbaru" class="table table-bordered table-hover">

                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Tanggal Daftar</th>
                                    <th>No HP</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse($nasabahTerbaru as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                                        <td>{{ $item->no_hp }}</td>
                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="2" class="text-center">
                                            Tidak ada data
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>
    </div>

    @section('scripts')

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            const ctx = document.getElementById('statistics-chart-1');

            new Chart(ctx, {
                type: 'bar',

                data: {
                    labels: @json($label),

                    datasets: [{
                        label: 'Jumlah Pinjaman',

                        data: @json($data),

                        borderWidth: 1
                    }]
                },

                options: {
                    responsive: true,

                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>

    @endsection
@endsection
