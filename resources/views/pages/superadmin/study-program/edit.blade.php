@extends('layouts.admin')

@section('title', 'Edit Data Program Studi')

@section('content')
    <a href="{{ route('admin.faculty.show', ['faculty' => request('faculty')]) }}" class="mb-3 btn btn-danger">Kembali</a>

    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Edit Data</h6>
        </div>
        <div class="card-body">
            <form
                action="{{ route('admin.study-program.update', ['faculty' => request('faculty'), 'study_program' => $studyProgram->id]) }}"
                method="POST">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="name">Nama Program Studi</label>
                    <input type="text" class="form-control
                @error('name') is-invalid @enderror"
                        id="name" name="name" value="{{ old('name', $studyProgram->name) }}" required
                        minlength="3">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
