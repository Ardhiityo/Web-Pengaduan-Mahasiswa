@extends('layouts.capture')
@section('title', 'Ambil foto')
@section('content')
    <div class="d-flex flex-column justify-content-center align-items-center">
        <video autoplay="true" id="video-webcam">
            Browsermu tidak mendukung bro, upgrade donk!
        </video>
        <div class="bottom-0 mt-3 d-flex justify-content-center position-absolute">
            <button class="mb-3 btn btn-primary btn-snap " onclick="takeSnapshot()">
                <i class="fas fa-camera"></i>
            </button>
        </div>
    </div>
@endsection
