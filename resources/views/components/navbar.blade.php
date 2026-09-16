<nav class="top-navbar">

    <!-- LEFT -->
    <div class="navbar-left">
        <button id="toggleSidebar" class="menu-btn">
            <i class="bi bi-list"></i>
        </button>
        <div class="search-box">
            <i class="bi bi-search"></i>
            <input id="globalSearch" type="text" placeholder="{{ __t('search_hint') }}">
        </div>
    </div>

<!-- RIGHT -->
    <div class="navbar-right">

        <!-- Language Switch -->
        @php $currentLocale = session('locale', 'id'); @endphp
        <div class="dropdown">
            <button class="icon-btn" data-bs-toggle="dropdown" title="{{ __t('language') }}">
                <i class="bi bi-translate"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4">
                <li>
                    <a class="dropdown-item {{ $currentLocale === 'id' ? 'active' : '' }}" href="{{ route('locale', 'id') }}">
                        🇮🇩 <span class="ms-1">Bahasa Indonesia</span>
                        @if($currentLocale === 'id')<i class="bi bi-check2 ms-2"></i>@endif
                    </a>
                </li>
                <li>
                    <a class="dropdown-item {{ $currentLocale === 'en' ? 'active' : '' }}" href="{{ route('locale', 'en') }}">
                        🇬🇧 <span class="ms-1">English</span>
                        @if($currentLocale === 'en')<i class="bi bi-check2 ms-2"></i>@endif
                    </a>
                </li>
            </ul>
        </div>

        <!-- Dark Mode -->
        <button class="icon-btn" id="darkToggle" title="{{ __t('dark_mode') }}" aria-label="{{ __t('dark_mode') }}">
            <i class="bi bi-moon-stars-fill"></i>
        </button>

<!-- Notification (khusus akun siswa) -->
        @if(Auth::user()?->isStudent())
        @php $unreadCount = \App\Models\Notification::where('user_id', Auth::id())->unread()->count(); @endphp
        <a href="{{ route('notifications.index') }}" class="icon-btn position-relative text-decoration-none">
            <i class="bi bi-bell-fill"></i>
            @if($unreadCount > 0)
                <span class="badge rounded-pill text-bg-danger notification-count">{{ $unreadCount }}</span>
            @endif
        </a>
        @endif

<!-- Profile Dropdown -->
        @php
            $navAvatar = 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name ?? 'User') . '&background=2563EB&color=fff';
            if (Auth::user()?->student?->photo) {
                $navAvatar = asset('storage/' . Auth::user()->student->photo);
            }
        @endphp
        <div class="dropdown">
            <button class="profile-dropdown" data-bs-toggle="dropdown">
                <img src="{{ $navAvatar }}" class="profile-image" style="object-fit:cover;">
                <div class="profile-info">
                    <strong>{{ Auth::user()->name ?? 'User' }}</strong>
                    <small>{{ Auth::user()?->isTeacher() ? 'Guru' : (Auth::user()?->isAdmin() ? 'Admin' : 'Student') }}</small>
                </div>
                <i class="bi bi-chevron-down"></i>
            </button>

            <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4">
                @if(Auth::user()?->isStudent())
                <li>
                    <a class="dropdown-item" href="{{ route('profile') }}">
                        <i class="bi bi-person me-2"></i>{{ __t('my_profile') }}
                    </a>
                </li>
                <li>
                    @php $portfolioUsername = Auth::user()->name ?? 'username'; @endphp
                    <a class="dropdown-item" href="{{ route('portfolio.show', $portfolioUsername) }}">
                        <i class="bi bi-folder me-2"></i>Portfolio
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('settings.index') }}">
                        <i class="bi bi-gear me-2"></i>Settings
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('notifications.index') }}">
                        <i class="bi bi-bell me-2"></i>Notifications
                    </a>
                </li>
                @endif
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="dropdown-item text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>

    </div>

</nav>

