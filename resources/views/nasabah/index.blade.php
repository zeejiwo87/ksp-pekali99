@extends('layouts.app')

@section('title', 'Nasabah')

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
        <h4 class="font-weight-bold py-3 mb-0">Data Nasabah</h4>
        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#"><i class="feather icon-home"></i></a>
                </li>
                <li class="breadcrumb-item active">Data Nasabah</li>
            </ol>
        </div>

        @include('includes.alerts')

        <div class="row">
            <div class="col-sm-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="card-header-title mb-0">Data Nasabah</h6>
                        @if (auth()->user()->role != 'pimpinan')
                            <a href="#" class="btn btn-outline-info btn-sm ml-auto" data-toggle="modal"
                                data-target="#modalNasabah">
                                Tambah Data
                            </a>
                        @endif

                        <form action="{{ route('nasabah.index') }}" method="GET" class="d-flex align-items-center mt-3">

                            <!-- SELECT -->
                            <select name="status" class="form-control form-control-sm bg-light mr-2" style="width: 180px;">

                                <option value="">
                                    -- Semua Data --
                                </option>

                                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>

                                    Aktif
                                </option>

                                <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>

                                    Nonaktif
                                </option>

                                <option value="trash" {{ request('status') == 'trash' ? 'selected' : '' }}>

                                    Trash
                                </option>

                            </select>

                            <!-- BUTTON -->
                            <button type="submit" class="btn btn-primary btn-sm">

                                Filter
                            </button>

                        </form>

                        <!-- Modal Tambah Nasabah -->
                        <div class="modal fade" id="modalNasabah" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">
                                            Tambah Data Nasabah
                                        </h5>

                                        <button type="button" class="close" data-dismiss="modal">
                                            <span>&times;</span>
                                        </button>
                                    </div>

                                    <form action="{{ route('nasabah.store') }}" method="POST"
                                        enctype="multipart/form-data">

                                        @csrf

                                        <div class="modal-body">

                                            <div class="row">

                                                <!-- Kode Nasabah -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Kode Nasabah</label>

                                                        <input type="text" name="kode_nasabah" class="form-control"
                                                            value="{{ $kodeNasabah }}" readonly>
                                                    </div>
                                                </div>

                                                <!-- NIK -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>NIK</label>

                                                        <input type="text" name="nik" class="form-control"
                                                            placeholder="Masukkan NIK">
                                                    </div>
                                                </div>

                                                <!-- Nama -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Nama Nasabah</label>

                                                        <input type="text" name="nama" class="form-control"
                                                            placeholder="Masukkan nama">
                                                    </div>
                                                </div>

                                                <!-- Jenis Kelamin -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Jenis Kelamin</label>

                                                        <select name="jenis_kelamin" class="form-control">

                                                            <option value="">
                                                                -- Pilih --
                                                            </option>

                                                            <option value="L">
                                                                Laki-laki
                                                            </option>

                                                            <option value="P">
                                                                Perempuan
                                                            </option>

                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Tempat Lahir -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Tempat Lahir</label>

                                                        <input type="text" name="tempat_lahir" class="form-control"
                                                            placeholder="Masukkan tempat lahir">
                                                    </div>
                                                </div>

                                                <!-- Tanggal Lahir -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Tanggal Lahir</label>

                                                        <input type="date" name="tanggal_lahir" class="form-control">
                                                    </div>
                                                </div>

                                                <!-- No HP -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>No HP</label>

                                                        <input type="text" name="no_hp" class="form-control"
                                                            placeholder="Masukkan nomor HP">
                                                    </div>
                                                </div>

                                                <!-- Pekerjaan -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Pekerjaan</label>

                                                        <select name="pekerjaan" class="form-control">

                                                            <option value="">-- Pilih Pekerjaan --</option>

                                                            <option value="Petani">Petani</option>
                                                            <option value="Pedagang">Pedagang</option>
                                                            <option value="Wiraswasta">Wiraswasta</option>
                                                            <option value="Karyawan Swasta">Karyawan Swasta</option>
                                                            <option value="PNS">PNS</option>
                                                            <option value="Guru">Guru</option>
                                                            <option value="Nelayan">Nelayan</option>
                                                            <option value="Buruh">Buruh</option>
                                                            <option value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
                                                            <option value="Lainnya">Lainnya</option>

                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Pendapatan</label>

                                                        <select name="pendapatan" class="form-control" required>
                                                            <option value="">-- Pilih Pendapatan --</option>

                                                            <option value="500000">
                                                                Rp 500.000 - Rp 1.000.000
                                                            </option>

                                                            <option value="1000000">
                                                                Rp 1.000.001 - Rp 2.000.000
                                                            </option>

                                                            <option value="2000000">
                                                                Rp 2.000.001 - Rp 3.000.000
                                                            </option>

                                                            <option value="3000000">
                                                                Di atas Rp 3.000.000
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Tanggal Daftar -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Tanggal Daftar</label>

                                                        <input type="date" name="tanggal_daftar" class="form-control"
                                                            value="{{ date('Y-m-d') }}">
                                                    </div>
                                                </div>

                                                <!-- Status -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Status</label>

                                                        <select name="status" class="form-control">

                                                            <option value="aktif">
                                                                Aktif
                                                            </option>

                                                            <option value="nonaktif">
                                                                Nonaktif
                                                            </option>

                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Alamat -->
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Alamat</label>

                                                        <textarea name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat"></textarea>
                                                    </div>
                                                </div>

                                                <!-- Foto -->
                                                <div class="col-md-12">

                                                    <div class="form-group">
                                                        <label>Foto Nasabah</label>

                                                        <!-- PILIH METODE -->
                                                        <select id="pilihFoto" class="form-control mb-3">
                                                            <option value="upload">Upload Foto</option>
                                                            <option value="kamera">Kamera Real Time</option>
                                                        </select>

                                                        <!-- UPLOAD FOTO -->
                                                        <div id="uploadFoto">
                                                            <input type="file" name="foto" class="form-control">
                                                        </div>

                                                        <!-- KAMERA -->
                                                        <div id="kameraFoto" style="display:none;">

                                                            <video id="video" width="100%" height="300" autoplay
                                                                class="border rounded">
                                                            </video>

                                                            <button type="button" class="btn btn-sm btn-primary mt-2"
                                                                id="ambilFoto">
                                                                Ambil Foto
                                                            </button>

                                                            <canvas id="canvas" style="display:none;"></canvas>

                                                            <!-- hasil base64 -->
                                                            <input type="hidden" name="foto_camera" id="foto_camera">

                                                            <img id="hasilFoto" class="mt-3 rounded" width="150">
                                                        </div>

                                                    </div>

                                                </div>

                                                <!-- Foto KTP -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Foto KTP</label>

                                                        <input type="file" name="foto_ktp" class="form-control">
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
                        <!-- Modal Tambah Nasabah -->
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Foto</th>
                                        <th>Kode Nasabah</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Jenis Kelamin</th>
                                        <th>No HP</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($nasabah as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td width="80">

                                                @if ($item->foto)
                                                    <img src="{{ asset('anggota/foto/' . $item->foto) }}"
                                                        class="rounded-circle" width="50" height="50"
                                                        style="object-fit: cover;">
                                                @else
                                                    <img src="{{ asset('default.png') }}" class="rounded-circle"
                                                        width="50" height="50">
                                                @endif

                                            </td>

                                            <td>{{ $item->kode_nasabah }}</td>
                                            <td>{{ $item->nik }}</td>
                                            <td>{{ $item->nama }}</td>
                                            <td>
                                                @if ($item->jenis_kelamin == 'L')
                                                    Laki-laki
                                                @else
                                                    Perempuan
                                                @endif
                                            </td>
                                            <td> {{ $item->no_hp }}</td>
                                            <td>
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
                                            <td>
                                                <a href="" class="btn btn-outline-primary btn-sm"
                                                    data-toggle="modal" data-target="#detailNasabah{{ $item->id }}">
                                                    Detail
                                                </a>

                                                <!-- Modal Detail -->
                                                <div class="modal fade" id="detailNasabah{{ $item->id }}"
                                                    tabindex="-1">

                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">

                                                            <div class="modal-header">
                                                                <h5 class="modal-title">
                                                                    Detail Nasabah
                                                                </h5>

                                                                <button type="button" class="close"
                                                                    data-dismiss="modal">

                                                                    <span>&times;</span>
                                                                </button>
                                                            </div>

                                                            <div class="modal-body">

                                                                <div class="row">

                                                                    <!-- FOTO -->
                                                                    <div class="col-md-12 text-center mb-4">

                                                                        @if ($item->foto)
                                                                            <img src="{{ asset('anggota/foto/' . $item->foto) }}"
                                                                                class="rounded-circle shadow"
                                                                                width="120" height="120"
                                                                                style="object-fit: cover;">
                                                                        @else
                                                                            <img src="{{ asset('default.png') }}"
                                                                                class="rounded-circle shadow"
                                                                                width="120" height="120">
                                                                        @endif

                                                                    </div>

                                                                    <!-- KODE -->
                                                                    <div class="col-md-6">
                                                                        <strong>Kode Nasabah</strong>
                                                                        <p>{{ $item->kode_nasabah }}</p>
                                                                    </div>

                                                                    <!-- NIK -->
                                                                    <div class="col-md-6">
                                                                        <strong>NIK</strong>
                                                                        <p>{{ $item->nik }}</p>
                                                                    </div>

                                                                    <!-- NAMA -->
                                                                    <div class="col-md-6">
                                                                        <strong>Nama</strong>
                                                                        <p>{{ $item->nama }}</p>
                                                                    </div>

                                                                    <!-- JK -->
                                                                    <div class="col-md-6">
                                                                        <strong>Jenis Kelamin</strong>
                                                                        <p>
                                                                            @if ($item->jenis_kelamin == 'L')
                                                                                Laki-laki
                                                                            @else
                                                                                Perempuan
                                                                            @endif
                                                                        </p>
                                                                    </div>

                                                                    <!-- TEMPAT LAHIR -->
                                                                    <div class="col-md-6">
                                                                        <strong>Tempat Lahir</strong>
                                                                        <p>{{ $item->tempat_lahir }}</p>
                                                                    </div>

                                                                    <!-- TANGGAL LAHIR -->
                                                                    <div class="col-md-6">
                                                                        <strong>Tanggal Lahir</strong>
                                                                        <p>{{ $item->tanggal_lahir }}</p>
                                                                    </div>

                                                                    <!-- NO HP -->
                                                                    <div class="col-md-6">
                                                                        <strong>No HP</strong>
                                                                        <p>{{ $item->no_hp }}</p>
                                                                    </div>

                                                                    <!-- STATUS -->
                                                                    <div class="col-md-6">
                                                                        <strong>Status</strong>
                                                                        <p>
                                                                            @if ($item->status == 'aktif')
                                                                                <span class="badge badge-success">
                                                                                    Aktif
                                                                                </span>
                                                                            @else
                                                                                <span class="badge badge-danger">
                                                                                    Nonaktif
                                                                                </span>
                                                                            @endif
                                                                        </p>
                                                                    </div>

                                                                    <!-- PEKERJAAN -->
                                                                    <div class="col-md-6">
                                                                        <strong>Pekerjaan</strong>
                                                                        <p>{{ $item->pekerjaan }}</p>
                                                                    </div>

                                                                    <!-- PENDAPATAN -->
                                                                    <div class="col-md-6">
                                                                        <strong>Pendapatan</strong>
                                                                        <p>{{ $item->pendapatan }}</p>
                                                                    </div>

                                                                    <!-- TANGGAL DAFTAR -->
                                                                    <div class="col-md-6">
                                                                        <strong>Tanggal Daftar</strong>
                                                                        <p>{{ $item->tanggal_daftar }}</p>
                                                                    </div>

                                                                    <!-- PETUGAS INPUT -->
                                                                    <div class="col-md-6">
                                                                        <strong>Diinput Oleh</strong>

                                                                        <p>
                                                                            {{ $item->user->name ?? '-' }}
                                                                        </p>
                                                                    </div>

                                                                    <!-- ALAMAT -->
                                                                    <div class="col-md-12">
                                                                        <strong>Alamat</strong>
                                                                        <p>{{ $item->alamat }}</p>
                                                                    </div>

                                                                    <!-- FOTO KTP -->
                                                                    <div class="col-md-12 text-center mt-3">

                                                                        <strong>Foto KTP</strong>
                                                                        <br><br>

                                                                        @if ($item->foto_ktp)
                                                                            <img src="{{ asset('anggota/ktp/' . $item->foto_ktp) }}"
                                                                                class="img-fluid rounded shadow"
                                                                                style="max-height:300px;">
                                                                        @endif

                                                                    </div>

                                                                </div>

                                                            </div>

                                                            <div class="modal-footer">

                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">

                                                                    Tutup
                                                                </button>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End Modal Detail -->

                                                <!-- Edit Nasabah -->
                                                @if (auth()->user()->role != 'pimpinan')
                                                    <a href="#" class="btn btn-outline-success btn-sm"
                                                        data-toggle="modal"
                                                        data-target="#editNasabah{{ $item->id }}">
                                                        Edit
                                                    </a>
                                                @endif

                                                <div class="modal fade" id="editNasabah{{ $item->id }}"
                                                    tabindex="-1">

                                                    <div class="modal-dialog modal-lg">

                                                        <div class="modal-content">

                                                            <div class="modal-header">

                                                                <h5 class="modal-title">
                                                                    Edit Data Nasabah
                                                                </h5>

                                                                <button type="button" class="close"
                                                                    data-dismiss="modal">

                                                                    <span>&times;</span>

                                                                </button>

                                                            </div>

                                                            <form action="{{ route('nasabah.update', $item->id) }}"
                                                                method="POST" enctype="multipart/form-data">

                                                                @csrf
                                                                @method('PUT')

                                                                <div class="modal-body">

                                                                    <div class="row">

                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label>Kode Nasabah</label>

                                                                                <input type="text" class="form-control"
                                                                                    value="{{ $item->kode_nasabah }}"
                                                                                    readonly>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label>NIK</label>

                                                                                <input type="text" name="nik"
                                                                                    class="form-control"
                                                                                    value="{{ $item->nik }}">
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label>Nama Nasabah</label>

                                                                                <input type="text" name="nama"
                                                                                    class="form-control"
                                                                                    value="{{ $item->nama }}">
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label>Jenis Kelamin</label>

                                                                                <select name="jenis_kelamin"
                                                                                    class="form-control">

                                                                                    <option value="L"
                                                                                        {{ $item->jenis_kelamin == 'L' ? 'selected' : '' }}>
                                                                                        Laki-laki
                                                                                    </option>

                                                                                    <option value="P"
                                                                                        {{ $item->jenis_kelamin == 'P' ? 'selected' : '' }}>
                                                                                        Perempuan
                                                                                    </option>

                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label>Tempat Lahir</label>

                                                                                <input type="text" name="tempat_lahir"
                                                                                    class="form-control"
                                                                                    value="{{ $item->tempat_lahir }}">
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label>Tanggal Lahir</label>

                                                                                <input type="date" name="tanggal_lahir"
                                                                                    class="form-control"
                                                                                    value="{{ $item->tanggal_lahir }}">
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label>No HP</label>

                                                                                <input type="text" name="no_hp"
                                                                                    class="form-control"
                                                                                    value="{{ $item->no_hp }}">
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label>Pekerjaan</label>

                                                                                <select name="pekerjaan"
                                                                                    class="form-control">

                                                                                    <option value="Petani"
                                                                                        {{ $item->pekerjaan == 'Petani' ? 'selected' : '' }}>
                                                                                        Petani</option>

                                                                                    <option value="Pedagang"
                                                                                        {{ $item->pekerjaan == 'Pedagang' ? 'selected' : '' }}>
                                                                                        Pedagang</option>

                                                                                    <option value="Wiraswasta"
                                                                                        {{ $item->pekerjaan == 'Wiraswasta' ? 'selected' : '' }}>
                                                                                        Wiraswasta</option>

                                                                                    <option value="Karyawan Swasta"
                                                                                        {{ $item->pekerjaan == 'Karyawan Swasta' ? 'selected' : '' }}>
                                                                                        Karyawan Swasta</option>

                                                                                    <option value="PNS"
                                                                                        {{ $item->pekerjaan == 'PNS' ? 'selected' : '' }}>
                                                                                        PNS</option>

                                                                                    <option value="Guru"
                                                                                        {{ $item->pekerjaan == 'Guru' ? 'selected' : '' }}>
                                                                                        Guru</option>

                                                                                    <option value="Nelayan"
                                                                                        {{ $item->pekerjaan == 'Nelayan' ? 'selected' : '' }}>
                                                                                        Nelayan</option>

                                                                                    <option value="Buruh"
                                                                                        {{ $item->pekerjaan == 'Buruh' ? 'selected' : '' }}>
                                                                                        Buruh</option>

                                                                                    <option value="Ibu Rumah Tangga"
                                                                                        {{ $item->pekerjaan == 'Ibu Rumah Tangga' ? 'selected' : '' }}>
                                                                                        Ibu Rumah Tangga</option>

                                                                                    <option value="Lainnya"
                                                                                        {{ $item->pekerjaan == 'Lainnya' ? 'selected' : '' }}>
                                                                                        Lainnya</option>

                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-6">

                                                                            <div class="form-group">

                                                                                <label>Pendapatan</label>

                                                                                <select name="pendapatan"
                                                                                    class="form-control">

                                                                                    <option value="500000"
                                                                                        {{ $item->pendapatan == 500000 ? 'selected' : '' }}>
                                                                                        Rp 500.000 - Rp 1.000.000
                                                                                    </option>

                                                                                    <option value="1000000"
                                                                                        {{ $item->pendapatan == 1000000 ? 'selected' : '' }}>
                                                                                        Rp 1.000.001 - Rp 2.000.000
                                                                                    </option>

                                                                                    <option value="2000000"
                                                                                        {{ $item->pendapatan == 2000000 ? 'selected' : '' }}>
                                                                                        Rp 2.000.001 - Rp 3.000.000
                                                                                    </option>

                                                                                    <option value="3000000"
                                                                                        {{ $item->pendapatan == 3000000 ? 'selected' : '' }}>
                                                                                        Di atas Rp 3.000.000
                                                                                    </option>

                                                                                </select>

                                                                            </div>

                                                                        </div>

                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label>Tanggal Daftar</label>

                                                                                <input type="date"
                                                                                    name="tanggal_daftar"
                                                                                    class="form-control"
                                                                                    value="{{ $item->tanggal_daftar }}">
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label>Status</label>

                                                                                <select name="status"
                                                                                    class="form-control">

                                                                                    <option value="aktif"
                                                                                        {{ $item->status == 'aktif' ? 'selected' : '' }}>
                                                                                        Aktif
                                                                                    </option>

                                                                                    <option value="nonaktif"
                                                                                        {{ $item->status == 'nonaktif' ? 'selected' : '' }}>
                                                                                        Nonaktif
                                                                                    </option>

                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-12">
                                                                            <div class="form-group">
                                                                                <label>Alamat</label>

                                                                                <textarea name="alamat" class="form-control" rows="3">{{ $item->alamat }}</textarea>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                            <div class="form-group">

                                                                                <label>Foto Nasabah Saat Ini</label>

                                                                                <div class="mb-2">

                                                                                    @if ($item->foto)
                                                                                        <img src="{{ asset('anggota/foto/' . $item->foto) }}"
                                                                                            width="120"
                                                                                            class="img-thumbnail">
                                                                                    @else
                                                                                        <span class="text-muted">
                                                                                            Belum ada foto
                                                                                        </span>
                                                                                    @endif

                                                                                </div>

                                                                                <input type="file" name="foto"
                                                                                    class="form-control">

                                                                                <small class="text-muted">
                                                                                    Kosongkan jika tidak ingin mengganti
                                                                                    foto.
                                                                                </small>

                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                            <div class="form-group">

                                                                                <label>Foto KTP Saat Ini</label>

                                                                                <div class="mb-2">

                                                                                    @if ($item->foto_ktp)
                                                                                        <img src="{{ asset('anggota/ktp/' . $item->foto_ktp) }}"
                                                                                            width="120"
                                                                                            class="img-thumbnail">
                                                                                    @else
                                                                                        <span class="text-muted">
                                                                                            Belum ada foto KTP
                                                                                        </span>
                                                                                    @endif

                                                                                </div>

                                                                                <input type="file" name="foto_ktp"
                                                                                    class="form-control">

                                                                                <small class="text-muted">
                                                                                    Kosongkan jika tidak ingin mengganti
                                                                                    foto KTP.
                                                                                </small>

                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                </div>

                                                                <div class="modal-footer">

                                                                    <button type="submit" class="btn btn-success">

                                                                        Update
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
                                                <!-- End Edit Nasabah -->

                                                @if (request('status') == 'trash')
                                                    @if (auth()->user()->role != 'pimpinan')
                                                        <!-- RESTORE -->
                                                        <form action="{{ route('nasabah.restore', $item->id) }}"
                                                            method="POST" class="d-inline">

                                                            @csrf
                                                            @method('PUT')

                                                            <button type="submit" class="btn btn-success btn-sm">

                                                                Restore
                                                            </button>

                                                        </form>

                                                        <!-- HAPUS PERMANEN -->
                                                        <a href="" class="btn btn-danger btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#hapusPermanent{{ $item->id }}">
                                                            Hapus Permanen
                                                        </a>

                                                        <!-- MODAL HAPUS PERMANEN -->
                                                        <div class="modal fade" id="hapusPermanent{{ $item->id }}"
                                                            tabindex="-1">

                                                            <div class="modal-dialog">

                                                                <div class="modal-content">

                                                                    <div class="modal-header bg-danger text-white">

                                                                        <h5 class="modal-title">
                                                                            Hapus Permanen
                                                                        </h5>

                                                                        <button type="button" class="close text-white"
                                                                            data-dismiss="modal">

                                                                            <span>&times;</span>
                                                                        </button>

                                                                    </div>

                                                                    <div class="modal-body">

                                                                        <p>
                                                                            Yakin mau hapus permanen data:
                                                                        </p>

                                                                        <strong>
                                                                            {{ $item->nama }}
                                                                        </strong>

                                                                        <p class="mt-2 text-danger">
                                                                            Data dan foto akan dihapus permanen.
                                                                        </p>

                                                                    </div>

                                                                    <div class="modal-footer">

                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">

                                                                            Batal
                                                                        </button>

                                                                        <form
                                                                            action="{{ route('nasabah.forceDelete', $item->id) }}"
                                                                            method="POST">

                                                                            @csrf
                                                                            @method('DELETE')

                                                                            <button type="submit" class="btn btn-danger">

                                                                                Ya, Hapus Permanen
                                                                            </button>

                                                                        </form>

                                                                    </div>

                                                                </div>

                                                            </div>

                                                        </div>
                                                    @endif
                                                @else
                                                    <!-- HAPUS -->
                                                    @if (auth()->user()->role != 'pimpinan')
                                                        <a href="" class="btn btn-outline-danger btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#hapusNasabah{{ $item->id }}">
                                                            Hapus
                                                        </a>
                                                    @endif
                                                    </a>

                                                    <!-- MODAL HAPUS -->
                                                    <div class="modal fade" id="hapusNasabah{{ $item->id }}"
                                                        tabindex="-1">

                                                        <div class="modal-dialog">

                                                            <div class="modal-content">

                                                                <div class="modal-header bg-danger text-white">

                                                                    <h5 class="modal-title">
                                                                        Konfirmasi Hapus
                                                                    </h5>

                                                                    <button type="button" class="close text-white"
                                                                        data-dismiss="modal">

                                                                        <span>&times;</span>
                                                                    </button>

                                                                </div>

                                                                <div class="modal-body">

                                                                    <p>
                                                                        Apakah yakin ingin menghapus data nasabah:
                                                                    </p>

                                                                    <strong>
                                                                        {{ $item->nama }}
                                                                    </strong>

                                                                </div>

                                                                <div class="modal-footer">

                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">

                                                                        Batal
                                                                    </button>

                                                                    <form
                                                                        action="{{ route('nasabah.destroy', $item->id) }}"
                                                                        method="POST">

                                                                        @csrf
                                                                        @method('DELETE')

                                                                        <button type="submit" class="btn btn-danger">

                                                                            Ya, Hapus
                                                                        </button>

                                                                    </form>

                                                                </div>

                                                            </div>

                                                        </div>

                                                    </div>
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
        </div>
    </div>

    <script>
        const pilihFoto = document.getElementById('pilihFoto');
        const uploadFoto = document.getElementById('uploadFoto');
        const kameraFoto = document.getElementById('kameraFoto');

        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const ambilFoto = document.getElementById('ambilFoto');
        const fotoCamera = document.getElementById('foto_camera');
        const hasilFoto = document.getElementById('hasilFoto');

        let stream;

        // pilih metode foto
        pilihFoto.addEventListener('change', function() {

            if (this.value == 'kamera') {

                uploadFoto.style.display = 'none';
                kameraFoto.style.display = 'block';

                navigator.mediaDevices.getUserMedia({
                        video: true
                    })
                    .then(function(s) {

                        stream = s;
                        video.srcObject = stream;

                    });

            } else {

                uploadFoto.style.display = 'block';
                kameraFoto.style.display = 'none';

                // matikan kamera
                if (stream) {
                    stream.getTracks().forEach(track => track.stop());
                }
            }
        });

        // ambil foto
        ambilFoto.addEventListener('click', function() {

            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;

            const ctx = canvas.getContext('2d');

            ctx.drawImage(video, 0, 0);

            const image = canvas.toDataURL('image/png');

            fotoCamera.value = image;

            hasilFoto.src = image;
        });
    </script>
@endsection
