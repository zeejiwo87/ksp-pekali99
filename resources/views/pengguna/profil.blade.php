@extends('layouts.app')

@section('title', 'Profil')

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
        <h4 class="font-weight-bold py-3 mb-0">Profil</h4>
        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#"><i class="feather icon-home"></i></a>
                </li>
                <li class="breadcrumb-item active">Profil</li>
            </ol>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card mb-4">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Profil Pengguna</h6>

                        <!-- Tombol -->
                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEditProfil">
                            <i class="feather icon-edit"></i> Edit
                        </button>

                        <!-- Modal Edit Profil -->
                        <div class="modal fade" id="modalEditProfil" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">
                                            Edit Profil
                                        </h5>

                                        <button type="button" class="close" data-dismiss="modal">
                                            <span>&times;</span>
                                        </button>
                                    </div>

                                    <form action="{{ route('pengguna.updateProfil') }}" method="POST"
                                        enctype="multipart/form-data">

                                        @csrf
                                        @method('PUT')

                                        <div class="modal-body">

                                            <div class="row">

                                                <!-- Foto -->
                                                <div class="col-md-12 text-center mb-3">

                                                    @if ($user->foto)
                                                        <img src="{{ asset('user/' . $user->foto) }}" width="120"
                                                            class="rounded-circle img-thumbnail mb-3">
                                                    @else
                                                        <img src="{{ asset('assets/img/user.png') }}" width="120"
                                                            class="rounded-circle img-thumbnail mb-3">
                                                    @endif

                                                    <input type="file" name="foto" class="form-control">

                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Kode User</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $user->kode_user }}" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Nama</label>
                                                        <input type="text" name="name" class="form-control"
                                                            value="{{ $user->name }}" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Username</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ $user->username }}" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <input type="email" name="email" class="form-control"
                                                            value="{{ $user->email }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>NIK</label>
                                                        <input type="text" name="nik" class="form-control"
                                                            value="{{ $user->nik }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Jenis Kelamin</label>

                                                        <select name="jenis_kelamin" class="form-control">

                                                            <option value="L"
                                                                {{ $user->jenis_kelamin == 'L' ? 'selected' : '' }}>
                                                                Laki-laki
                                                            </option>

                                                            <option value="P"
                                                                {{ $user->jenis_kelamin == 'P' ? 'selected' : '' }}>
                                                                Perempuan
                                                            </option>

                                                        </select>

                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Tempat Lahir</label>
                                                        <input type="text" name="tempat_lahir" class="form-control"
                                                            value="{{ $user->tempat_lahir }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Tanggal Lahir</label>
                                                        <input type="date" name="tanggal_lahir" class="form-control"
                                                            value="{{ $user->tanggal_lahir }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>No HP</label>
                                                        <input type="text" name="no_hp" class="form-control"
                                                            value="{{ $user->no_hp }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Role</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ ucfirst($user->role) }}" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Alamat</label>

                                                        <textarea name="alamat" class="form-control" rows="3">{{ $user->alamat }}</textarea>

                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                        <div class="modal-footer">

                                            <button class="btn btn-primary btn-sm">
                                                Simpan Perubahan
                                            </button>

                                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                                                Batal
                                            </button>

                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                        <!-- Modal Edit Profil -->
                    </div>
                    
                    <div class="card-body">

                        <div class="row">

                            <!-- Foto -->
                            <div class="col-md-3 text-center">

                                @if ($user->foto)
                                    <img src="{{ asset('user/' . $user->foto) }}" class="img-thumbnail rounded-circle"
                                        width="180" height="180">
                                @else
                                    <img src="{{ asset('assets/img/user.png') }}" class="img-thumbnail rounded-circle"
                                        width="180" height="180">
                                @endif

                                <h5 class="mt-3">{{ $user->name }}</h5>

                                <span class="badge badge-primary">
                                    {{ strtoupper($user->role) }}
                                </span>

                            </div>

                            <!-- Biodata -->
                            <div class="col-md-9">

                                <table class="table table-bordered">

                                    <tr>
                                        <th width="250">Kode User</th>
                                        <td>{{ $user->kode_user }}</td>
                                    </tr>

                                    <tr>
                                        <th>Nama Lengkap</th>
                                        <td>{{ $user->name }}</td>
                                    </tr>

                                    <tr>
                                        <th>Username</th>
                                        <td>{{ $user->username }}</td>
                                    </tr>

                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $user->email ?? '-' }}</td>
                                    </tr>

                                    <tr>
                                        <th>NIK</th>
                                        <td>{{ $user->nik ?? '-' }}</td>
                                    </tr>

                                    <tr>
                                        <th>Jenis Kelamin</th>
                                        <td>
                                            {{ $user->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Tempat Lahir</th>
                                        <td>{{ $user->tempat_lahir ?? '-' }}</td>
                                    </tr>

                                    <tr>
                                        <th>Tanggal Lahir</th>
                                        <td>
                                            {{ $user->tanggal_lahir ? \Carbon\Carbon::parse($user->tanggal_lahir)->format('d-m-Y') : '-' }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Alamat</th>
                                        <td>{{ $user->alamat ?? '-' }}</td>
                                    </tr>

                                    <tr>
                                        <th>No. HP</th>
                                        <td>{{ $user->no_hp ?? '-' }}</td>
                                    </tr>

                                    <tr>
                                        <th>Role</th>
                                        <td>
                                            <span class="badge badge-info">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Status Akun</th>
                                        <td>
                                            @if ($user->status == 'aktif')
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

                                    <tr>
                                        <th>Tanggal Dibuat</th>
                                        <td>
                                            {{ $user->created_at->format('d-m-Y H:i') }}
                                        </td>
                                    </tr>

                                </table>

                            </div>

                        </div>

                    </div>

                </div>
                <div class="card mt-4">

                    <div class="card-header">
                        <h6 class="mb-0">Ubah Password</h6>
                    </div>

                    <div class="card-body">

                        <form action="{{ route('pengguna.updatePassword') }}" method="POST">

                            @csrf

                            <div class="form-group">
                                <label>Password Lama</label>
                                <input type="password" name="password_lama" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>Password Baru</label>
                                <input type="password" name="password_baru" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>Konfirmasi Password Baru</label>
                                <input type="password" name="password_baru_confirmation" class="form-control" required>
                            </div>

                            <button class="btn btn-primary btn-sm">
                                Simpan Password
                            </button>

                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
