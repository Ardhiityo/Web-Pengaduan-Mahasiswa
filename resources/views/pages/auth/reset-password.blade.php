@extends('layouts.auth')

@section('title', 'Ganti password')

@section('content')
    <h5 class="mt-5 fw-bold">Selalu jaga akun untuk privasimu.</h5>
    <p class="mt-2 text-muted">Silahkan lanjutkan pergantian sandi.</p>

    <form action="{{ url('/reset-password') }}" method="POST" class="mt-4">
        @csrf

        <input type="hidden" name="token" value="{{ request()->route('token') }}">

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                value="{{ old('email') }}" id="email">
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

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <input type="password" class="form-control id="password" name="password_confirmation" id="password">
        </div>

        <button class="mt-2 btn btn-primary w-100" type="submit" color="primary" id="btn-login">
            Ubah password
        </button>

    </form>
@endsection
