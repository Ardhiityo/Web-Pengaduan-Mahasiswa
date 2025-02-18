@extends('layouts.app')

@section('title', 'Pusat bantuan')

@section('content')
    <section class="mt-3">
        <h6 class="fw-bold">FAQ (Frequently Asked Questions)</h6>
        <p class="mt-1">Disini kamu akan menemukan pertanyaan yang mungkin sesuai dengan kamu apabila memiliki sebuah
            pertanyaan, selamat membaca.</p>
    </section>

    <section class="mt-4">
        @foreach ($faqs as $faq)
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $loop->iteration }}" aria-expanded="true"
                            aria-controls="collapse{{ $loop->iteration }}">
                            {{ $faq->title }}
                        </button>
                    </h2>
                    <div id="collapse{{ $loop->iteration }}" class="accordion-collapse collapse"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            {{ $faq->description }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </section>
@endsection
