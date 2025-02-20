@extends('layouts.admin')

@section('title', 'Halaman terlarang')

@section('content')
    <div class="container-fluid">
        <!-- 404 Error Text -->
        <div class="text-center">
            <div class="mx-auto error" data-text="403">403</div>
            <p class="mb-5 text-gray-800 lead">Halaman terlarang</p>
            <p class="mb-0 text-gray-500">Oops, kamu tidak diizinkan ke halaman ini!</p>
            <a href="{{ route('admin.dashboard') }}">&larr; Dashboard</a>
        </div>
    </div>
@endsection
