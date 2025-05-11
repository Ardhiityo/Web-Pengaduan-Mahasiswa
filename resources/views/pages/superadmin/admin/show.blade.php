@extends('layouts.admin')

@section('title', 'Detail Admin')

@section('content')
    <a href="{{ route('admin.admin.index') }}" class="mb-3 btn btn-danger">Kembali</a>

    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Detail Admin</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <td>Nama</td>
                    <td>{{ $admin->name }}</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>{{ $admin->email }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Fakultas</h6>
        </div>
        <div class="card-body">
            <a href="{{ route('admin.admin-faculty.create', ['admin' => $admin->id]) }}" class="mb-3 btn btn-primary">
                Tambah Fakultas
            </a>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admin->faculties as $faculty)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $faculty->name }}</td>
                                <td>
                                    <form
                                        action="{{ route('admin.admin-faculty.destroy', ['admin' => $admin->id, 'faculty' => $faculty->id]) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="my-1 btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
