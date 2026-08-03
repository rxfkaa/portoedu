<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @stack('styles')
</head>
<body>

<div class="wrapper">
    {{-- Sidebar --}}
    @include('components.sidebar')

    {{-- Main --}}
    <main class="main-content">
        {{-- Navbar --}}
        @include('components.navbar')

        {{-- Alerts --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm border-0 mx-3 mt-3">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm border-0 mx-3 mt-3">
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                {{ session('error') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
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
