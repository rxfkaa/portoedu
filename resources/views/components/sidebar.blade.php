<div class="sidebar">

    <!-- Logo -->
    <div class="sidebar-logo">

        <div class="logo-icon">
            <i class="bi bi-mortarboard-fill"></i>
        </div>

        <div>

            <h4>DSP</h4>

            <small>Student Portfolio</small>

        </div>

    </div>

    @if(Auth::user()?->isTeacher() || Auth::user()?->isAdmin())
    <div class="sidebar-menu">
        <span class="menu-title">MENU GURU</span>
        <a href="{{ route('teacher.dashboard') }}" class="{{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}"><i class="bi bi-grid-fill"></i>Dashboard Guru</a>
        <a href="{{ route('teacher.verifications') }}" class="{{ request()->routeIs('teacher.verifications') ? 'active' : '' }}"><i class="bi bi-patch-check-fill"></i>Verifikasi Data</a>
        <a href="{{ route('teacher.projects') }}" class="{{ request()->routeIs('teacher.projects') ? 'active' : '' }}"><i class="bi bi-chat-square-text-fill"></i>Review Project</a>
    </div>
    @else
    <!-- Menu siswa -->
    <div class="sidebar-menu">

        <span class="menu-title">
            MAIN MENU
        </span>

        <a href="{{ route('dashboard') }}"
            class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">

            <i class="bi bi-grid-fill"></i>

            Dashboard

        </a>

        <a href="{{ route('profile') }}" class="{{ request()->routeIs('profile') ? 'active' : '' }}">

            <i class="bi bi-person-circle"></i>

            Profile

        </a>

        <a href="{{ route('achievements.index') }}"
            class="{{ request()->routeIs('achievements.*') ? 'active' : '' }}">

            <i class="bi bi-trophy-fill"></i>

            Prestasi

        </a>

        <a href="{{ route('certificates.index') }}" class="{{ request()->routeIs('certificates.*') ? 'active' : '' }}">

            <i class="bi bi-patch-check-fill"></i>

            Sertifikat

        </a>

        <a href="{{ route('projects.index') }}" class="{{ request()->routeIs('projects.*') ? 'active' : '' }}">

            <i class="bi bi-kanban-fill"></i>

            Project

        </a>

        <a href="{{ route('organizations.index') }}" class="{{ request()->routeIs('organizations.*') ? 'active' : '' }}">

            <i class="bi bi-people-fill"></i>

            Organisasi

        </a>

        <a href="{{ route('gallery.index') }}" class="{{ request()->routeIs('gallery.*') ? 'active' : '' }}">

            <i class="bi bi-images"></i>

            Gallery

        </a>

        <a href="{{ route('statistics.index') }}" class="{{ request()->routeIs('statistics.*') ? 'active' : '' }}">

            <i class="bi bi-graph-up"></i>

            Statistik

        </a>

        <a href="{{ route('qr-code.index') }}" class="{{ request()->routeIs('qr-code.*') ? 'active' : '' }}">

            <i class="bi bi-qr-code"></i>

            QR Code

        </a>

        <a href="{{ route('settings.index') }}" class="{{ request()->routeIs('settings.*') ? 'active' : '' }}">

            <i class="bi bi-gear-fill"></i>

            Settings

        </a>

    </div>

    <!-- User -->
    <div class="sidebar-user">

        <img
            src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Rafka') }}&background=2563EB&color=fff"
            alt="Avatar">

        <div>

            <strong>

                {{ Auth::user()->name ?? 'Rafka' }}

            </strong>

            <small>

                Online

            </small>

        </div>

    </div>
    @endif

    <form action="{{ route('logout') }}" method="POST" class="px-4 pb-4">
        @csrf
        <button type="submit" class="btn btn-outline-danger w-100 rounded-3">
            <i class="bi bi-box-arrow-right me-2"></i>Keluar
        </button>
    </form>

</div>
