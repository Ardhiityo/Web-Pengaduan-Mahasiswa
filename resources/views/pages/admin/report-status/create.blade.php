@extends('layouts.admin')

@section('title', 'Tambah Kemajuan Laporan')

@section('content')
    <a href="{{ route('admin.report.show', ['report' => $report->id]) }}" class="mb-3 btn btn-danger">Kembali</a>

    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Data Kemajuan Laporan {{ $report->code }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.report-status.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="report_id" value="{{ $report->id }}">
                <div class="mb-3 input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="status">Status Kemajuan Laporan</label>
                    </div>
                    <select class="custom-select
                    @error('status') is-invalid @enderror" id="status"
                        name="status">
                        <option value="">Pilih...</option>
                        <option value="delivered" {{ old('status') == 'delivered' ? 'selected' : '' }}>Diterima</option>
                        <option value="in_process" {{ old('status') == 'in_process' ? 'selected' : '' }}>Sedang diproses
                        </option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="image">Bukti Kemajuan Laporan</label>
                    <input type="file" class="form-control
                    @error('image') is-invalid @enderror"
                        id="image" name="image" value="{{ old('image') }}">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="description">Deskripsi Kemajuan Laporan</label>
                    <textarea name="description" id="description" class="@error('description') is-invalid @enderror form-control"
                        rows="3" required>{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
