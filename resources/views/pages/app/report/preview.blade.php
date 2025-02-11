@extends('layouts.capture')

@section('title', 'Tinjau foto')

@section('content')
    <div class="d-flex flex-column justify-content-center align-items-center">
        <img alt="image" id="image-preview" class="img-fluid rounded-2">

        <div class="gap-3 mt-3 d-flex justify-content-center">

            <a href="{{ route('report.take') }}" class="btn btn-outline-primary">
                Ulangi Foto
            </a>
            <a href="{{ route('report.take.create-report') }}" class="btn btn-primary">
                Gunakan Foto
            </a>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var image = localStorage.getItem('image');
        var imagePreview = document.getElementById('image-preview');
        imagePreview.src = image;
    </script>
@endsection
