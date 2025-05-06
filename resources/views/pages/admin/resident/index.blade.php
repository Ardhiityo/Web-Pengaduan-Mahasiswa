@extends('layouts.admin')

@section('title', 'Data Mahasiswa')

@section('content')
    <a href="{{ route('admin.resident.create') }}" class="mb-3 btn btn-primary">Tambah Data</a>

    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Data Mahasiswa</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama </th>
                            <th>Email</th>
                            <th>Foto profil</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($residents as $resident)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $resident->user->name }}</td>
                                <td>{{ $resident->user->email }}</td>
                                <td>
                                    @if ($resident->avatar)
                                        <img src="{{ asset('storage/' . $resident->avatar) }}" alt="avatar"
                                            width="100">
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.resident.edit', Crypt::encrypt($resident->id)) }}"
                                        class="my-1 btn btn-sm btn-warning">Edit</a>

                                    <a href="{{ route('admin.resident.show', Crypt::encrypt($resident->id)) }}"
                                        class="my-1 btn btn-sm btn-info">Show</a>

                                    <form action="{{ route('admin.resident.destroy', Crypt::encrypt($resident->id)) }}"
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
