@extends('layouts.admin')

@section('title', 'Detail Fakultas')


@section('content')
    <a href="{{ route('admin.faculty.index') }}" class="mb-3 btn btn-danger">Kembali</a>

    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Detail Fakultas</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <td>Nama</td>
                    <td>{{ $faculty->name }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Studi Program</h6>
        </div>
        <div class="card-body">
            <a href="{{ route('admin.study-program.create', ['faculty' => $faculty->id]) }}" class="mb-3 btn btn-primary">
                Tambah Program Studi
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
                        @foreach ($faculty->studyPrograms as $studyProgram)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $studyProgram->name }}</td>
                                <td>
                                    <a href="{{ route('admin.study-program.edit', ['faculty' => $faculty->id, 'study_program' => $studyProgram->id]) }}"
                                        class="my-1 btn btn-sm btn-warning">Edit</a>
                                    <form
                                        action="{{ route('admin.study-program.destroy', ['faculty' => $faculty->id, 'study_program' => $studyProgram->id]) }}"
                                        method="POST" class="d-inline">
                                        @method('DELETE')
                                        @csrf
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
