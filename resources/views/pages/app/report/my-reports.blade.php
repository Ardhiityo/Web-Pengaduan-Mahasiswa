@extends('layouts.app')

@section('title', 'Laporanmu')

@section('content')
    <ul class="nav nav-tabs" id="filter-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <a href="{{ url()->current() }}?status=delivered"
                class="nav-link {{ request('status') == 'delivered' ? 'active' : '' }}" id="terkirim-tab"
                role="tab">Diterima</a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="{{ url()->current() }}?status=in_process"
                class="nav-link {{ request('status') == 'in_process' ? 'active' : '' }}" id="diproses-tab"
                role="tab">Diproses</a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="{{ url()->current() }}?status=completed"
                class="nav-link {{ request('status') == 'completed' ? 'active' : '' }}" id="selesai-tab"
                role="tab">Selesai</a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="{{ url()->current() }}?status=rejected"
                class="nav-link {{ request('status') == 'rejected' ? 'active' : '' }}" id="ditolak-tab"
                role="tab">Ditolak</a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">

        <div class="tab-pane fade show active" id="terkirim-tab-pane" role="tabpanel" aria-labelledby="terkirim-tab"
            tabindex="0">
            <div class="gap-3 mt-3 d-flex flex-column">
                @foreach ($reports as $report)
                    <div class="border-0 shadow-none card card-report">
                        <a href="{{ route('report.code', $report->report->code) }}" class="text-decoration-none text-dark">
                            <div class="p-0 card-body">
                                <div class="mb-2 card-report-image position-relative">
                                    <img src="{{ asset('storage/' . $report->report->image) }}" alt="image">

                                    @if (isset($report->status))
                                        <div
                                            class="{{ $report->status === 'completed' ? 'badge-status done' : 'badge-status on-process' }}">
                                            @if ($report->status === 'delivered')
                                                Diterima
                                            @endif
                                            @if ($report->status === 'in_process')
                                                Diproses
                                            @endif
                                            @if ($report->status === 'completed')
                                                Selesai
                                            @endif
                                            @if ($report->status === 'rejected')
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
                                        <img src="{{ asset('assets/app/images/icons/MapPin.png') }}" alt="map pin"
                                            class="icon me-2">
                                        <p class="text-primary city">
                                            {{ \Illuminate\Support\Str::words($report->report->address, 3, '...') }}
                                        </p>
                                    </div>

                                    <p class="text-secondary date">
                                        Pada {{ \Illuminate\Support\Str::words($report->report->created_at, 3, '...') }}
                                    </p>
                                </div>

                                <h1 class="card-title">
                                    {{ \Illuminate\Support\Str::words($report->report->title, 3, '...') }}
                                </h1>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="tab-pane fade" id="diproses-tab-pane" role="tabpanel" aria-labelledby="diproses-tab" tabindex="0">
            <div class="gap-3 mt-3 d-flex flex-column">
                @foreach ($reports as $report)
                    <div class="border-0 shadow-none card card-report">
                        <a href="{{ route('report.code', $report->report->code) }}" class="text-decoration-none text-dark">
                            <div class="p-0 card-body">
                                <div class="mb-2 card-report-image position-relative">
                                    <img src="{{ asset('storage/' . $report->report->image) }}" alt="image">

                                    @if (isset($report->status))
                                        <div
                                            class="{{ $report->status === 'completed' ? 'badge-status done' : 'badge-status on-process' }}">
                                            @if ($report->status === 'delivered')
                                                Diterima
                                            @endif
                                            @if ($report->status === 'in_process')
                                                Diproses
                                            @endif
                                            @if ($report->status === 'completed')
                                                Selesai
                                            @endif
                                            @if ($report->status === 'rejected')
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
                                        <img src="{{ asset('assets/app/images/icons/MapPin.png') }}" alt="map pin"
                                            class="icon me-2">
                                        <p class="text-primary city">
                                            {{ \Illuminate\Support\Str::words($report->report->address, 3, '...') }}
                                        </p>
                                    </div>

                                    <p class="text-secondary date">
                                        Pada {{ \Illuminate\Support\Str::words($report->report->created_at, 3, '...') }}
                                    </p>
                                </div>

                                <h1 class="card-title">
                                    {{ \Illuminate\Support\Str::words($report->report->title, 3, '...') }}
                                </h1>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="tab-pane fade" id="selesai-tab-pane" role="tabpanel" aria-labelledby="selesai-tab" tabindex="0">
            <div class="gap-3 mt-3 d-flex flex-column">
                @foreach ($reports as $report)
                    <div class="border-0 shadow-none card card-report">
                        <a href="{{ route('report.code', $report->report->code) }}" class="text-decoration-none text-dark">
                            <div class="p-0 card-body">
                                <div class="mb-2 card-report-image position-relative">
                                    <img src="{{ asset('storage/' . $report->report->image) }}" alt="image">

                                    @if (isset($report->status))
                                        <div
                                            class="{{ $report->status === 'completed' ? 'badge-status done' : 'badge-status on-process' }}">
                                            @if ($report->status === 'delivered')
                                                Diterima
                                            @endif
                                            @if ($report->status === 'in_process')
                                                Diproses
                                            @endif
                                            @if ($report->status === 'completed')
                                                Selesai
                                            @endif
                                            @if ($report->status === 'rejected')
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
                                        <img src="{{ asset('assets/app/images/icons/MapPin.png') }}" alt="map pin"
                                            class="icon me-2">
                                        <p class="text-primary city">
                                            {{ \Illuminate\Support\Str::words($report->report->address, 2, '...') }}
                                        </p>
                                    </div>

                                    <p class="text-secondary date">
                                        Pada {{ \Illuminate\Support\Str::words($report->report->created_at, 3, '...') }}
                                    </p>
                                </div>

                                <h1 class="card-title">
                                    {{ \Illuminate\Support\Str::words($report->report->title, 2, '...') }}
                                </h1>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="tab-pane fade" id="ditolak-tab-pane" role="tabpanel" aria-labelledby="ditolak-tab" tabindex="0">
            <div class="gap-3 mt-3 d-flex flex-column">
                @foreach ($reports as $report)
                    <div class="border-0 shadow-none card card-report">
                        <a href="{{ route('report.code', $report->report->code) }}"
                            class="text-decoration-none text-dark">
                            <div class="p-0 card-body">
                                <div class="mb-2 card-report-image position-relative">
                                    <img src="{{ asset('storage/' . $report->report->image) }}" alt="image">

                                    @if (isset($report->status))
                                        <div
                                            class="{{ $report->status === 'completed' ? 'badge-status done' : 'badge-status on-process' }}">
                                            @if ($report->status === 'delivered')
                                                Diterima
                                            @endif
                                            @if ($report->status === 'in_process')
                                                Diproses
                                            @endif
                                            @if ($report->status === 'completed')
                                                Selesai
                                            @endif
                                            @if ($report->status === 'rejected')
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
                                        <img src="{{ asset('assets/app/images/icons/MapPin.png') }}" alt="map pin"
                                            class="icon me-2">
                                        <p class="text-primary city">
                                            {{ \Illuminate\Support\Str::words($report->report->address, 3, '...') }}
                                        </p>
                                    </div>

                                    <p class="text-secondary date">
                                        Pada {{ \Illuminate\Support\Str::words($report->report->created_at, 3, '...') }}
                                    </p>
                                </div>

                                <h1 class="card-title">
                                    {{ \Illuminate\Support\Str::words($report->report->title, 3, '...') }}
                                </h1>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
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
        })
    </script>
@endsection
