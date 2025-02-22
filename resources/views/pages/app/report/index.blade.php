@extends('layouts.app')
@section('title', 'Laporan ' . request()->query('category'))

@section('content')
    <div class="py-3" id="reports">
        <div class="d-flex justify-content-between align-items-center">
            <p class="text-muted">{{ $totalReports }} Daftar Pengaduan</p>
        </div>

        @if ($category = request()->query('category'))
            <p>Kategori {{ $category }}</p>
        @endif

        <div class="gap-3 mt-3 d-flex flex-column">

            @foreach ($reports as $report)
                <div class="border-0 shadow-none card card-report">
                    <a href="{{ route('report.show', Crypt::encrypt($report->id)) }}" class="text-decoration-none text-dark">
                        <div class="p-0 card-body">
                            <div class="mb-2 card-report-image position-relative">
                                <img src="{{ asset('storage/' . $report->image) }}" alt="image">

                                @if (isset($report->reportStatuses->last()->status))
                                    <div
                                        class="{{ $report->reportStatuses->last()->status === 'completed' ? 'badge-status done' : 'badge-status on-process' }}">
                                        @if ($report->reportStatuses->last()->status === 'delivered')
                                            Diterima
                                        @endif
                                        @if ($report->reportStatuses->last()->status === 'in_process')
                                            Diproses
                                        @endif
                                        @if ($report->reportStatuses->last()->status === 'completed')
                                            Selesai
                                        @endif
                                        @if ($report->reportStatuses->last()->status === 'rejected')
                                            Ditolak
                                        @endif
                                    </div>
                                @else
                                    <div class="badge-status on-process">
                                        Belum diterima
                                    </div>
                                @endif

                            </div>

                            <div class="mb-2 d-flex justify-content-between align-items-end">
                                <div class="d-flex align-items-center ">
                                    <i class="fa-solid fa-location-dot icon me-2"></i>
                                    <p class="text-dark city">
                                        {{ $report->address }}
                                    </p>
                                </div>

                                <p class="text-dark date">
                                    {{ $report->created_at }}
                                </p>
                            </div>

                            <h1 class="card-title">
                                {{ $report->title }}
                            </h1>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
