<nav class="top-navbar">

    <!-- LEFT -->
    <div class="navbar-left">
        <button id="toggleSidebar" class="menu-btn">
            <i class="bi bi-list"></i>
        </button>
        <div class="search-box">
            <i class="bi bi-search"></i>
            <input id="globalSearch" type="text" placeholder="Cari prestasi, project, sertifikat...">
        </div>
    </div>

    <!-- RIGHT -->
    <div class="navbar-right">

        <!-- Dark Mode -->
        <button class="icon-btn" id="darkToggle">
            <i class="bi bi-moon-stars-fill"></i>
        </button>

        <!-- Notification -->
        <a href="{{ route('notifications.index') }}" class="icon-btn position-relative text-decoration-none">
            <i class="bi bi-bell-fill"></i>
            <span class="notification-dot"></span>
        </a>

        <!-- Profile Dropdown -->
        <div class="dropdown">
            <button class="profile-dropdown" data-bs-toggle="dropdown">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&background=2563EB&color=fff" class="profile-image">
                <div class="profile-info">
                    <strong>{{ Auth::user()->name ?? 'User' }}</strong>
                    <small>{{ Auth::user()?->isTeacher() ? 'Guru' : (Auth::user()?->isAdmin() ? 'Admin' : 'Student') }}</small>
                </div>
                <i class="bi bi-chevron-down"></i>
            </button>

            <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4">
                <li>
                    <a class="dropdown-item" href="{{ route('profile') }}">
                        <i class="bi bi-person me-2"></i>My Profile
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

