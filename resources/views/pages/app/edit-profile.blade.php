@extends('layouts.app')

@section('title', 'Setelan akun')

@section('content')
    <div class="text-center">
        <h4>Setelan akun</h4>
        <p>Harap bijak dalam penggunaan akunmu.</p>
    </div>
    <form action="{{ route('profile.update') }}" class="mt-5" method="POST" enctype="multipart/form-data">
        @method('PATCH')
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nama lengkap</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                value="{{ old('name', $resident->user->name) }}">
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="avatar" class="form-label">Avatar</label>
            <input type="file" class="form-control @error('avatar') is-invalid @enderror" id="avatar" name="avatar">
            @error('avatar')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
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
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password_confirmation"
                name="password_confirmation">
        </div>

        <button class="mt-2 btn btn-primary w-100" type="submit" color="primary">
            Konfirmasi
        </button>
    </form>
@endsection
