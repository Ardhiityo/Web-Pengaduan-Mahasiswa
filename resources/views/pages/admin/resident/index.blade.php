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
                            <th>Nim</th>
                            <th>Email</th>
                            <th>Program Studi</th>
                            <th>Foto profil</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($residents as $resident)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $resident->user->name }}</td>
                                <td>{{ $resident->nim }}</td>
                                <td>{{ $resident->user->email }}</td>
                                <td>{{ $resident->studyProgram->name }}</td>
                                <td>
                                    @if ($resident->avatar)
                                        <img src="{{ asset('storage/' . $resident->avatar) }}" alt="avatar"
                                            width="100">
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.resident.show', ['resident' => $resident->id]) }}"
                                        class="my-1 btn btn-sm btn-info">
                                        Show
                                    </a>
                                    <a href="{{ route('admin.resident.edit', ['resident' => $resident->id]) }}"
                                        class="my-1 btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.resident.destroy', ['resident' => $resident->id]) }}"
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
