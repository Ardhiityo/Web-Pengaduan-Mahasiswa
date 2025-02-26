@extends('layouts.admin')

@section('title', 'Tambah Data FAQ')

@section('content')
    <!-- Page Heading -->
    <a href="{{ route('admin.faq.index') }}" class="mb-3 btn btn-danger">Kembali</a>

    <!-- DataTales Example -->
    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Data</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.faq.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="title">Judul FAQ</label>
                    <input type="text" class="form-control
                    @error('title') is-invalid @enderror"
                        id="title" name="title" value="{{ old('title') }}" required minlength="3">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea name="description" id="description" class="@error('description') is-invalid @enderror form-control"
                        rows="3" required minlength="5">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
