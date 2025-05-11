@extends('layouts.admin')

@section('title', 'Edit Data Admin')

@section('content')
    <!-- Page Heading -->
    <a href="{{ route('admin.admin.index') }}" class="mb-3 btn btn-danger">Kembali</a>

    <!-- DataTales Example -->
    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Edit Data</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.admin.update', ['admin' => $admin->id]) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label for="name">Nama Admin</label>
                    <input type="text" class="form-control
                    @error('name') is-invalid @enderror"
                        id="name" name="name" value="{{ old('name', $admin->name) }}" required minlength="3">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email"
                        class="@error('email') is-invalid @enderror form-control" rows="3" required minlength="5"
                        value="{{ old('email', $admin->email) }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password"
                        class="@error('password') is-invalid @enderror form-control" rows="3" minlength="5">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="@error('password_confirmation') is-invalid @enderror form-control" rows="3"
                        minlength="5">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
