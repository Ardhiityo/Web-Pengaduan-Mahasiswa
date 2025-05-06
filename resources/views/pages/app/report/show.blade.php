  @extends('layouts.app')

  @section('title', $report->code)

  @section('content')
      <div class="header-nav">
          <a href="{{ route('home') }}">
              <img src="{{ asset('assets/app/images/icons/ArrowLeft.svg') }}" alt="arrow-left">
          </a>
          <h1>Laporanmu</h1>
      </div>

      <img src="{{ asset('storage/' . $report->image) }}" alt="image" class="mt-5 report-image">

      <h1 class="mt-3 report-title">{{ $report->title }}</h1>

      <div class="mt-4 card card-report-information">
          <div class="card-body">
              <div class="mb-4 card-title fw-bold">Detail Informasi</div>

              <div class="mb-3 row">
                  <div class="col-4 text-dark">Kode laporan</div>
                  <div class="col-8 d-flex">
                      <span class="me-2">
                          :
                      </span>
                      <p class="col-12">
                          {{ $report->code }}
                      </p>
                  </div>
              </div>
              <div class="mb-3 row">
                  <div class="col-4 text-dark">Tanggal</div>
                  <div class="col-8 d-flex">
                      <span class="me-2">
                          :
                      </span>
                      <p>
                          {{ $report->created_at }}
                      </p>
                  </div>
              </div>
              <div class="mb-3 row">
                  <div class="col-4 text-dark">Kategori</div>
                  <div class="col-8 d-flex">
                      <span class="me-2">
                          :
                      </span>
                      <p>
                          {{ $report->reportCategory->name }}
                      </p>
                  </div>
              </div>
              <div class="mb-3 row">
                  <div class="col-4 text-dark">Lokasi</div>
                  <div class="col-8 d-flex">
                      <span class="me-2">
                          :
                      </span>
                      <p>
                          {{ $report->address }}
                      </p>
                  </div>
              </div>
              @if ($report->reportStatuses->first())
                  @foreach ($report->reportStatuses as $status)
                      <div class="mb-3 row">
                          <div class="col-4 text-dark">Status</div>
                          <div class="col-8 d-flex">
                              <span class="me-2">
                                  :
                              </span>
                              @if ($status->status === 'delivered')
                                  <div class='badge-success'>
                                      <img src="{{ asset('assets/app/images/icons/Checks.svg') }}" alt="delivered">
                                      Diterima
                                  </div>
                              @endif
                              @if ($status->status === 'in_process')
                                  <div class='badge-success'>
                                      <img src="{{ asset('assets/app/images/icons/Checks.svg') }}" alt="in_process">
                                      Diproses
                                  </div>
                              @endif
                              @if ($status->status === 'completed')
                                  <div class='badge-success'>
                                      <img src="{{ asset('assets/app/images/icons/Checks.svg') }}" alt="completed">
                                      Selesai
                                  </div>
                              @endif
                              @if ($status->status === 'rejected')
                                  <div class='badge-pending'>
                                      <img src="{{ asset('assets/app/images/icons/exclamation-circle.svg') }}"
                                          alt="rejected">
                                      Ditolak
                                  </div>
                              @endif
                          </div>
                      </div>
                  @endforeach
              @else
                  <div class="mb-3 row">
                      <div class="col-4 text-secondary">Status</div>
                      <div class="col-8 d-flex">
                          <span class="me-2">
                              :
                          </span>
                          <div class='badge-pending'>
                              <img src="{{ asset('assets/app/images/icons/CircleNotch.svg') }}" alt="pending">
                              Belum diterima
                          </div>
                      </div>
                  </div>
              @endif
          </div>
      </div>

      @if ($report->reportStatuses->first())
          <div class="mt-4 card card-report-information">
              <div class="card-body">
                  <div class="mb-4 card-title fw-bold">Riwayat Perkembangan</div>

                  <ul class="timeline">
                      @foreach ($report->reportStatuses as $status)
                          <li class="timeline-item">
                              <div class="timeline-item-content">
                                  <span class="timeline-date">{{ $status->created_at }}</span>
                                  <br>
                                  <span class="timeline-event">{{ $status->description }}</span>
                                  @if ($status->image)
                                      <br>
                                      <img src="{{ asset('storage/' . $status->image) }}" alt="image"
                                          class="rounded img-fluid rounded-5">
                                  @endif
                              </div>
                          </li>
                      @endforeach
                  </ul>
              </div>
          </div>
      @endif

  @endsection
