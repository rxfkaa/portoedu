<div class="sidebar">

    <!-- Logo -->
    <div class="sidebar-logo">
        <div class="logo-icon">
            <i class="bi bi-mortarboard-fill"></i>
        </div>
        <div>
            <h4>PortoEdu</h4>
            <small>Digital Portfolio</small>
        </div>
    </div>

    @if(Auth::user()?->isAdmin())
    <!-- Menu Admin -->
    <div class="sidebar-menu">
        <span class="menu-title">MENU ADMIN</span>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i>{{ __t('admin_dashboard') }}
        </a>
<a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i>{{ __t('manage_users') }}
        </a>
        <a href="{{ route('admin.activities') }}" class="{{ request()->routeIs('admin.activities') ? 'active' : '' }}">
            <i class="bi bi-activity"></i>{{ __t('activity_log') }}
        </a>
        <a href="{{ route('admin.classes') }}" class="{{ request()->routeIs('admin.classes') ? 'active' : '' }}">
            <i class="bi bi-door-open-fill"></i>{{ __t('manage_classes') }}
        </a>
        <a href="{{ route('admin.departments') }}" class="{{ request()->routeIs('admin.departments') ? 'active' : '' }}">
            <i class="bi bi-building-fill"></i>{{ __t('manage_departments') }}
        </a>
        <hr class="my-3">
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-fill"></i>{{ __t('my_dashboard') }}
        </a>
    </div>
    @elseif(Auth::user()?->isTeacher())
    <!-- Menu Guru -->
    <div class="sidebar-menu">
        <span class="menu-title">MENU GURU</span>
        <a href="{{ route('teacher.dashboard') }}" class="{{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-fill"></i>{{ __t('teacher_dashboard') }}
        </a>
        <a href="{{ route('teacher.verifications') }}" class="{{ request()->routeIs('teacher.verifications') ? 'active' : '' }}">
            <i class="bi bi-patch-check-fill"></i>{{ __t('verification') }}
        </a>
        <a href="{{ route('teacher.projects') }}" class="{{ request()->routeIs('teacher.projects') ? 'active' : '' }}">
            <i class="bi bi-chat-square-text-fill"></i>{{ __t('project_review') }}
        </a>
        <a href="{{ route('teacher.statistics') }}" class="{{ request()->routeIs('teacher.statistics') ? 'active' : '' }}">
            <i class="bi bi-bar-chart-fill"></i>{{ __t('comparison_statistics') }}
        </a>
        <hr class="my-3">
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i>{{ __t('my_dashboard') }}
        </a>
    </div>
    @else
    <!-- Menu Siswa -->
    <div class="sidebar-menu">
        <span class="menu-title">MAIN MENU</span>
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-fill"></i>{{ __t('dashboard') }}
        </a>
        <a href="{{ route('profile') }}" class="{{ request()->routeIs('profile') ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i>{{ __t('profile') }}
        </a>
        <a href="{{ route('achievements.index') }}" class="{{ request()->routeIs('achievements.*') ? 'active' : '' }}">
            <i class="bi bi-trophy-fill"></i>{{ __t('achievements') }}
        </a>
        <a href="{{ route('certificates.index') }}" class="{{ request()->routeIs('certificates.*') ? 'active' : '' }}">
            <i class="bi bi-patch-check-fill"></i>{{ __t('certificates') }}
        </a>
        <a href="{{ route('projects.index') }}" class="{{ request()->routeIs('projects.*') ? 'active' : '' }}">
            <i class="bi bi-kanban-fill"></i>{{ __t('projects') }}
        </a>
        <a href="{{ route('skills.index') }}" class="{{ request()->routeIs('skills.*') ? 'active' : '' }}">
            <i class="bi bi-lightning-fill"></i>{{ __t('skills') }}
        </a>
        <a href="{{ route('internships.index') }}" class="{{ request()->routeIs('internships.*') ? 'active' : '' }}">
            <i class="bi bi-building"></i>{{ __t('internships') }}
        </a>
        <a href="{{ route('organizations.index') }}" class="{{ request()->routeIs('organizations.*') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i>{{ __t('organizations') }}
        </a>
        <a href="{{ route('gallery.index') }}" class="{{ request()->routeIs('gallery.*') ? 'active' : '' }}">
            <i class="bi bi-images"></i>{{ __t('gallery') }}
        </a>
        <a href="{{ route('statistics.index') }}" class="{{ request()->routeIs('statistics.*') ? 'active' : '' }}">
            <i class="bi bi-graph-up"></i>{{ __t('statistics') }}
        </a>
        <a href="{{ route('qr-code.index') }}" class="{{ request()->routeIs('qr-code.*') ? 'active' : '' }}">
            <i class="bi bi-qr-code"></i>{{ __t('qr_code') }}
        </a>
        <a href="{{ route('portfolio.export.pdf') }}" class="text-success">
            <i class="bi bi-file-earmark-pdf-fill"></i>{{ __t('export_pdf') }}
        </a>
        <a href="{{ route('settings.index') }}" class="{{ request()->routeIs('settings.*') ? 'active' : '' }}">
            <i class="bi bi-gear-fill"></i>{{ __t('settings') }}
        </a>
    </div>
    @endif

<!-- User Info & Logout -->
    @php
        $avatarUrl = 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name ?? 'User') . '&background=2563EB&color=fff';
        if (Auth::user()?->student?->photo) {
            $avatarUrl = asset('storage/' . Auth::user()->student->photo);
        }
    @endphp
    <div class="sidebar-bottom" style="margin-top: auto; padding: 20px 24px 0;">
        <div class="sidebar-user d-flex align-items-center gap-3 p-3 bg-light rounded-4 mb-3">
            <img src="{{ $avatarUrl }}" alt="Avatar" style="width: 48px; height: 48px; border-radius: 50%; object-fit: cover;">
            <div>
                <strong>{{ Auth::user()->name ?? 'User' }}</strong>
                <small class="text-success d-block">Online</small>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-danger w-100 rounded-3">
                <i class="bi bi-box-arrow-right me-2"></i>{{ __t('logout') }}
            </button>
        </form>
    </div>
</div>
