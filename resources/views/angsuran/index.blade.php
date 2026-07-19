@extends('layouts.app')

@section('title', 'Angsuran')

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">

        <h4 class="font-weight-bold py-3 mb-0">
            Data Penagihan Angsuran
        </h4>

        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">
                        <i class="feather icon-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item active">
                    Data Penagihan Angsuran
                </li>
            </ol>
        </div>

        <!-- Statistik -->
        <div class="row mb-3">

            <div class="col-md-3">
                <div class="card border-left-warning">
                    <div class="card-body text-center">
                        <h3>{{ $tagihanHariIni }}</h3>
                        <small>Tagihan Hari Ini</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-left-primary">
                    <div class="card-body text-center">
                        <h3>{{ $belumBayar }}</h3>
                        <small>Belum Bayar</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-left-success">
                    <div class="card-body text-center">
                        <h3>{{ $dibayar }}</h3>
                        <small>Sudah Bayar</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-left-danger">
                    <div class="card-body text-center">
                        <h3>{{ $tunggakan }}</h3>
                        <small>Tunggakan</small>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-sm-12">

                <div class="card mb-4">

                    <div class="card-header">

                        <!-- Filter Tanggal -->
                        <form action="{{ route('angsuran.index') }}" method="GET" class="mb-3">

                            <div class="form-row align-items-end">

                                <div class="col-md-3">
                                    <label><strong>Filter Tanggal</strong></label>

                                    <input type="date" name="tanggal" class="form-control form-control-sm bg-light"
                                        value="{{ request('tanggal') }}">
                                </div>

                                <div class="col-md-3">

                                    <button type="submit" class="btn btn-primary btn-sm">
                                        Filter
                                    </button>

                                    <a href="{{ route('angsuran.index') }}" class="btn btn-secondary btn-sm">
                                        Reset
                                    </a>

                                </div>

                            </div>

                        </form>

                        <!-- Tombol Menu -->
                        <div>

                            <a href="{{ route('angsuran.index') }}" class="btn btn-warning btn-sm">
                                Tagihan Hari Ini
                            </a>

                            <a href="{{ route('angsuran.index', ['filter' => 'tunggakan']) }}"
                                class="btn btn-danger btn-sm">
                                Tunggakan
                            </a>

                        </div>

                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-bordered table-hover">

                                <thead class="text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Nasabah</th>
                                        <th>Tagihan Hari Ini</th>
                                        <th>Jatuh Tempo</th>
                                        <th>Status</th>
                                        <th width="180">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach ($angsuran as $key => $item)
                                        <tr>

                                            <td class="text-center">
                                                {{ $key + 1 }}
                                            </td>

                                            <td>
                                                <strong>
                                                    {{ $item->pinjaman->nasabah->nama }}
                                                </strong>
                                                <br>

                                                <small class="text-muted">
                                                    {{ $item->pinjaman->kode_pinjaman }}
                                                </small>
                                            </td>

                                            <td>
                                                <strong>
                                                    Rp {{ number_format($item->jumlah_tagihan, 0, ',', '.') }}
                                                </strong>
                                                <br>

                                                <small class="text-muted">
                                                    Angsuran ke {{ $item->angsuran_ke }}
                                                    dari {{ $item->pinjaman->tenor }}
                                                </small>
                                            </td>

                                            <td>
                                                {{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d-m-Y') }}
                                            </td>

                                            <td>

                                                @if ($item->status == 'lunas')
                                                    <span class="badge badge-success">
                                                        Sudah Dibayar
                                                    </span>
                                                @elseif($item->tanggal_jatuh_tempo < now()->toDateString())
                                                    <span class="badge badge-danger">
                                                        Tunggakan
                                                    </span>
                                                @else
                                                    <span class="badge badge-warning">
                                                        Belum Dibayar
                                                    </span>
                                                @endif

                                            </td>

                                            <td class="text-center">

                                                @if ($item->status == 'belum_bayar')
                                                    @if (auth()->user()->role != 'pimpinan')
                                                        <button class="btn btn-success btn-sm" data-toggle="modal"
                                                            data-target="#bayarAngsuran{{ $item->id }}">
                                                            Bayar
                                                        </button>
                                                    @endif

                                                    <!-- Tombol WA -->
                                                    @if (auth()->user()->role != 'pimpinan')
                                                        <form action="{{ route('angsuran.kirimWa', $item->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-warning btn-sm">
                                                                WA
                                                            </button>
                                                        </form>
                                                    @endif
                                                    </form>

                                                    {{-- Modal Bayar Angsuran --}}
                                                    <div class="modal fade" id="bayarAngsuran{{ $item->id }}"
                                                        tabindex="-1">

                                                        <div class="modal-dialog">

                                                            <div class="modal-content">

                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">
                                                                        Bayar Angsuran
                                                                    </h5>

                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal">

                                                                        <span>&times;</span>

                                                                    </button>
                                                                </div>

                                                                <form action="{{ route('angsuran.bayar', $item->id) }}"
                                                                    method="POST">

                                                                    @csrf

                                                                    <div class="modal-body">

                                                                        <table class="table table-bordered">

                                                                            <tr>
                                                                                <th>Nasabah</th>
                                                                                <td>{{ $item->pinjaman->nasabah->nama }}
                                                                                </td>
                                                                            </tr>

                                                                            <tr>
                                                                                <th>Kode Pinjaman</th>
                                                                                <td>{{ $item->pinjaman->kode_pinjaman }}
                                                                                </td>
                                                                            </tr>

                                                                            <tr>
                                                                                <th>Angsuran Ke</th>
                                                                                <td>
                                                                                    {{ $item->angsuran_ke }}
                                                                                    /
                                                                                    {{ $item->pinjaman->tenor }}
                                                                                </td>
                                                                            </tr>

                                                                            <tr>
                                                                                <th>Tagihan</th>
                                                                                <td>
                                                                                    Rp
                                                                                    {{ number_format($item->jumlah_tagihan, 0, ',', '.') }}
                                                                                </td>
                                                                            </tr>

                                                                        </table>

                                                                    </div>

                                                                    <div class="modal-footer">

                                                                        <button type="submit" class="btn btn-success btn-sm">

                                                                            Konfirmasi Bayar

                                                                        </button>

                                                                        <button type="button" class="btn btn-secondary btn-sm"
                                                                            data-dismiss="modal">

                                                                            Batal

                                                                        </button>

                                                                    </div>

                                                                </form>

                                                            </div>

                                                        </div>

                                                    </div>
                                                @endif

                                                <button class="btn btn-info btn-sm" data-toggle="modal"
                                                    data-target="#detailAngsuran{{ $item->id }}">
                                                    Detail
                                                </button>

                                                <!-- Modal Detail -->
                                                <div class="modal fade" id="detailAngsuran{{ $item->id }}"
                                                    tabindex="-1" aria-hidden="true">

                                                    <div class="modal-dialog modal-lg">

                                                        <div class="modal-content">

                                                            <div class="modal-header bg-secondary text-white">

                                                                <h5 class="modal-title">
                                                                    Detail Angsuran
                                                                </h5>

                                                                <button type="button" class="close text-white"
                                                                    data-dismiss="modal">
                                                                    <span>&times;</span>
                                                                </button>

                                                            </div>

                                                            <div class="modal-body">

                                                                <table class="table table-bordered">

                                                                    <tr>
                                                                        <th width="35%">Kode Pinjaman</th>
                                                                        <td>{{ $item->pinjaman->kode_pinjaman }}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <th>Nama Nasabah</th>
                                                                        <td>{{ $item->pinjaman->nasabah->nama }}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <th>No. HP</th>
                                                                        <td>{{ $item->pinjaman->nasabah->no_hp }}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <th>Jumlah Pinjaman</th>
                                                                        <td>
                                                                            Rp
                                                                            {{ number_format($item->pinjaman->jumlah_pinjaman, 0, ',', '.') }}
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <th>Bunga</th>
                                                                        <td>{{ $item->pinjaman->bunga_persen }} %</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <th>Tenor</th>
                                                                        <td>
                                                                            {{ $item->pinjaman->tenor }}
                                                                            {{ ucfirst($item->pinjaman->tenor_satuan) }}
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <th>Total Pinjaman</th>
                                                                        <td>
                                                                            Rp
                                                                            {{ number_format($item->pinjaman->total_pinjaman, 0, ',', '.') }}
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <th>Angsuran Ke</th>
                                                                        <td>
                                                                            {{ $item->angsuran_ke }}
                                                                            /
                                                                            {{ $item->pinjaman->tenor }}
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <th>Jumlah Tagihan</th>
                                                                        <td>
                                                                            Rp
                                                                            {{ number_format($item->jumlah_tagihan, 0, ',', '.') }}
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <th>Tanggal Jatuh Tempo</th>
                                                                        <td>
                                                                            {{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d-m-Y') }}
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <th>Status Angsuran</th>
                                                                        <td>

                                                                            @if ($item->status == 'lunas')
                                                                                <span class="badge badge-success">
                                                                                    Lunas
                                                                                </span>
                                                                            @elseif($item->tanggal_jatuh_tempo < now()->toDateString())
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

                                                                    <tr>
                                                                        <th>Tanggal Bayar</th>
                                                                        <td>
                                                                            {{ $item->tanggal_bayar ? \Carbon\Carbon::parse($item->tanggal_bayar)->format('d-m-Y H:i') : '-' }}
                                                                        </td>
                                                                    </tr>

                                                                </table>

                                                            </div>

                                                            <div class="modal-footer">

                                                                <button type="button" class="btn btn-secondary btn-sm"
                                                                    data-dismiss="modal">

                                                                    Tutup

                                                                </button>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                            </td>

                                        </tr>
                                    @endforeach


                                </tbody>

                            </table>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>

    <!-- Modal Bayar -->
    <div class="modal fade" id="modalBayar" tabindex="-1">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">
                        Pembayaran Angsuran
                    </h5>

                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <form>

                    <div class="modal-body">

                        <div class="form-group">
                            <label>Kode Pinjaman</label>
                            <input type="text" class="form-control" value="PJ001" readonly>
                        </div>

                        <div class="form-group">
                            <label>Nasabah</label>
                            <input type="text" class="form-control" value="Rahmawati" readonly>
                        </div>

                        <div class="form-group">
                            <label>Angsuran Ke</label>
                            <input type="text" class="form-control" value="3 / 10" readonly>
                        </div>

                        <div class="form-group">
                            <label>Tagihan</label>
                            <input type="text" class="form-control" value="Rp 130.000" readonly>
                        </div>

                        <div class="form-group">
                            <label>Tanggal Bayar</label>
                            <input type="date" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Jumlah Bayar</label>
                            <input type="number" class="form-control" value="130000">
                        </div>

                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea class="form-control" rows="3"></textarea>
                        </div>

                    </div>

                    <div class="modal-footer">

                        <button class="btn btn-success btn-sm">
                            Simpan Pembayaran
                        </button>

                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">

                            Batal

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <!-- Modal Detail -->
    <div class="modal fade" id="modalDetail" tabindex="-1">

        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">
                        Detail Pinjaman
                    </h5>

                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <table class="table table-bordered">

                        <tr>
                            <th width="250">Kode Pinjaman</th>
                            <td>PJ001</td>
                        </tr>

                        <tr>
                            <th>Nasabah</th>
                            <td>Rahmawati</td>
                        </tr>

                        <tr>
                            <th>Jumlah Pinjaman</th>
                            <td>Rp 1.000.000</td>
                        </tr>

                        <tr>
                            <th>Bunga</th>
                            <td>3%</td>
                        </tr>

                        <tr>
                            <th>Tenor</th>
                            <td>10 Minggu</td>
                        </tr>

                        <tr>
                            <th>Angsuran Per Minggu</th>
                            <td>Rp 130.000</td>
                        </tr>

                        <tr>
                            <th>Total Tagihan</th>
                            <td>Rp 1.300.000</td>
                        </tr>

                        <tr>
                            <th>Sudah Dibayar</th>
                            <td>Rp 390.000</td>
                        </tr>

                        <tr>
                            <th>Sisa Tagihan</th>
                            <td>Rp 910.000</td>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge badge-warning">
                                    Aktif
                                </span>
                            </td>
                        </tr>

                    </table>

                </div>

            </div>

        </div>

    </div>
@endsection
