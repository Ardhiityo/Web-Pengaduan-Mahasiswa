@extends('layouts.admin')

@section('title', 'Tambah Data Fakultas')

@section('content')
    <a href="{{ route('admin.admin.show', ['admin' => $adminId]) }}" class="mb-3 btn btn-danger">Kembali</a>

    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Data</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.admin-faculty.store', ['admin' => $adminId]) }}" method="POST">
                @csrf
                <div class="mb-3 input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="faculty_id">Fakultas</label>
                    </div>
                    <select class="custom-select
                    @error('faculty_id') is-invalid @enderror"
                        id="faculty_id" name="faculty_id">
                        <option value="">Pilih...</option>
                        @foreach ($faculties as $faculty)
                            <option value="{{ $faculty->id }}" {{ $faculty->id == old('faculty_id') ? 'selected' : '' }}>
                                {{ $faculty->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('faculty_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
