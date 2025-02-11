@extends('layouts.capture')

@section('title', 'Laporan sukses dibuat!')

@section('content')
    <div class="d-flex flex-column justify-content-center align-items-center vh-75">
        <div id="lottie"></div>

        <h6 class="mb-2 text-center fw-bold">Yeay! Laporan kamu berhasil dibuat</h6>
        <p class="mb-4 text-center">Kamu bisa melihat laporan yang dibuat di halaman laporan</p>

        <a href="{{ route('myreport', ['status' => 'delivered']) }}" class="px-4 py-2 btn btn-primary">
            Lihat Laporan
        </a>
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
            path: '{{ asset('assets/app/lottie/success.json') }}'
        })
    </script>
@endsection
