@extends('layouts.admin')

@section('title', 'Data Laporan')

@section('content')
    <a href="{{ route('admin.report.create') }}" class="mb-3 btn btn-primary">Tambah Data</a>

    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Data Laporan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode laporan </th>
                            <th>Pelapor</th>
                            <th>Judul laporan</th>
                            <th>Kategori laporan</th>
                            <th>Bukti laporan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reports as $report)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $report->code }}</td>
                                <td>{{ $report->resident->user->name }}</td>
                                <td>{{ $report->title }}</td>
                                <td>{{ $report->reportCategory->name }}</td>
                                <td>
                                    @if ($report->image)
                                        <img src="{{ asset('storage/' . $report->image) }}" alt="image" width="100">
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.report.edit', $report->id) }}" class="btn btn-warning">Edit</a>

                                    <a href="{{ route('admin.report.show', $report->id) }}" class="btn btn-info">Show</a>

                                    <form action="{{ route('admin.report.destroy', $report->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
