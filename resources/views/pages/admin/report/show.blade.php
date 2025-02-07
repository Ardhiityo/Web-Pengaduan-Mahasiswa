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
                    <td>Judul laporan</td>
                    <td>{{ $report->title }}</td>
                </tr>
                <tr>
                    <td>Kategori laporan</td>
                    <td>{{ $report->reportCategory->name }}</td>
                </tr>
                <tr>
                    <td>Deskripsi laporan</td>
                    <td>{{ $report->description }}</td>
                </tr>
                <tr>
                    <td>
                        Alamat
                    </td>
                    <td>{{ $report->address }}</td>
                </tr>
                <tr>
                    <td>Bukti laporan</td>
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

@endsection

@section('scripts')
    <script>
        var map = L.map('map').setView([{{ $report->latitude }}, {{ $report->longitude }}], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        var marker = L.marker([{{ $report->latitude }}, {{ $report->longitude }}]).addTo(map)
            .bindPopup("<b>Lokasi laporan</b><br>{{ $report->address }}").openPopup();
    </script>
@endsection
