@extends('layouts.app')

@section('title', 'Aturan Pinjaman')

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
        <h4 class="font-weight-bold py-3 mb-0">Data Aturan Pinjaman</h4>
        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#"><i class="feather icon-home"></i></a>
                </li>
                <li class="breadcrumb-item active">Data Aturan Pinjaman</li>
            </ol>
        </div>
        @include('includes.alerts')
        <div class="row">
            <div class="col-sm-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="card-header-title mb-0">Data Aturan Pinjaman</h6>
                        <a href="" class="btn btn-outline-info btn-sm ml-auto" data-toggle="modal"
                            data-target="#modalTambah">
                            Tambah Data
                        </a>

                        <!-- Modal Tambah -->
                        <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">

                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">
                                            Tambah Aturan Pinjaman
                                        </h5>

                                        <button type="button" class="close" data-dismiss="modal">
                                            <span>&times;</span>
                                        </button>
                                    </div>

                                    <form action="{{ route('aturan-pinjaman.store') }}" method="POST">

                                        @csrf

                                        <div class="modal-body">

                                            <div class="form-group">
                                                <label>Penghasilan Minimal</label>

                                                <input type="number" name="penghasilan_min" class="form-control" required>
                                            </div>

                                            <div class="form-group">
                                                <label>Penghasilan Maksimal</label>

                                                <input type="number" name="penghasilan_max" class="form-control" required>
                                            </div>

                                            <div class="form-group">
                                                <label>Maksimal Pinjaman</label>

                                                <input type="number" name="maksimal_pinjaman" class="form-control"
                                                    required>
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
                                        <th>Penghasilan Minimal</th>
                                        <th>Penghasilan Maksimal</th>
                                        <th>Maksimal Pinjaman</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($aturanPinjaman as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>

                                            <td>
                                                Rp {{ number_format($item->penghasilan_min, 0, ',', '.') }}
                                            </td>

                                            <td>
                                                Rp {{ number_format($item->penghasilan_max, 0, ',', '.') }}
                                            </td>

                                            <td>
                                                Rp {{ number_format($item->maksimal_pinjaman, 0, ',', '.') }}
                                            </td>

                                            <td>
                                                <!-- Tombol Edit -->
                                                <button class="btn btn-warning btn-sm" data-toggle="modal"
                                                    data-target="#modalEdit{{ $item->id }}">
                                                    Edit
                                                </button>

                                                <!-- Tombol Hapus -->
                                                <form action="{{ route('aturan-pinjaman.destroy', $item->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Yakin ingin menghapus aturan ini?')">
                                                        Hapus
                                                    </button>
                                                </form>

                                            </td>
                                        </tr>

                                        {{-- Modal Edit --}}
                                        <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <form action="{{ route('aturan-pinjaman.update', $item->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Aturan Pinjaman</h5>
                                                            <button type="button" class="close" data-dismiss="modal">
                                                                <span>&times;</span>
                                                            </button>
                                                        </div>

                                                        <div class="modal-body">

                                                            <div class="form-group">
                                                                <label>Penghasilan Minimal</label>
                                                                <input type="number" name="penghasilan_min"
                                                                    class="form-control"
                                                                    value="{{ $item->penghasilan_min }}" required>
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Penghasilan Maksimal</label>
                                                                <input type="number" name="penghasilan_max"
                                                                    class="form-control"
                                                                    value="{{ $item->penghasilan_max }}" required>
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Maksimal Pinjaman</label>
                                                                <input type="number" name="maksimal_pinjaman"
                                                                    class="form-control"
                                                                    value="{{ $item->maksimal_pinjaman }}" required>
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

                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
