@extends('layouts.capture')
@section('title', 'Buat laporan')

@section('content')
    <h3 class="mb-3">Laporkan segera masalahmu di sini!</h3>

    <p class="text-dark">Isi form dibawah ini dengan baik dan benar sehingga kami dapat memvalidasi dan
        menangani
        laporan kamu
        secepatnya

    <form action="{{ route('report.take.create-report.store') }}" method="POST" class="mt-4" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Judul Laporan</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                required value="{{ old('title') }}">
            @error('title')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="report_category_id" class="form-label">Kategori Laporan</label>
            <select required class="form-select @error('report_category_id') is-invalid @enderror" id="report_category_id"
                name="report_category_id">
                <option value="">Pilih...</option>
                @foreach ($reportCategories as $reportCategory)
                    <option value="{{ $reportCategory->id }}"
                        {{ old('report_category_id') == $reportCategory->id ? 'selected' : '' }}>
                        {{ $reportCategory->name }}
                    </option>
                @endforeach
            </select>
            @error('report_category_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="study_program_id" class="form-label">Kepada Program Studi</label>
            <select required class="form-select @error('report_category_id') is-invalid @enderror" id="study_program_ids"
                name="study_program_id">
                <option value="">Pilih...</option>
                @foreach ($studyPrograms as $studyProgram)
                    <option value="{{ $studyProgram->id }}"
                        {{ old('study_program_id', $resident->study_program_id) == $studyProgram->id ? 'selected' : '' }}>
                        {{ $studyProgram->name }}
                    </option>
                @endforeach
            </select>
            @error('study_program_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Bukti Laporan</label>
            <input required type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                name="image" style="display: none;" value="{{ old('image') }}">
            <img alt="image" id="image-preview" class="mb-3 border img-fluid rounded-2">
            @error('image')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Ceritakan Laporan Kamu</label>
            <textarea required class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                rows="5">{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="map" class="form-label">Lokasi Laporan</label>
            <div id="map"></div>
        </div>

        <div class="mb-3">
            <label for="latitude" class="form-label">Latitude</label>
            <input type="text" class="form-control @error('latitude') is-invalid @enderror" id="latitude"
                name="latitude" value="{{ old('latitude') }}">
            @error('latitude')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="longitude" class="form-label">Longitude</label>
            <input type="text" class="form-control @error('longitude') is-invalid @enderror" id="longitude"
                name="longitude" value="{{ old('longitude') }}">
            @error('longitude')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Alamat Lengkap</label>
            <textarea required class="form-control @error('address') is-invalid @enderror" id="address" name="address"
                rows="3">{{ old('address') }}</textarea>
            @error('address')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button class="mt-2 btn btn-primary w-100" type="submit" color="primary">
            Laporkan
        </button>
    </form>
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // Ambil base64 dari localStorage
        var imageBase64 = localStorage.getItem('image');

        // Mengubah base64 menjadi binary Blob
        function base64ToBlob(base64, mime) {
            var byteString = atob(base64.split(',')[1]);
            var ab = new ArrayBuffer(byteString.length);
            var ia = new Uint8Array(ab);
            for (var i = 0; i < byteString.length; i++) {
                ia[i] = byteString.charCodeAt(i);
            }
            return new Blob([ab], {
                type: mime
            });
        }

        // Fungsi untuk membuat objek file dan set ke input file
        function setFileInputFromBase64(base64) {
            // Mengubah base64 menjadi Blob
            var blob = base64ToBlob(base64, 'image/jpeg'); // Ganti dengan tipe mime sesuai gambar Anda
            var file = new File([blob], 'image.jpg', {
                type: 'image/jpeg'
            }); // Nama file dan tipe MIME

            // Set file ke input file
            var imageInput = document.getElementById('image');
            var dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            imageInput.files = dataTransfer.files;

            // Menampilkan preview gambar
            var imagePreview = document.getElementById('image-preview');
            imagePreview.src = URL.createObjectURL(file);
        }

        // Set nilai input file dan preview gambar
        setFileInputFromBase64(imageBase64);
    </script>

    <script src="{{ asset('assets/app/js/report.js') }}"></script>
@endsection
