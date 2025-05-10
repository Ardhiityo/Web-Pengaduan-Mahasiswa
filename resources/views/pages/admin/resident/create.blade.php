@extends('layouts.admin')

@section('title', 'Tambah Data Mahasiswa')

@section('content')
    <!-- Page Heading -->
    <a href="{{ route('admin.resident.index') }}" class="mb-3 btn btn-danger">Kembali</a>

    <!-- DataTales Example -->
    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Data</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.resident.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Nama Mahasiswa</label>
                    <input type="text" required
                        class="form-control
                    @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name') }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input required type="email"
                        class="form-control
                    @error('email') is-invalid @enderror" id="email"
                        name="email" value="{{ old('email') }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nim">NIM</label>
                    <input type="text" class="form-control
                    @error('nim') is-invalid @enderror"
                        id="nim" name="nim" value="{{ old('nim') }}" required>
                    @error('nim')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="my-4 input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="status">Prodi</label>
                    </div>
                    <select class="custom-select
                    @error('study_program_id') is-invalid @enderror"
                        required id="study_program_id" name="study_program_id">
                        <option value="">Pilih...</option>
                        @foreach ($studyPrograms as $studyProgram)
                            <option value="{{ $studyProgram->id }}"
                                {{ old('study_program_id') == $studyProgram->id ? 'selected' : '' }}>
                                {{ $studyProgram->name }}</option>
                            </option>
                        @endforeach
                    </select>
                    @error('study_program_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input required type="password"
                        class="form-control
                    @error('password') is-invalid @enderror" id="password"
                        name="password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
