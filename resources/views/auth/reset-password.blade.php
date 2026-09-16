@extends('layouts.guest')

@section('title', 'Reset Password | Digital Student Portfolio')

@section('content')
<div class="auth-shell">
    <section class="auth-panel auth-panel--brand">
        <span class="auth-eyebrow"><i class="bi bi-shield-check"></i> Digital Student Portfolio</span>
        <h1>Buat password baru.</h1>
        <p>Masukkan email dan password baru untuk mengakses kembali dashboard kamu.</p>
    </section>
    <section class="auth-panel auth-panel--form">
        <div class="auth-form">
            <a href="{{ route('login') }}" class="text-decoration-none text-muted small"><i class="bi bi-arrow-left"></i> Kembali ke login</a>
            <h2 class="mt-4 fw-bold">Reset Password</h2>
            <p class="text-muted">Masukkan password baru minimal 8 karakter.</p>

            <form action="{{ route('password.store') }}" method="POST" class="mt-4">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ $email ?? old('email') }}" class="form-control form-control-lg" required>
                    @error('email')<small class="text-danger d-block">{{ $message }}</small>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="password" class="form-control form-control-lg" required autofocus>
                    @error('password')<small class="text-danger d-block">{{ $message }}</small>@enderror
                </div>
                <div class="mb-4">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control form-control-lg" required>
                </div>
                <button class="btn btn-primary btn-lg w-100 rounded-4">Simpan Password <i class="bi bi-check-circle ms-1"></i></button>
            </form>
        </div>
    </section>
</div>
@endsection

