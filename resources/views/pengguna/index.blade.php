@extends('layouts.app')

@section('title', 'Pengguna')

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
        <h4 class="font-weight-bold py-3 mb-0">Data Pengguna</h4>
        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#"><i class="feather icon-home"></i></a>
                </li>
                <li class="breadcrumb-item active">Data Pengguna</li>
            </ol>
        </div>
        <div class="row">
            <div class="col-sm-12">
                @include('includes.alerts')
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="card-header-title mb-0">Data Pengguna</h6>
                        <a href="" class="btn btn-outline-info btn-sm ml-auto" data-toggle="modal"
                            data-target="#modalTambah">
                            Tambah Data
                        </a>

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

                                    <form action="{{ route('pengguna.store') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="row"> <!-- Kode User -->
                                                <div class="col-md-6">
                                                    <div class="form-group"> <label>Kode User</label> <input type="text"
                                                            name="kode_user" class="form-control"
                                                            placeholder="Masukkan kode user"> </div>
                                                </div> <!-- Nama -->
                                                <div class="col-md-6">
                                                    <div class="form-group"> <label>Nama Lengkap</label> <input
                                                            type="text" name="name" class="form-control"
                                                            placeholder="Masukkan nama"> </div>
                                                </div> <!-- Username -->
                                                <div class="col-md-6">
                                                    <div class="form-group"> <label>Username</label> <input type="text"
                                                            name="username" class="form-control"
                                                            placeholder="Masukkan username"> </div>
                                                </div> <!-- Email -->
                                                <div class="col-md-6">
                                                    <div class="form-group"> <label>Email</label> <input type="email"
                                                            name="email" class="form-control"
                                                            placeholder="Masukkan email"> </div>
                                                </div> <!-- NIK -->
                                                <div class="col-md-6">
                                                    <div class="form-group"> <label>NIK</label> <input type="text"
                                                            name="nik" class="form-control" placeholder="Masukkan NIK">
                                                    </div>
                                                </div> <!-- Jenis Kelamin -->
                                                <div class="col-md-6">
                                                    <div class="form-group"> <label>Jenis Kelamin</label> <select
                                                            name="jenis_kelamin" class="form-control">
                                                            <option value=""> -- Pilih -- </option>
                                                            <option value="L"> Laki-Laki </option>
                                                            <option value="P"> Perempuan </option>
                                                        </select> </div>
                                                </div> <!-- Tempat Lahir -->
                                                <div class="col-md-6">
                                                    <div class="form-group"> <label>Tempat Lahir</label> <input
                                                            type="text" name="tempat_lahir" class="form-control"> </div>
                                                </div> <!-- Tanggal Lahir -->
                                                <div class="col-md-6">
                                                    <div class="form-group"> <label>Tanggal Lahir</label> <input
                                                            type="date" name="tanggal_lahir" class="form-control"> </div>
                                                </div> <!-- No HP -->
                                                <div class="col-md-6">
                                                    <div class="form-group"> <label>No HP</label> <input type="text"
                                                            name="no_hp" class="form-control"> </div>
                                                </div> <!-- Role -->
                                                <div class="col-md-6">
                                                    <div class="form-group"> <label>Role</label> <select name="role"
                                                            class="form-control">
                                                            <option value=""> -- Pilih Role -- </option>
                                                            <option value="admin"> Admin </option>
                                                            <option value="petugas"> Petugas </option>
                                                            <option value="pimpinan"> Pimpinan </option>
                                                        </select> </div>
                                                </div> <!-- Password -->
                                                <div class="col-md-6">
                                                    <div class="form-group"> <label>Password</label> <input type="password"
                                                            name="password" class="form-control"> </div>
                                                </div> <!-- Status -->
                                                <div class="col-md-6">
                                                    <div class="form-group"> <label>Status</label> <select name="status"
                                                            class="form-control">
                                                            <option value="aktif"> Aktif </option>
                                                            <option value="nonaktif"> Nonaktif </option>
                                                        </select> </div>
                                                </div> <!-- Foto -->
                                                <div class="col-md-12">
                                                    <div class="form-group"> <label>Foto</label> <input type="file"
                                                            name="foto" class="form-control"> </div>
                                                </div> <!-- Alamat -->
                                                <div class="col-md-12">
                                                    <div class="form-group"> <label>Alamat</label>
                                                        <textarea name="alamat" class="form-control" rows="3"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer"> <button type="submit" class="btn btn-primary"> Simpan
                                            </button> <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal"> Batal </button> </div>
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
                                    <th>Foto</th>
                                    <th>Kode User</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td width="80"> <img src="{{ asset('user/' . $item->foto) }}" width="50"
                                                height="50" class="rounded-circle"> </td>
                                        <td> {{ $item->kode_user }} </td>
                                        <td> {{ $item->name }} </td>
                                        <td> {{ $item->username }} </td>
                                        <td>
                                            @if ($item->role == 'admin')
                                                <span class="badge badge-primary"> Admin </span>
                                            @elseif ($item->role == 'petugas')
                                                <span class="badge badge-info"> Petugas </span>
                                            @else
                                                <span class="badge badge-success"> Pimpinan </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->status == 'aktif')
                                                <span class="badge badge-success"> Aktif </span>
                                            @else
                                                <span class="badge badge-danger"> Nonaktif </span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-outline-primary btn-sm" data-toggle="modal"
                                                data-target="#detailUser{{ $item->id }}">Detail</a>

                                            <!-- Modal Detail Pengguna -->
                                            <div class="modal fade" id="detailUser{{ $item->id }}" tabindex="-1"
                                                role="dialog">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">

                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Detail Data Pengguna</h5>
                                                            <button type="button" class="close" data-dismiss="modal">
                                                                <span>&times;</span>
                                                            </button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-12 text-center mb-4">
                                                                    @if ($item->foto)
                                                                        <img src="{{ asset('user/' . $item->foto) }}"
                                                                            class="rounded-circle shadow" width="120"
                                                                            height="120" style="object-fit: cover;">
                                                                    @else
                                                                        <img src="{{ asset('default.png') }}"
                                                                            class="rounded-circle shadow" width="120"
                                                                            height="120" style="object-fit: cover;">
                                                                    @endif
                                                                </div>

                                                                <div class="col-md-6 mb-3">
                                                                    <strong>Kode User</strong>
                                                                    <p>{{ $item->kode_user }}</p>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <strong>Nama Lengkap</strong>
                                                                    <p>{{ $item->name }}</p>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <strong>Username</strong>
                                                                    <p>{{ $item->username }}</p>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <strong>Email</strong>
                                                                    <p>{{ $item->email ?? '-' }}</p>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <strong>NIK</strong>
                                                                    <p>{{ $item->nik ?? '-' }}</p>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <strong>Jenis Kelamin</strong>
                                                                    <p>{{ $item->jenis_kelamin == 'L' ? 'Laki-Laki' : ($item->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</p>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <strong>Tempat Lahir</strong>
                                                                    <p>{{ $item->tempat_lahir ?? '-' }}</p>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <strong>Tanggal Lahir</strong>
                                                                    <p>{{ $item->tanggal_lahir ?? '-' }}</p>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <strong>No HP</strong>
                                                                    <p>{{ $item->no_hp ?? '-' }}</p>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <strong>Role</strong>
                                                                    <p>{{ ucfirst($item->role) }}</p>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <strong>Status</strong>
                                                                    <p>{{ $item->status == 'aktif' ? 'Aktif' : 'Nonaktif' }}</p>
                                                                </div>
                                                                <div class="col-md-12 mb-3">
                                                                    <strong>Alamat</strong>
                                                                    <p>{{ $item->alamat ?? '-' }}</p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary btn-sm"
                                                                data-dismiss="modal">Tutup</button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal Detail Pengguna -->

                                            <!-- Edit Pengguna -->
                                            <a href="#" class="btn btn-outline-success btn-sm" data-toggle="modal"
                                                data-target="#editUser{{ $item->id }}">
                                                Edit
                                            </a>

                                            <!-- Modal Edit Pengguna -->
                                            <div class="modal fade" id="editUser{{ $item->id }}" tabindex="-1"
                                                role="dialog">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">

                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Data Pengguna</h5>
                                                            <button type="button" class="close" data-dismiss="modal">
                                                                <span>&times;</span>
                                                            </button>
                                                        </div>

                                                        <form action="{{ route('pengguna.update', $item->id) }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')

                                                            <div class="modal-body">
                                                                <div class="row">

                                                                    <!-- Kode User -->
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Kode User</label>
                                                                            <input type="text" name="kode_user"
                                                                                class="form-control"
                                                                                value="{{ $item->kode_user }}">
                                                                        </div>
                                                                    </div>

                                                                    <!-- Nama -->
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Nama Lengkap</label>
                                                                            <input type="text" name="name"
                                                                                class="form-control"
                                                                                value="{{ $item->name }}">
                                                                        </div>
                                                                    </div>

                                                                    <!-- Username -->
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Username</label>
                                                                            <input type="text" name="username"
                                                                                class="form-control"
                                                                                value="{{ $item->username }}">
                                                                        </div>
                                                                    </div>

                                                                    <!-- Email -->
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Email</label>
                                                                            <input type="email" name="email"
                                                                                class="form-control"
                                                                                value="{{ $item->email }}">
                                                                        </div>
                                                                    </div>

                                                                    <!-- NIK -->
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>NIK</label>
                                                                            <input type="text" name="nik"
                                                                                class="form-control"
                                                                                value="{{ $item->nik }}">
                                                                        </div>
                                                                    </div>

                                                                    <!-- Jenis Kelamin -->
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Jenis Kelamin</label>
                                                                            <select name="jenis_kelamin"
                                                                                class="form-control">
                                                                                <option value="L"
                                                                                    {{ $item->jenis_kelamin == 'L' ? 'selected' : '' }}>
                                                                                    Laki-Laki</option>
                                                                                <option value="P"
                                                                                    {{ $item->jenis_kelamin == 'P' ? 'selected' : '' }}>
                                                                                    Perempuan</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Tempat Lahir -->
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Tempat Lahir</label>
                                                                            <input type="text" name="tempat_lahir"
                                                                                class="form-control"
                                                                                value="{{ $item->tempat_lahir }}">
                                                                        </div>
                                                                    </div>

                                                                    <!-- Tanggal Lahir -->
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Tanggal Lahir</label>
                                                                            <input type="date" name="tanggal_lahir"
                                                                                class="form-control"
                                                                                value="{{ $item->tanggal_lahir }}">
                                                                        </div>
                                                                    </div>

                                                                    <!-- No HP -->
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>No HP</label>
                                                                            <input type="text" name="no_hp"
                                                                                class="form-control"
                                                                                value="{{ $item->no_hp }}">
                                                                        </div>
                                                                    </div>

                                                                    <!-- Role -->
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Role</label>
                                                                            <select name="role" class="form-control">
                                                                                <option value="admin"
                                                                                    {{ $item->role == 'admin' ? 'selected' : '' }}>
                                                                                    Admin</option>
                                                                                <option value="petugas"
                                                                                    {{ $item->role == 'petugas' ? 'selected' : '' }}>
                                                                                    Petugas</option>
                                                                                <option value="pimpinan"
                                                                                    {{ $item->role == 'pimpinan' ? 'selected' : '' }}>
                                                                                    Pimpinan</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Status -->
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Status</label>
                                                                            <select name="status" class="form-control">
                                                                                <option value="aktif"
                                                                                    {{ $item->status == 'aktif' ? 'selected' : '' }}>
                                                                                    Aktif</option>
                                                                                <option value="nonaktif"
                                                                                    {{ $item->status == 'nonaktif' ? 'selected' : '' }}>
                                                                                    Nonaktif</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Alamat -->
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Alamat</label>
                                                                            <textarea name="alamat" class="form-control" rows="3">{{ $item->alamat }}</textarea>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Password Baru -->
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Password Baru</label>
                                                                            <input type="password" name="password"
                                                                                class="form-control"
                                                                                placeholder="Kosongkan jika tidak ingin mengubah">
                                                                        </div>
                                                                    </div>

                                                                    <!-- Konfirmasi Password -->
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Konfirmasi Password</label>
                                                                            <input type="password" name="password_confirmation"
                                                                                class="form-control"
                                                                                placeholder="Ulangi password baru">
                                                                        </div>
                                                                    </div>

                                                                    <!-- Foto -->
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>Foto</label>
                                                                            <input type="file" name="foto"
                                                                                class="form-control">

                                                                            @if ($item->foto)
                                                                                <img src="{{ asset('user/' . $item->foto) }}"
                                                                                    width="80"
                                                                                    class="mt-2 rounded-circle">
                                                                            @endif
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
                                            <!-- Edit Pengguna -->

                                            <!-- Hapus Pengguna -->
                                            <a href="#" class="btn btn-outline-danger btn-sm" data-toggle="modal"
                                                data-target="#deleteUser{{ $item->id }}">
                                                Hapus
                                            </a>

                                            <div class="modal fade" id="deleteUser{{ $item->id }}" tabindex="-1"
                                                role="dialog">
                                                <div class="modal-dialog modal-sm" role="document">
                                                    <div class="modal-content">

                                                        <div class="modal-header">
                                                            <h5 class="modal-title text-danger">Konfirmasi Hapus</h5>
                                                            <button type="button" class="close" data-dismiss="modal">
                                                                <span>&times;</span>
                                                            </button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <p>Yakin ingin menghapus user:</p>
                                                            <strong>{{ $item->name }}</strong>
                                                        </div>

                                                        <div class="modal-footer">

                                                            <form action="{{ route('pengguna.destroy', $item->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')

                                                                <button type="submit" class="btn btn-danger btn-sm">
                                                                    Ya, Hapus
                                                                </button>
                                                            </form>

                                                            <button type="button" class="btn btn-secondary btn-sm"
                                                                data-dismiss="modal">
                                                                Batal
                                                            </button>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Hapus Pengguna -->
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
