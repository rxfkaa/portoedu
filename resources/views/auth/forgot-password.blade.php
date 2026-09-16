@extends('layouts.guest')

@section('title', 'Lupa Password | Digital Student Portfolio')

@section('content')
<div class="auth-shell">
    <section class="auth-panel auth-panel--brand">
        <span class="auth-eyebrow"><i class="bi bi-shield-lock"></i> Digital Student Portfolio</span>
        <h1>Lupa password? Tenang, kami bantu.</h1>
        <p>Masukkan email terdaftar dan kami akan buatkan link untuk mengatur ulang password kamu.</p>
    </section>
    <section class="auth-panel auth-panel--form">
        <div class="auth-form">
            <a href="{{ route('login') }}" class="text-decoration-none text-muted small"><i class="bi bi-arrow-left"></i> Kembali ke login</a>
            <h2 class="mt-4 fw-bold">Atur Ulang Password</h2>
            <p class="text-muted">Kami akan mengirimkan link reset ke email kamu.</p>

            @if(session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <form action="{{ route('password.email') }}" method="POST" class="mt-4">
                @csrf
                <div class="mb-4">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control form-control-lg" placeholder="Masukkan email terdaftar" required autofocus>
                    @error('email')<small class="text-danger d-block">{{ $message }}</small>@enderror
                </div>
                <button class="btn btn-primary btn-lg w-100 rounded-4">Kirim Link Reset <i class="bi bi-envelope-arrow-up ms-1"></i></button>
            </form>

            <p class="text-center mt-4 mb-0">Sudah ingat password? <a href="{{ route('login') }}">Masuk</a></p>
        </div>
    </section>
</div>
@endsection

