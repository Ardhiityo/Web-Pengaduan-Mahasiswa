@extends('layouts.admin')

@section('title', 'Detail Kemajuan Laporan')

@section('content')
    <!-- Page Heading -->
    <a href="{{ route('admin.report.show', Crypt::encrypt($reportStatus->report->id)) }}"
        class="mb-3 btn btn-danger">Kembali</a>

    <!-- DataTales Example -->
    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Detail kemajuan Laporan {{ $reportStatus->report->code }}</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <td>Bukti kemajuan laporan</td>
                    <td>
                        @if ($reportStatus->image)
                            <img src="{{ asset('storage/' . $reportStatus->image) }}" alt="image">
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Status kemajuan laporan</td>
                    <td>{{ $reportStatus->status }}</td>
                </tr>
                <tr>
                    <td>Deskripsi kemajuan laporan</td>
                    <td>{{ $reportStatus->description }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
