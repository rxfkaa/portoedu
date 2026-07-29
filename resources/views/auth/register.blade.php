@extends('layouts.guest')

@section('title', 'Daftar | Digital Student Portfolio')

@section('content')
<div class="auth-shell">
    <section class="auth-panel auth-panel--brand">
        <span class="auth-eyebrow"><i class="bi bi-stars"></i> Digital Student Portfolio</span>
        <h1>Bangun portofolio yang membuatmu bangga.</h1>
        <p>Simpan karya, prestasi, dan pengalamanmu dalam satu tempat yang rapi.</p>
    </section>
    <section class="auth-panel auth-panel--form">
        <div class="auth-form">
            <a href="{{ route('landing') }}" class="text-decoration-none text-muted small"><i class="bi bi-arrow-left"></i> Kembali ke beranda</a>
            <h2 class="mt-4 fw-bold">Buat akun</h2>
            <p class="text-muted">Mulai buat portofolio digitalmu hari ini.</p>
            <form action="{{ route('register.store') }}" method="POST" class="mt-4">
                @csrf
                <div class="mb-3"><label class="form-label">Nama lengkap</label><input name="name" value="{{ old('name') }}" class="form-control form-control-lg" required></div>
                <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" value="{{ old('email') }}" class="form-control form-control-lg" required>@error('email')<small class="text-danger">{{ $message }}</small>@enderror</div>
                <div class="mb-3"><label class="form-label">Password</label><input type="password" name="password" class="form-control form-control-lg" required></div>
                <div class="mb-4"><label class="form-label">Konfirmasi password</label><input type="password" name="password_confirmation" class="form-control form-control-lg" required></div>
                <button class="btn btn-primary btn-lg w-100 rounded-4">Buat Akun <i class="bi bi-arrow-right ms-1"></i></button>
            </form>
            <p class="text-center mt-4 mb-0">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
        </div>
    </section>
</div>
@endsection
