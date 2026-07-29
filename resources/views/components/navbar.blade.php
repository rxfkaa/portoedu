<nav class="top-navbar">

    <!-- Kiri -->
    <div class="navbar-left">

        <button class="menu-toggle" type="button" aria-label="Buka menu">

            <i class="bi bi-list"></i>

        </button>

        <div class="search-box">

            <i class="bi bi-search"></i>

            <input
                type="text"
                placeholder="Cari Prestasi, Project, Sertifikat..."
            >

        </div>

    </div>

    <!-- Kanan -->
    <div class="navbar-right">

        <!-- Notification -->
        <div class="notification">

            <button class="icon-btn">

                <i class="bi bi-bell"></i>

                <span class="badge-notif">

                    3

                </span>

            </button>

        </div>

        <!-- Dark Mode -->
        <button
            class="icon-btn"
            id="darkMode">

            <i class="bi bi-moon-stars"></i>

        </button>

        <!-- User -->

        <div class="user-dropdown">

            <img
                src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Rafka') }}&background=2563EB&color=fff"
            >

            <div>

                <strong>

                    {{ Auth::user()->name ?? 'Rafka' }}

                </strong>

                <small>

                    {{ Auth::user()?->isTeacher() ? 'Guru Verifikator' : 'Siswa' }}

                </small>

            </div>

            <i class="bi bi-chevron-down"></i>

        </div>

    </div>

</nav>
