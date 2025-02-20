@extends('layouts.admin')

@section('title', 'Page Not Found')


@section('content')
    <div class="container-fluid">
        <!-- 404 Error Text -->
        <div class="text-center">
            <div class="mx-auto error" data-text="404">404</div>
            <p class="mb-5 text-gray-800 lead">Page Not Found</p>
            <p class="mb-0 text-gray-500">Oops, halaman tidak ditemukan!</p>
            <a href="{{ route('admin.dashboard') }}">&larr; Dashboard</a>
        </div>
    </div>
@endsection
