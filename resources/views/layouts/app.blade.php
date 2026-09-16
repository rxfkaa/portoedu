<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PortoEdu - Digital Student Portfolio')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Terapkan preferensi sebelum halaman terlihat agar tidak terjadi
        // kilatan tema terang ketika mode gelap sebelumnya dipilih.
        try {
            if (localStorage.getItem('dsp-theme') === 'dark') {
                document.documentElement.classList.add('dark-mode');
            }
        } catch (error) {}
    </script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @stack('styles')
</head>
<body>

{{-- Loading Screen --}}
<div class="loading-screen" id="loadingScreen">
    <div class="loader"></div>
    <h5>Memuat PortoEdu...</h5>
</div>

<div class="wrapper">
    {{-- Sidebar --}}
    @include('components.sidebar')

    {{-- Main --}}
    <main class="main-content">
        {{-- Navbar --}}
        @include('components.navbar')

        {{-- Alerts --}}
        @if(session('success'))
            <div class="toast-modern" id="successToast">
                <div class="toast-icon success"><i class="bi bi-check-lg"></i></div>
                <div>
                    <strong>Berhasil!</strong>
                    <div class="small text-muted">{{ session('success') }}</div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="toast-modern error" id="errorToast">
                <div class="toast-icon error"><i class="bi bi-exclamation-lg"></i></div>
                <div>
                    <strong>Gagal!</strong>
                    <div class="small text-muted">{{ session('error') }}</div>
                </div>
            </div>
        @endif

        {{-- Content --}}
        <div class="content-wrapper">
            @yield('content')
        </div>

        {{-- Footer --}}
        @includeIf('components.footer')
    </main>
</div>

{{-- Floating Button (Siswa only) --}}
@if(Auth::check() && !Auth::user()?->isTeacher() && !Auth::user()?->isAdmin())
    <a href="{{ route('achievements.create') }}" class="floating-button">
        <i class="bi bi-plus-lg"></i>
    </a>
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
