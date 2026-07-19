@extends('layouts.app')

@section('title', 'Pinjaman')

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
        <h4 class="font-weight-bold py-3 mb-0">Data Pinjaman</h4>
        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#"><i class="feather icon-home"></i></a>
                </li>
                <li class="breadcrumb-item active">Data Pinjaman</li>
            </ol>
        </div>

        @include('includes.alerts')

        <div class="row">
            <div class="col-sm-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="card-header-title mb-0">Data Pinjaman</h6>
                        @if(auth()->user()->role != 'pimpinan')
                        <a href="" class="btn btn-outline-info btn-sm ml-auto" data-toggle="modal"
                            data-target="#modalTambah">
                            Tambah Data
                        </a>
                        @endif

                        <!-- Modal Tambah -->
                        <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">Tambah Data Pinjaman</h5>
                                        <button type="button" class="close" data-dismiss="modal">
                                            <span>&times;</span>
                                        </button>
                                    </div>

                                    <form action="{{ route('pinjaman.store') }}" method="POST">
                                        @csrf

                                        <div class="modal-body">

                                            <div class="row">

                                                <!-- KODE PINJAMAN -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Kode Pinjaman</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $kodePinjaman }}" readonly>
                                                    </div>
                                                </div>

                                                <!-- NASABAH -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Nama Nasabah</label>
                                                        <select name="nasabah_id" id="nasabah_id"
                                                            class="form-control select2" required>
                                                            <option value="">-- Pilih Nasabah --</option>
                                                            @foreach ($nasabah as $n)
                                                                <option value="{{ $n->id }}">
                                                                    {{ $n->nik }} - {{ $n->nama }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- TANGGAL PINJAM -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Tanggal Pinjam</label>
                                                        <input type="date" name="tanggal_pinjam" class="form-control"
                                                            required>
                                                    </div>
                                                </div>

                                                <!-- JUMLAH PINJAMAN -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Jumlah Pinjaman</label>
                                                        <input type="number" name="jumlah_pinjaman" class="form-control"
                                                            placeholder="Contoh: 500000" required>
                                                    </div>
                                                </div>

                                                <!-- TENOR -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Lama Angsuran</label>
                                                        <input type="number" name="tenor" class="form-control"
                                                            placeholder="Contoh: 10" required>
                                                    </div>
                                                </div>

                                                <!-- SATUAN TENOR -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Satuan Tenor</label>
                                                        <select name="tenor_satuan" class="form-control" required>
                                                            <option value="minggu">Minggu</option>
                                                            <option value="bulan">Bulan</option>
                                                            <option value="tahun">Tahun</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- BUNGA -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Bunga (%)</label>
                                                        <input type="number" step="0.01" name="bunga_persen"
                                                            class="form-control" placeholder="Contoh: 1 atau 2.5" required>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">
                                                Simpan
                                            </button>

                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                Batal
                                            </button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                        <!-- Modal Tambah -->
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Nama Nasabah</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Pinjaman</th>
                                        <th>Tenor</th>
                                        <th>Bunga (%)</th>
                                        <th>Angsuran</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($pinjaman as $key => $item)
                                        <tr>
                                            <th>{{ $key + 1 }}</th>

                                            <!-- Kode Pinjaman -->
                                            <td>{{ $item->kode_pinjaman }}</td>

                                            <!-- Nama Nasabah -->
                                            <td>{{ $item->nasabah->nama }}</td>

                                            <!-- Tanggal -->
                                            <td>{{ $item->tanggal_pinjam }}</td>

                                            <!-- Pinjaman -->
                                            <td>Rp {{ number_format($item->jumlah_pinjaman, 0, ',', '.') }}</td>

                                            <!-- Tenor -->
                                            <td>
                                                {{ $item->tenor }} {{ ucfirst($item->tenor_satuan) }}
                                            </td>

                                            <!-- Bunga -->
                                            <td>{{ $item->bunga_persen }}%</td>

                                            <!-- Angsuran -->
                                            <td>
                                                Rp {{ number_format($item->angsuran_per_periode, 0, ',', '.') }}
                                            </td>

                                            <!-- Status -->
                                            <td>
                                                @if ($item->status == 'aktif')
                                                    <span class="badge badge-warning">Aktif</span>
                                                @elseif($item->status == 'lunas')
                                                    <span class="badge badge-success">Lunas</span>
                                                @else
                                                    <span class="badge badge-danger">Macet</span>
                                                @endif
                                            </td>

                                            <!-- Aksi -->
                                            <td>
                                                <a href="" class="btn btn-info btn-sm" data-toggle="modal"
                                                    data-target="#detailPinjaman{{ $item->id }}">
                                                    Detail
                                                </a>

                                                <div class="modal fade" id="detailPinjaman{{ $item->id }}"
                                                    tabindex="-1" role="dialog">

                                                    <div class="modal-dialog modal-lg" role="document">

                                                        <div class="modal-content">

                                                            <div class="modal-header">

                                                                <h5 class="modal-title">
                                                                    Detail Pinjaman
                                                                </h5>

                                                                <button type="button" class="close"
                                                                    data-dismiss="modal">

                                                                    <span>&times;</span>

                                                                </button>

                                                            </div>

                                                            <div class="modal-body">

                                                                <table class="table table-bordered">

                                                                    <tr>
                                                                        <th width="250">Kode Pinjaman</th>
                                                                        <td>{{ $item->kode_pinjaman }}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <th>Nama Nasabah</th>
                                                                        <td>{{ $item->nasabah->nama }}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <th>Jumlah Pinjaman</th>
                                                                        <td>
                                                                            Rp
                                                                            {{ number_format($item->jumlah_pinjaman, 0, ',', '.') }}
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <th>Bunga</th>
                                                                        <td>{{ $item->bunga_persen }}%</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <th>Tenor</th>
                                                                        <td>
                                                                            {{ $item->tenor }}
                                                                            {{ ucfirst($item->tenor_satuan) }}
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <th>Total Pinjaman</th>
                                                                        <td>
                                                                            Rp
                                                                            {{ number_format($item->total_pinjaman, 0, ',', '.') }}
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <th>Angsuran</th>
                                                                        <td>
                                                                            Rp
                                                                            {{ number_format($item->angsuran_per_periode, 0, ',', '.') }}
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <th>Tanggal Pinjam</th>
                                                                        <td>{{ $item->tanggal_pinjam }}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <th>Jatuh Tempo</th>
                                                                        <td>{{ $item->tanggal_jatuh_tempo }}</td>
                                                                    </tr>

                                                                </table>

                                                                <h5 class="mt-3">
                                                                    Riwayat Angsuran
                                                                </h5>

                                                                <table class="table table-bordered">

                                                                    <thead>
                                                                        <tr>
                                                                            <th>Ke</th>
                                                                            <th>Jatuh Tempo</th>
                                                                            <th>Tagihan</th>
                                                                            <th>Status</th>
                                                                        </tr>
                                                                    </thead>

                                                                    <tbody>

                                                                        @forelse($item->angsuran as $angsuran)
                                                                            <tr>

                                                                                <td>{{ $angsuran->angsuran_ke }}</td>

                                                                                <td>
                                                                                    {{ \Carbon\Carbon::parse($angsuran->tanggal_jatuh_tempo)->format('d-m-Y') }}
                                                                                </td>

                                                                                <td>
                                                                                    Rp
                                                                                    {{ number_format($angsuran->jumlah_tagihan, 0, ',', '.') }}
                                                                                </td>

                                                                                <td>

                                                                                    @if ($angsuran->status == 'lunas')
                                                                                        <span class="badge badge-success">
                                                                                            Lunas
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
                                                                                <td colspan="4" class="text-center">
                                                                                    Belum ada data angsuran
                                                                                </td>
                                                                            </tr>
                                                                        @endforelse

                                                                    </tbody>

                                                                </table>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                                {{-- Edit --}}
                                                @if(auth()->user()->role != 'pimpinan')
                                                <button class="btn btn-warning btn-sm" data-toggle="modal"
                                                    data-target="#modalEdit{{ $item->id }}">
                                                    Edit
                                                </button>
                                                @endif

                                                <!-- Modal Edit -->
                                                <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1"
                                                    role="dialog">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">

                                                            <div class="modal-header">
                                                                <h5 class="modal-title">
                                                                    Edit Data Pinjaman
                                                                </h5>

                                                                <button type="button" class="close"
                                                                    data-dismiss="modal">
                                                                    <span>&times;</span>
                                                                </button>
                                                            </div>

                                                            <form action="{{ route('pinjaman.update', $item->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')

                                                                <div class="modal-body">

                                                                    <div class="row">

                                                                        <!-- Kode -->
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label>Kode Pinjaman</label>
                                                                                <input type="text" class="form-control"
                                                                                    value="{{ $item->kode_pinjaman }}"
                                                                                    readonly>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Nasabah -->
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label>Nama Nasabah</label>

                                                                                <select name="nasabah_id"
                                                                                    class="form-control select2" required>

                                                                                    @foreach ($nasabah as $n)
                                                                                        <option
                                                                                            value="{{ $n->id }}"
                                                                                            {{ $item->nasabah_id == $n->id ? 'selected' : '' }}>
                                                                                            {{ $n->nik }} -
                                                                                            {{ $n->nama }}
                                                                                        </option>
                                                                                    @endforeach

                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Tanggal Pinjam -->
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label>Tanggal Pinjam</label>

                                                                                <input type="date"
                                                                                    name="tanggal_pinjam"
                                                                                    class="form-control"
                                                                                    value="{{ $item->tanggal_pinjam }}"
                                                                                    required>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Jumlah -->
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label>Jumlah Pinjaman</label>

                                                                                <input type="number"
                                                                                    name="jumlah_pinjaman"
                                                                                    class="form-control"
                                                                                    value="{{ $item->jumlah_pinjaman }}"
                                                                                    required>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Tenor -->
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label>Lama Angsuran</label>

                                                                                <input type="number" name="tenor"
                                                                                    class="form-control"
                                                                                    value="{{ $item->tenor }}" required>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Satuan -->
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label>Satuan Tenor</label>

                                                                                <select name="tenor_satuan"
                                                                                    class="form-control" required>

                                                                                    <option value="minggu"
                                                                                        {{ $item->tenor_satuan == 'minggu' ? 'selected' : '' }}>
                                                                                        Minggu
                                                                                    </option>

                                                                                    <option value="bulan"
                                                                                        {{ $item->tenor_satuan == 'bulan' ? 'selected' : '' }}>
                                                                                        Bulan
                                                                                    </option>

                                                                                    <option value="tahun"
                                                                                        {{ $item->tenor_satuan == 'tahun' ? 'selected' : '' }}>
                                                                                        Tahun
                                                                                    </option>

                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Bunga -->
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label>Bunga (%)</label>

                                                                                <input type="number" step="0.01"
                                                                                    name="bunga_persen"
                                                                                    class="form-control"
                                                                                    value="{{ $item->bunga_persen }}"
                                                                                    required>
                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                </div>

                                                                <div class="modal-footer">

                                                                    <button class="btn btn-primary">
                                                                        Simpan Perubahan
                                                                    </button>

                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">
                                                                        Batal
                                                                    </button>

                                                                </div>

                                                            </form>

                                                        </div>
                                                    </div>
                                                </div>

                                                <form action="{{ route('pinjaman.destroy', $item->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    @if (auth()->user()->role != 'pimpinan')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Yakin hapus data?')">
                                                            Hapus
                                                        </button>
                                                    @endif
                                                </form>
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
@endsection
