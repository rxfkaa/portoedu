        @extends('layouts.guest')

@section('title', 'Masuk | Digital Student Portfolio')

@section('content')
<div class="auth-shell">
    <section class="auth-panel auth-panel--brand">
        <span class="auth-eyebrow"><i class="bi bi-stars"></i> Digital Student Portfolio</span>
        <h1>Selamat datang kembali.</h1>
        <p>Kelola seluruh prestasi, sertifikat, project, dan organisasi dalam satu dashboard modern.</p>
    </section>
    <section class="auth-panel auth-panel--form">
        <div class="auth-form">
            <a href="{{ route('landing') }}" class="text-decoration-none text-muted small"><i class="bi bi-arrow-left"></i> Kembali ke beranda</a>
            <h2 class="mt-4 fw-bold">Masuk</h2>
            <p class="text-muted">Masuk untuk melanjutkan ke dashboard kamu.</p>
            <form action="{{ route('login.store') }}" method="POST" class="mt-4">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control form-control-lg" placeholder="Masukkan email" required autofocus>
                    @error('email')<small class="text-danger d-block">{{ $message }}</small>@enderror
                </div>
                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control form-control-lg" placeholder="Masukkan password" autocomplete="current-password" required>
                    @error('password')<small class="text-danger d-block">{{ $message }}</small>@enderror
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Ingat saya</label>
                    </div>
                    <a href="{{ route('password.request') }}" class="small text-primary text-decoration-none">Lupa password?</a>
                </div>
                @if(session('success'))
                    <div class="alert alert-success py-2">{{ session('success') }}</div>
                @endif
                <button class="btn btn-primary btn-lg w-100 rounded-4">Masuk <i class="bi bi-arrow-right ms-1"></i></button>
            </form>
            <p class="text-center mt-4 mb-0">Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>
        </div>
    </section>
</div>
@endsection
