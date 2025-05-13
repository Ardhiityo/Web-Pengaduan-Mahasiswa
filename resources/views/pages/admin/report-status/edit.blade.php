@extends('layouts.admin')

@section('title', 'Edit Data Kemajuan Laporan')

@section('content')
    <a href="{{ route('admin.report.show', ['report' => $reportStatus->report_id]) }}" class="mb-3 btn btn-danger">Kembali</a>

    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Edit Data Kemajuan Laporan {{ $reportStatus->report->code }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.report-status.update', ['report_status' => $reportStatus->id]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="report_id" value="{{ $reportStatus->report->id }}">
                <div class="mb-3 input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="status">Status Kemajuan Laporan</label>
                    </div>
                    <select class="custom-select
                    @error('status') is-invalid @enderror" id="status"
                        name="status">
                        <option value="">Pilih...</option>
                        <option value="delivered"
                            {{ old('status', $reportStatus->status) == 'delivered' ? 'selected' : '' }}>Diterima</option>
                        <option value="in_process"
                            {{ old('status', $reportStatus->status) == 'in_process' ? 'selected' : '' }}>Sedang diproses
                        </option>
                        <option value="completed"
                            {{ old('status', $reportStatus->status) == 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="rejected" {{ old('status', $reportStatus->status) == 'rejected' ? 'selected' : '' }}>
                            Ditolak</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="image">Bukti Kemajuan Laporan</label>
                    <br>
                    @if ($reportStatus->image)
                        <img src="{{ asset('storage/' . $reportStatus->image) }}" alt="image" width="200">
                    @else
                        -
                    @endif
                    <br>
                    <br>
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
                        rows="3">{{ old('description', $reportStatus->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
