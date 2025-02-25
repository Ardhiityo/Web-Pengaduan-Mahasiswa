@extends('layouts.admin')

@section('title', 'Edit Data Mahasiswa')

@section('content')
    <!-- Page Heading -->
    <a href="{{ route('admin.resident.index') }}" class="mb-3 btn btn-danger">Kembali</a>

    <!-- DataTales Example -->
    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Edit Data</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.resident.update', Crypt::encrypt($resident->id)) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="name">Nama Mahasiswa</label>
                    <input type="text" class="form-control
                    @error('name') is-invalid @enderror"
                        id="name" name="name" value="{{ old('name', $resident->user->name) }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control
                    @error('email') is-invalid @enderror"
                        id="email" name="email" value="{{ old('email', $resident->user->email) }}" readonly>
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
