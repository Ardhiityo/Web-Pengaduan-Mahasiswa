@extends('layouts.admin')

@section('title', 'Detail Data Laporan')

@section('content')
    <!-- Page Heading -->
    <a href="{{ route('admin.report.index') }}" class="mb-3 btn btn-danger">Kembali</a>

    <!-- DataTales Example -->
    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Detail Laporan</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <td>Kode</td>
                    <td>{{ $report->code }}</td>
                </tr>
                <tr>
                    <td>Pelapor</td>
                    <td>{{ $report->resident->user->name }}</td>
                </tr>
                <tr>
                    <td>Nim</td>
                    <td>{{ $report->resident->nim }}</td>
                </tr>
                <tr>
                    <td>Program Studi</td>
                    <td>{{ $report->studyProgram->name }}</td>
                </tr>
                <tr>
                    <td>Judul</td>
                    <td>{{ $report->title }}</td>
                </tr>
                <tr>
                    <td>Kategori</td>
                    <td>{{ $report->reportCategory->name }}</td>
                </tr>
                <tr>
                    <td>Deskripsi</td>
                    <td>{{ $report->description }}</td>
                </tr>
                <tr>
                    <td>
                        Alamat
                    </td>
                    <td>{{ $report->address }}</td>
                </tr>
                <tr>
                    <td>Bukti</td>
                    <td>
                        <img src="{{ asset('storage/' . $report->image) }}" alt="image" width="200">
                    </td>
                </tr>
                <tr>
                    <td>Latitude</td>
                    <td>{{ $report->latitude }}</td>
                </tr>
                <tr>
                    <td>Longitude</td>
                    <td>{{ $report->longitude }}</td>
                </tr>
                <tr>
                    <td>Peta</td>
                    <td id="map" style="height: 300px"></td>
                </tr>
            </table>
        </div>
    </div>

    <div class="mb-4 shadow card">
        <div class="py-3 card-header">
            <h6 class="m-0 font-weight-bold text-primary">Status Laporan</h6>
        </div>
        <div class="card-body">
            <a href="{{ route('admin.report-status.create', Crypt::encrypt($report->id)) }}" class="mb-3 btn btn-primary">
                Tambah Kemajuan Laporan
            </a>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Bukti kemajuan laporan</th>
                            <th>Status laporan</th>
                            <th>Deskripsi laporan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($report->reportStatuses as $reportStatus)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if ($reportStatus->image)
                                        <img src="{{ asset('storage/' . $reportStatus->image) }}" alt="image"
                                            width="100">
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $reportStatus->status }}</td>
                                <td>{{ $reportStatus->description }}</td>
                                <td>
                                    <a href="{{ route('admin.report-status.show', Crypt::encrypt($reportStatus->id)) }}"
                                        class="my-1 btn btn-sm btn-info">Show</a>

                                    <a href="{{ route('admin.report-status.edit', Crypt::encrypt($reportStatus->id)) }}"
                                        class="my-1 btn btn-sm btn-warning">Edit</a>

                                    <form
                                        action="{{ route('admin.report-status.destroy', Crypt::encrypt($reportStatus->id)) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="my-1 btn btn-sm btn-danger">Delete</button>
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

@push('scripts')
    <script>
        var map = L.map('map').setView([{{ $report->latitude }}, {{ $report->longitude }}], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        var marker = L.marker([{{ $report->latitude }}, {{ $report->longitude }}]).addTo(map)
            .bindPopup("<b>Lokasi laporan</b><br>{{ $report->address }}").openPopup();
    </script>
@endpush
