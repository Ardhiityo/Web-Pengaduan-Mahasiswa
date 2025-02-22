@extends('layouts.auth')

@section('title', 'Verifikasi email')

@section('content')
    <h5 class="mt-5 fw-bold">Yuhu, langkah terakhir nih!</h5>
    <p class="mt-2 text-muted">Akun berhasil dibuat, tapi verifikasikan dulu yuk email kamu.</p>
    <form action="{{ url('/email/verification-notification') }}" method="POST" class="mt-4">
        @csrf

        @if (session('status') == 'verification-link-sent')
            <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
                <symbol id="check-circle-fill" viewBox="0 0 16 16">
                    <path
                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                </symbol>
            </svg>

            <div class="alert alert-primary d-flex align-items-center flex-column" role="alert">
                <div class="d-flex align-items-center">
                    <svg class="flex-shrink-0 bi me-3" width="24" height="24" role="img" aria-label="Success:">
                        <use xlink:href="#check-circle-fill" />
                    </svg>
                    <div>
                        Yeay, berhasil dikirim, waktunya cek email kamu, jangan lupa cek folder spam juga ya!
                    </div>
                </div>
                <div id="lottie"></div>
            </div>
        @else
            <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
                <symbol id="info-fill" viewBox="0 0 16 16">
                    <path
                        d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                </symbol>
            </svg>

            <div class="alert alert-primary d-flex align-items-center flex-column" role="alert">
                <div class="d-flex align-items-center">
                    <svg class="flex-shrink-0 bi me-3" width="24" height="24" role="img" aria-label="Info:">
                        <use xlink:href="#info-fill" />
                    </svg>

                    <div>
                        Setelah dapat link verifikasinya, jangan beritahu siapa-siapa yaa!
                    </div>
                </div>
                <div id="lottie"></div>
            </div>
        @endif

        <button class="mt-2 btn btn-primary w-100" type="submit" color="primary" id="btn-login">
            Verifikasi
        </button>

    </form>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.12.2/lottie.min.js"></script>
    <script>
        var animation = bodymovin.loadAnimation({
            container: document.getElementById('lottie'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: '{{ asset('assets/app/lottie/business-team.json') }}'
        });
    </script>
@endsection
