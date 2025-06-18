@extends('layouts.admin')

@section('title', 'Data Admin')

@section('content')
    <a href="{{ route('admin.faculty.create') }}" class="mb-3 btn btn-primary">Tambah Data</a>

    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Data Fakultas
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Program Studi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($faculties as $faculty)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $faculty->name }}</td>
                                <td>
                                    {{ $faculty->studyPrograms->isEmpty() ? '-' : $faculty->studyPrograms->pluck('name')->implode(', ') }}
                                </td>
                                <td>
                                    <a href="{{ route('admin.faculty.show', ['faculty' => $faculty->id]) }}"
                                        class="my-1 btn btn-info btn-sm">Show</a>

                                    <a href="{{ route('admin.faculty.edit', ['faculty' => $faculty->id]) }}"
                                        class="my-1 btn btn-warning btn-sm">Edit</a>

                                    <form action="{{ route('admin.faculty.destroy', ['faculty' => $faculty->id]) }}"
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
