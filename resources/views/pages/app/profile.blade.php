@extends('layouts.app')

@section('title', 'Profil')

@section('content')
    <div class="gap-2 d-flex flex-column justify-content-center align-items-center">
        <img src="{{ asset('storage/' . Auth::user()->resident->avatar) }}" alt="avatar" class="avatar">
        <h5>{{ Auth::user()->name }}</h5>
    </div>

    <div class="mt-4 row">
        <div class="col-6">
            <div class="card profile-stats">
                <div class="card-body">
                    <h5 class="card-title">{{ $reportActive }}</h5>
                    <p class="card-text">Laporan Aktif</p>
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="card profile-stats">
                <div class="card-body">
                    <h5 class="card-title">{{ $reportDone }}</h5>
                    <p class="card-text">Laporan Selesai</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <div class="list-group list-group-flush">
            <a href="{{ route('profile.edit') }}"
                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                <div class="gap-3 d-flex align-items-center">
                    <i class="fa-solid fa-user"></i>
                    <p class="fw-light">Setelan Akun</p>
                </div>
                <i class="fa-solid fa-chevron-right"></i>
            </a>
        </div>

        <div class="mt-4">
            <button class="btn btn-outline-danger w-100 rounded-pill btn-primary"
                onclick="event.preventDefault(); document.getElementById('logout').submit()">
                Keluar
            </button>
        </div>
        <form action="{{ route('logout') }}" method="post" id="logout">
            @csrf
        </form>
    </div>
@endsection
