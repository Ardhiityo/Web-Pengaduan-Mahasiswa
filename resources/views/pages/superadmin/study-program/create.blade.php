@extends('layouts.admin')

@section('title', 'Tambah Data Program Studi')

@section('content')
    <a href="{{ route('admin.faculty.show', ['faculty' => request('faculty')]) }}" class="mb-3 btn btn-danger">Kembali</a>

    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Data</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.study-program.store', ['faculty' => request('faculty')]) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Nama Studi Program</label>
                    <input type="text" class="form-control
                    @error('name') is-invalid @enderror"
                        id="name" name="name" value="{{ old('name') }}" required minlength="3">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
