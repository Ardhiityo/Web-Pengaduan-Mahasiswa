    <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #6439ff">
        <a class="my-4 sidebar-brand d-flex flex-column align-items-center justify-content-center"
            href="{{ route('admin.dashboard') }}">
            <div class="sidebar-brand-icon">
                <img src="{{ asset('assets/admin/img/LogoUnival.png') }}" alt="logo" style="width: 45%"
                    style="padding: 50px">
            </div>
            <span style="font-family: 'Saira', serif;">Al-Khairiyah</span>
        </a>

        <hr class="my-0 sidebar-divider">

        <li class="nav-item
        {{ request()->is('admin/dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <li class="nav-item
        {{ request()->is('admin/resident*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.resident.index') }}">
                <i class="fas fa-fw fa-table"></i>
                <span>Data Mahasiswa</span></a>
        </li>

        @role('superadmin')
            <li class="nav-item
        {{ request()->is('admin/admin*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.admin.index') }}">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Data Admin</span></a>
            </li>
        @endrole

        @role('superadmin')
            <li class="nav-item
        {{ request()->is('admin/report-category*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.report-category.index') }}">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Data Kategori</span></a>
            </li>
        @endrole

        <li
            class="nav-item
        {{ request()->is('admin/report') || request()->is('admin/report/*') || request()->is('admin/report-status/*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.report.index') }}">
                <i class="fas fa-fw fa-table"></i>
                <span>Data Laporan</span></a>
        </li>

        @role('superadmin')
            <li
                class="nav-item
                {{ request()->is('admin/faq') || request()->is('admin/faq/*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.faq.index') }}">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Data FAQ</span></a>
            </li>
        @endrole
    </ul>
