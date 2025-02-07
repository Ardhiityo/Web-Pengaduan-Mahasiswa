    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="mx-3 sidebar-brand-text">Simpel</div>
        </a>

        <!-- Divider -->
        <hr class="my-0 sidebar-divider">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item
        {{ request()->is('admin/dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <!-- Nav Item - Tables -->
        <li class="nav-item
        {{ request()->is('admin/resident*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.resident.index') }}">
                <i class="fas fa-fw fa-table"></i>
                <span>Data Masyarakat</span></a>
        </li>

        <!-- Nav Item - Tables -->
        <li class="nav-item
        {{ request()->is('admin/report-category*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.report-category.index') }}">
                <i class="fas fa-fw fa-table"></i>
                <span>Data Kategori</span></a>
        </li>

        <!-- Nav Item - Tables -->
        <li
            class="nav-item
        {{ request()->is('admin/report') || request()->is('admin/report/*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.report.index') }}">
                <i class="fas fa-fw fa-table"></i>
                <span>Data Laporan</span></a>
        </li>


    </ul>
