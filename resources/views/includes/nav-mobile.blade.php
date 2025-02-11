    <div class="floating-button-container d-flex" onclick="window.location.href = '{{ route(name: 'report.take') }}'">
        <button class="floating-button">
            <i class="fa-solid fa-camera"></i>
        </button>
    </div>
    <nav class="nav-mobile d-flex">
        <a href="{{ route('home') }}" class="{{ request()->is('/') ? 'active' : '' }}">
            <i class="fas fa-house"></i>
            Beranda
        </a>
        <a href="{{ route('myreport', ['status' => 'delivered']) }}"
            class="{{ request()->is('myreports') ? 'active' : '' }}">
            <i class="fas fa-solid fa-clipboard-list"></i>
            Laporanmu
        </a>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <a href="" class="">
            <i class="fas fa-bell"></i>
            Notifikasi
        </a>
        <a href="{{ route('profile') }}" class="{{ request()->is('profile') ? 'active' : '' }}">
            <i class="fas fa-user"></i>
            Profil
        </a>
    </nav>
