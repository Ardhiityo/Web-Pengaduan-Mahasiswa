@extends('layouts.auth')

@section('title', 'Daftar akun')

@section('content')
    <h5 class="mt-5 fw-bold">Daftar sebagai pengguna baru</h5>
    <p class="mt-2 text-muted">Silahkan mengisi form dibawah ini untuk mendaftar</p>

    <form action="{{ route('register.store') }}" method="POST" class="mt-4" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                value="{{ old('email') }}">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="full_name" name="name"
                value="{{ old('name') }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="avatar" class="form-label">Foto Profil</label>
            <input type="file" class="form-control @error('avatar') is-invalid @enderror" id="avatar" name="avatar">
            @error('avatar')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                name="password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
        </div>

        <button class="mt-2 btn btn-primary w-100" type="submit" color="primary" id="btn-login">
            Masuk
        </button>

        <div class="mt-3 d-flex justify-content-between">
            <a href="{{ route('login') }}" class="text-decoration-none text-primary">Sudah punya akun?</a>
        </div>
    </form>
@endsection
