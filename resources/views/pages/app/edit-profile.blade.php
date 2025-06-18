@extends('layouts.app')

@section('title', 'Setelan akun')

@section('content')
    <main class="pb-5">
        <div class="text-center">
            <h4>Setelan akun</h4>
            <p>Harap bijak dalam penggunaan akunmu.</p>
            @if (session('notes'))
                <p class="mt-2 text-danger">{{ session('notes') }}</p>
            @endif
        </div>
        <form action="{{ route('profile.update') }}" class="mt-5" method="POST" enctype="multipart/form-data">
            @method('PATCH')
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nama lengkap</label>
                <input type="text" required class="form-control @error('name') is-invalid @enderror" id="name"
                    name="name" value="{{ old('name', $resident->user->name) }}">
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" required class="form-control @error('email') is-invalid @enderror" id="email"
                    name="email" value="{{ old('email', $resident->user->email) }}">
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="avatar" class="form-label">Avatar</label>
                <input type="file" class="form-control @error('avatar') is-invalid @enderror" id="avatar"
                    name="avatar">
                @error('avatar')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="nim" class="form-label">NIM</label>
                <input type="text" required class="form-control @error('nim') is-invalid @enderror" id="nim"
                    name="nim" value="{{ old('nim', $resident->nim) }}">
                @error('nim')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="study_program_id" class="form-label">Program Studi</label>
                <div class="form-floating">
                    <select class="form-select @error('study_program_id') is-invalid @enderror" required
                        id="study_program_id"" name="study_program_id">
                        <option value="">Pilih Program Studi...</option>
                        @foreach ($studyPrograms as $studyProgram)
                            <option value="{{ $studyProgram->id }}"
                                {{ old('study_program_id', $resident->study_program_id) == $studyProgram->id ? 'selected' : '' }}>
                                {{ $studyProgram->name }}</option>
                            </option>
                        @endforeach
                    </select>
                    @error('study_program_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                    name="password">
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Konfirmasi password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror"
                    id="password_confirmation" name="password_confirmation">
            </div>

            <button class="mt-2 btn btn-primary w-100" type="submit" color="primary">
                Konfirmasi
            </button>
        </form>
    </main>
@endsection
