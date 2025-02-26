@extends('layouts.admin')

@section('title', 'Edit Data Laporan')

@section('content')
    <!-- Page Heading -->
    <a href="{{ route('admin.report.index') }}" class="mb-3 btn btn-danger">Kembali</a>

    <!-- DataTales Example -->
    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Edit Data</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.report.update', Crypt::encrypt($report->id)) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="code">Kode</label>
                    <input type="text" class="form-control
                    @error('code') is-invalid @enderror"
                        id="code" name="code" value="{{ $report->code }}" disabled>
                    @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="resident_id">Pelapor</label>
                    </div>
                    <select class="custom-select
                    @error('title') is-invalid @enderror" id="resident_id"
                        name="resident_id">
                        <option selected>Pilih...</option>
                        @foreach ($residents as $resident)
                            <option value="{{ $resident->id }}"
                                {{ $resident->id == old('resident_id', $report->resident_id) ? 'selected' : '' }}>
                                {{ $resident->user->email }} -
                                {{ $resident->user->name }}</option>
                        @endforeach
                    </select>
                    @error('resident_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="report_category_id">Kategori laporan</label>
                    </div>
                    <select class="custom-select
                    @error('title') is-invalid @enderror"
                        id="report_category_id" name="report_category_id">
                        <option selected>Pilih...</option>
                        @foreach ($reportCategories as $reportCategory)
                            <option value="{{ $reportCategory->id }}"
                                {{ $reportCategory->id == old('report_category_id', $report->report_category_id) ? 'selected' : '' }}>
                                {{ $reportCategory->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('report_category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="title">Judul</label>
                    <input type="title" class="form-control
                    @error('title') is-invalid @enderror"
                        id="title" name="title" value="{{ old('title', $report->title) }}">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea name="description" id="description" class="@error('description') is-invalid @enderror form-control"
                        rows="3">{{ old('description', $report->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="image_old">Bukti laporan lama</label><br>
                    <img src="{{ asset('storage/' . $report->image) }}" alt="image" width="200">
                    <br>
                    <br>
                    <label for="image">Bukti laporan baru</label>
                    <input type="file" class="form-control
                    @error('image') is-invalid @enderror"
                        id="image" name="image" value="{{ old('image') }}">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="address">Alamat</label>
                    <textarea name="address" id="address" class="@error('address') is-invalid @enderror form-control" rows="3">{{ old('address', $report->address) }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="latitude">Latitude</label>
                    <input type="text" class="form-control
                    @error('latitude') is-invalid @enderror"
                        id="latitude" name="latitude" value="{{ old('latitude', $report->latitude) }}">
                    @error('latitude')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="longitude">Longitude</label>
                    <input type="text" class="form-control
                    @error('longitude') is-invalid @enderror"
                        id="longitude" name="longitude" value="{{ old('longitude', $report->longitude) }}">
                    @error('longitude')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

@endsection
