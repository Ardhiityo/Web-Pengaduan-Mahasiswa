<nav class="mb-4 bg-white shadow navbar navbar-expand navbar-light topbar static-top">
    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="mr-3 btn btn-link d-md-none rounded-circle">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="ml-auto navbar-nav">
        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <span id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 text-gray-600 d-none d-lg-inline small">{{ Auth::user()->email }}</span>
                <i class="fa fa-chevron-down"></i>
            </span>
            <!-- Dropdown - User Information -->
            <div class="shadow dropdown-menu dropdown-menu-right animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ route('admin.profile.edit') }}">
                    <i class="mr-2 text-gray-400 fas fa-cogs fa-sm fa-fw"></i>
                    Edit Profil
                </a>

                <div class="dropdown-divider"></div>

                <a class="dropdown-item"
                    onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();
                        "
                    style="cursor: pointer">

                    <form action="{{ route('logout') }}" id="logout-form" class="d-none" method="POST">
                        @csrf
                    </form>

                    <i class="mr-2 text-gray-400 fas fa-sign-out-alt fa-sm fa-fw "></i>
                    Keluar
                </a>
            </div>
        </li>
    </ul>
</nav>
