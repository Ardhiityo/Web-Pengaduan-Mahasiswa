@extends('layouts.app')

@section('title', 'Page Not Found')

@section('content')
    <div class="error-container">
        <div class="lottie-animation"></div>
        <div class="error-content">
            <h1>404</h1>
            <p>Oops! Halaman tidak ditemukan</p>
            <a href="{{ route('home') }}" class="btn btn-primary">Beranda</a>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.9.6/lottie.min.js"></script>
    <script>
        const animation = lottie.loadAnimation({
            container: document.querySelector('.lottie-animation'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: 'https://lottie.host/d987597c-7676-4424-8817-7fca6dc1a33e/BVrFXsaeui.json'
        });
    </script>
@endsection
