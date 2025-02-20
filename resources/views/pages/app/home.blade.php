@extends('layouts.app')

@section('title', 'Home')

@section('content')
    @auth
        <h6 class="text-primary">Hai, {{ Auth::user()->name }} 👋</h6>
    @else
        <h6 class="text-dark">Selamat datang, Sahabat Mafik 👋</h6>
    @endauth
    <h4 class="home-headline">Laporkan masalahmu,
        <br>Kita Tuntaskan Lewat Cara yang
        Elegan!
    </h4>

    <div class="gap-4 py-3 overflow-auto d-flex align-items-center justify-content-between" id="category"
        style="white-space: nowrap;">
        @foreach ($reportCategories as $reportCategory)
            <a href="{{ route('report.index', ['category' => $reportCategory->name]) }}" class="category d-inline-block">
                <div class="icon">
                    <img src="{{ asset('storage/' . $reportCategory->image) }}" alt="icon">
                </div>
                <p>{{ $reportCategory->name }}</p>
            </a>
        @endforeach
    </div>

    <div class="py-3" id="reports">
        <div class="d-flex justify-content-between align-items-center">
            <h6>Pengaduan terbaru</h6>
            <a href="{{ route('report.index') }}" class="text-dark text-decoration-none show-more">
                Lihat semua
            </a>
        </div>

        <div class="gap-3 mt-3 d-flex flex-column">
            @forelse ($latestReports as $report)
                <div class="border-0 shadow-none card card-report">
                    <a href="{{ route('report.code', $report->code) }}" class="text-decoration-none text-dark">
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
                                        {{ \Illuminate\Support\Str::words($report->address, 2, '...') }}
                                    </p>
                                </div>

                                <p class="text-dark date">
                                    Pada {{ \Illuminate\Support\Str::words($report->created_at, 3, '...') }}
                                </p>
                            </div>

                            <h1 class="card-title">
                                {{ \Illuminate\Support\Str::words($report->title, 2, '...') }}
                            </h1>
                        </div>
                    </a>
                </div>
            @empty
                <div class="d-flex flex-column justify-content-center align-items-center" style="height: 50vh"
                    id="no-reports">
                    <div id="lottie"></div>
                    <h5>Belum ada laporan</h5>
                </div>
            @endforelse
        </div>
    </div>
@endsection


@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.12.2/lottie.min.js"></script>
    <script>
        var animation = bodymovin.loadAnimation({
            container: document.getElementById('lottie'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: '{{ asset('assets/app/lottie/not-found.json') }}'
        });
    </script>
@endsection
