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

        {{-- Register failed --}}
        @if (session()->has('error'))
            <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                    <path
                        d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                </symbol>
            </svg>

            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <svg class="flex-shrink-0 bi me-2" width="24" height="24" role="img" aria-label="Danger:">
                    <use xlink:href="#exclamation-triangle-fill" />
                </svg>
                <div>
                    {{ session('error') }}
                </div>
            </div>
        @endif
        {{-- Register failed --}}

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
