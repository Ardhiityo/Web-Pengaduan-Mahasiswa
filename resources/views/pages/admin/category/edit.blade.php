@extends('layouts.admin')

@section('title', 'Edit Data Kategori')

@section('content')
    <a href="{{ route('admin.report-category.index') }}" class="mb-3 btn btn-danger">Kembali</a>

    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Edit Data</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.report-category.update', ['report_category' => $reportCategory->id]) }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Nama Kategori</label>
                    <input type="text" required
                        class="form-control
                    @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name', $reportCategory->name) }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="old_image">Ikon Lama</label> <br>
                    <img src="{{ asset('storage/' . $reportCategory->image) }}" alt="image" width="200">
                    <br>
                    <br>
                    <label for="image">Ikon Baru</label>
                    <input type="file" class="form-control
                    @error('image') is-invalid @enderror"
                        id="image" name="image" value="{{ old('image') }}">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
