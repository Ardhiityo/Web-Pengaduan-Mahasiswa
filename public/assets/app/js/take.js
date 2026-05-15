const video = document.querySelector('#video-webcam');

let currentFacingMode = 'environment'; // 'environment' = belakang, 'user' = depan
let currentStream = null;

function startCamera(facingMode) {
    if (currentStream) {
        currentStream.getTracks().forEach(track => track.stop());
    }

    navigator.mediaDevices.getUserMedia({ video: { facingMode: facingMode } })
        .then(function (stream) {
            currentStream = stream;
            video.srcObject = stream;
        })
        .catch(function (err) {
            if (err.name === 'NotAllowedError') {
                alert('Izin kamera ditolak. Silakan izinkan akses kamera di pengaturan browser.');
            } else if (err.name === 'NotFoundError') {
                if (facingMode === 'environment') {
                    startCamera('user'); // fallback ke kamera depan
                } else {
                    alert('Kamera tidak ditemukan di perangkat ini.');
                }
            } else {
                alert('Tidak dapat mengakses kamera: ' + err.message);
            }
        });
}

function flipCamera() {
    currentFacingMode = currentFacingMode === 'environment' ? 'user' : 'environment';
    startCamera(currentFacingMode);
}

function takeSnapshot() {
    var canvas = document.createElement('canvas');
    var context = canvas.getContext('2d');
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    context.drawImage(video, 0, 0);
    localStorage.setItem('image', canvas.toDataURL('image/png'));
    window.location.href = '/reports/take/preview';
}

// Hanya init kamera jika elemen video ada di halaman ini
if (video) {
    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        const isHttp = location.protocol === 'http:';
        const isLocalhost = location.hostname === 'localhost' || location.hostname === '127.0.0.1';

        if (isHttp && !isLocalhost) {
            alert(
                'Akses kamera membutuhkan koneksi HTTPS.\n\n' +
                'Buka halaman ini melalui:\n' +
                'https://' + location.hostname + location.pathname
            );
        } else {
            alert('Browser kamu tidak mendukung akses kamera. Gunakan Chrome, Firefox, atau Safari versi terbaru.');
        }
    } else {
        startCamera(currentFacingMode);
    }
}
