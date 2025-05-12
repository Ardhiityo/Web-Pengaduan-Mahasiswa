@extends('layouts.admin')

@section('title', 'Edit Data Mahasiswa')

@section('content')
    <a href="{{ route('admin.resident.index') }}" class="mb-3 btn btn-danger">Kembali</a>

    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Edit Data</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.resident.update', ['resident' => $resident->id]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Nama Mahasiswa</label>
                    <input type="text"
                        class="form-control required:
                    @error('name') is-invalid @enderror"
                        id="name" name="name" value="{{ old('name', $resident->user->name) }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" required
                        class="form-control
                    @error('email') is-invalid @enderror" id="email"
                        name="email" value="{{ old('email', $resident->user->email) }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="nim">NIM</label>
                    <input type="text" required
                        class="form-control required
                    @error('nim') is-invalid @enderror" id="nim"
                        name="nim" value="{{ old('nim', $resident->nim ?? '') }}">
                    @error('nim')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="faculty_id">Program Studi</label>
                    </div>
                    <select class="custom-select
                    @error('study_program_id') is-invalid @enderror"
                        id="study_program_id" name="study_program_id" required>
                        <option value="">Pilih...</option>
                        @foreach ($studyPrograms as $studyProgram)
                            <option value="{{ $studyProgram->id }}"
                                {{ $studyProgram->id == old('study_program_id', $resident->studyProgram->id) ? 'selected' : '' }}>
                                {{ $studyProgram->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('study_program_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control
                    @error('password') is-invalid @enderror"
                        id="password" name="password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input type="password"
                        class="form-control
                    @error('password_confirmation') is-invalid @enderror"
                        id="password_confirmation" name="password_confirmation">
                </div>
                <div class="form-group">
                    <label for="avatar">Foto profil</label>
                    <input type="file" class="form-control
                    @error('avatar') is-invalid @enderror"
                        id="avatar" name="avatar" value="{{ old('avatar') }}">
                    @error('avatar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
