@extends('layouts.auth')

@section('title', 'Lupa password')

@section('content')
@section('content')
    <h5 class="mt-5 fw-bold">Selalu jaga privasi akunmu.</h5>
    <p class="mt-2 text-muted">Silahkan masukan email untuk melanjutkan</p>

    <form action="{{ url('/forgot-password') }}" method="POST" class="mt-4">
        @csrf

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

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control
            @error('email') is-invalid @enderror" id="email"
                name="email" value="{{ old('email') }}">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button class="mt-2 btn btn-primary w-100" type="submit" color="primary" id="btn-login">
            Kirim verifikasi
        </button>

    </form>
@endsection

@endsection
