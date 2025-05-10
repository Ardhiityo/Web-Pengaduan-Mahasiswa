@extends('layouts.admin')

@section('title', 'Data Admin')

@section('content')
    <a href="{{ route('admin.admin.create') }}" class="mb-3 btn btn-primary">Tambah Data</a>

    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Data Admin
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Fakultas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $admin)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $admin->user->name }}</td>
                                <td>{{ $admin->user->email }}</td>
                                <td>{{ $admin->faculty->name }}</td>
                                <td>
                                    <a href="{{ route('admin.admin.show', Crypt::encrypt($admin->id)) }}"
                                        class="my-1 btn btn-info btn-sm">Show</a>

                                    <a href="{{ route('admin.admin.edit', Crypt::encrypt($admin->id)) }}"
                                        class="my-1 btn btn-warning btn-sm">Edit</a>

                                    <form action="{{ route('admin.admin.destroy', Crypt::encrypt($admin->id)) }}"
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
