@extends('layouts.auth')

@section('title', 'Masuk')

@section('content')
    <h5 class="mt-5 fw-bold">Selamat datang di Simpel 👋</h5>
    <p class="mt-2 text-muted">Silahkan masuk untuk melanjutkan</p>

    <a class="py-2 mt-4 btn btn-primary w-100" href="{{ route('redirect') }}">
        <i class="fa-brands fa-google me-2"></i>
        Masuk / Daftar
    </a>

    <div class="mt-2 d-flex align-items-center">
        <hr class="flex-grow-1">
        <span class="mx-2">atau</span>
        <hr class="flex-grow-1">
    </div>

    <form action="{{ route('login.store') }}" method="POST" class="mt-4">
        @csrf
        {{-- Register success --}}
        @if (session()->has('success'))
            <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                    <path
                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                </symbol>
            </svg>

            <div class="alert alert-primary d-flex align-items-center" role="alert">
                <svg class="flex-shrink-0 bi me-2" width="24" height="24" role="img" aria-label="Success:">
                    <use xlink:href="#check-circle-fill" />
                </svg>
                <div>
                    {{ session('success') }}
                </div>
            </div>
        @endif
        {{-- Register success --}}

        {{-- Fortify message update password --}}
        @if (session()->has('status'))
            <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                    <path
                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                </symbol>
            </svg>

            <div class="alert alert-primary d-flex align-items-center" role="alert">
                <svg class="flex-shrink-0 bi me-2" width="24" height="24" role="img" aria-label="Success:">
                    <use xlink:href="#check-circle-fill" />
                </svg>
                <div>
                    {{ session('status') }}
                </div>
            </div>
        @endif
        {{-- Fortify message update password --}}

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
            <a href="{{ route('register') }}" class="text-decoration-none text-primary">Belum punya akun?</a>
            <a href="{{ url('forgot-password') }}" class="text-decoration-none text-primary">Lupa
                Password</a>
        </div>

    </form>
@endsection
