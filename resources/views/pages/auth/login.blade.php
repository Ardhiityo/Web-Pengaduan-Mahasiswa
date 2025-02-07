@extends('layouts.auth')

@section('title', 'Masuk')

@section('content')
    <h5 class="mt-5 fw-bold">Selamat datang di Lapor Pak 👋</h5>
    <p class="mt-2 text-muted">Silahkan masuk untuk melanjutkan</p>

    <button class="py-2 mt-4 btn btn-primary w-100" type="button">
        <i class="fa-brands fa-google me-2"></i>
        Masuk dengan Google
    </button>

    <div class="mt-2 d-flex align-items-center">
        <hr class="flex-grow-1">
        <span class="mx-2">atau</span>
        <hr class="flex-grow-1">
    </div>

    <form action="{{ route('login.store') }}" method="POST" class="mt-4">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control
            @error('email') is-invalid @enderror" id="email"
                name="email" value="{{ old('email') }}">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                name="password" value="{{ old('password') }}" id="password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button class="mt-2 btn btn-primary w-100" type="submit" color="primary" id="btn-login">
            Masuk
        </button>

        <div class="mt-3 d-flex justify-content-between">
            <a href="signup.html" class="text-decoration-none text-primary">Belum punya akun?</a>
            <a href="" class="text-decoration-none text-primary">Lupa
                Password</a>
        </div>

    </form>
@endsection
