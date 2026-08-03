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

    @if(Auth::user()?->isAdmin())
    <!-- Menu Admin -->
    <div class="sidebar-menu">
        <span class="menu-title">MENU ADMIN</span>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i>Dashboard Admin
        </a>
        <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i>Kelola User
        </a>
        <a href="{{ route('admin.classes') }}" class="{{ request()->routeIs('admin.classes') ? 'active' : '' }}">
            <i class="bi bi-door-open-fill"></i>Kelola Kelas
        </a>
        <a href="{{ route('admin.departments') }}" class="{{ request()->routeIs('admin.departments') ? 'active' : '' }}">
            <i class="bi bi-building-fill"></i>Kelola Jurusan
        </a>
        <hr class="my-3">
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-fill"></i>Dashboard Saya
        </a>
    </div>
    @elseif(Auth::user()?->isTeacher())
    <!-- Menu Guru -->
    <div class="sidebar-menu">
        <span class="menu-title">MENU GURU</span>
        <a href="{{ route('teacher.dashboard') }}" class="{{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-fill"></i>Dashboard Guru
        </a>
        <a href="{{ route('teacher.verifications') }}" class="{{ request()->routeIs('teacher.verifications') ? 'active' : '' }}">
            <i class="bi bi-patch-check-fill"></i>Verifikasi Data
        </a>
        <a href="{{ route('teacher.projects') }}" class="{{ request()->routeIs('teacher.projects') ? 'active' : '' }}">
            <i class="bi bi-chat-square-text-fill"></i>Review Project
        </a>
        <hr class="my-3">
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i>Dashboard Saya
        </a>
    </div>
    @else
    <!-- Menu Siswa -->
    <div class="sidebar-menu">
        <span class="menu-title">MAIN MENU</span>
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-fill"></i>Dashboard
        </a>
        <a href="{{ route('profile') }}" class="{{ request()->routeIs('profile') ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i>Profile
        </a>
        <a href="{{ route('achievements.index') }}" class="{{ request()->routeIs('achievements.*') ? 'active' : '' }}">
            <i class="bi bi-trophy-fill"></i>Prestasi
        </a>
        <a href="{{ route('certificates.index') }}" class="{{ request()->routeIs('certificates.*') ? 'active' : '' }}">
            <i class="bi bi-patch-check-fill"></i>Sertifikat
        </a>
        <a href="{{ route('projects.index') }}" class="{{ request()->routeIs('projects.*') ? 'active' : '' }}">
            <i class="bi bi-kanban-fill"></i>Project
        </a>
        <a href="{{ route('skills.index') }}" class="{{ request()->routeIs('skills.*') ? 'active' : '' }}">
            <i class="bi bi-lightning-fill"></i>Skills
        </a>
        <a href="{{ route('internships.index') }}" class="{{ request()->routeIs('internships.*') ? 'active' : '' }}">
            <i class="bi bi-building"></i>PKL/Internship
        </a>
        <a href="{{ route('organizations.index') }}" class="{{ request()->routeIs('organizations.*') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i>Organisasi
        </a>
        <a href="{{ route('gallery.index') }}" class="{{ request()->routeIs('gallery.*') ? 'active' : '' }}">
            <i class="bi bi-images"></i>Gallery
        </a>
        <a href="{{ route('statistics.index') }}" class="{{ request()->routeIs('statistics.*') ? 'active' : '' }}">
            <i class="bi bi-graph-up"></i>Statistik
        </a>
        <a href="{{ route('qr-code.index') }}" class="{{ request()->routeIs('qr-code.*') ? 'active' : '' }}">
            <i class="bi bi-qr-code"></i>QR Code
        </a>
        <a href="{{ route('portfolio.export.pdf') }}" class="text-success">
            <i class="bi bi-file-earmark-pdf-fill"></i>Export PDF
        </a>
        <a href="{{ route('settings.index') }}" class="{{ request()->routeIs('settings.*') ? 'active' : '' }}">
            <i class="bi bi-gear-fill"></i>Settings
        </a>
    </div>
    @endif

    <!-- User Info & Logout -->
    <div class="sidebar-bottom" style="margin-top: auto; padding: 20px 24px 0;">
        <div class="sidebar-user d-flex align-items-center gap-3 p-3 bg-light rounded-4 mb-3">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&background=2563EB&color=fff" alt="Avatar" style="width: 48px; height: 48px; border-radius: 50%;">
            <div>
                <strong>{{ Auth::user()->name ?? 'User' }}</strong>
                <small class="text-success d-block">Online</small>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-danger w-100 rounded-3">
                <i class="bi bi-box-arrow-right me-2"></i>Keluar
            </button>
        </form>
    </div>
</div>
