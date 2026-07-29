@extends('layouts.app')
@section('title', 'Dashboard Guru')
@section('content')
<div class="container-fluid">
    <div class="page-header mb-4"><div><h2 class="fw-bold mb-1">Selamat datang, {{ Auth::user()->name }}! 👋</h2><p class="text-muted mb-0">Berikut ringkasan aktivitas verifikasi portofolio siswa hari ini.</p></div><a href="{{ route('teacher.verifications') }}" class="btn btn-primary rounded-4 px-4"><i class="bi bi-patch-check me-2"></i>Mulai Verifikasi</a></div>
    <div class="row g-4">
        <div class="col-md-4"><div class="glass-card p-4 h-100"><div class="d-flex justify-content-between align-items-start"><div><p class="text-muted mb-1">Menunggu Verifikasi</p><h2 class="fw-bold mb-0">{{ $pendingAchievements->count() + $pendingCertificates->count() }}</h2></div><div class="rounded-circle bg-warning-subtle text-warning p-3"><i class="bi bi-hourglass-split fs-4"></i></div></div><small class="text-muted">Prestasi dan sertifikat baru</small></div></div>
        <div class="col-md-4"><div class="glass-card p-4 h-100"><div class="d-flex justify-content-between align-items-start"><div><p class="text-muted mb-1">Siswa Terdaftar</p><h2 class="fw-bold mb-0">{{ $totalStudents }}</h2></div><div class="rounded-circle bg-primary-subtle text-primary p-3"><i class="bi bi-people fs-4"></i></div></div><small class="text-muted">Portofolio siswa dalam sistem</small></div></div>
        <div class="col-md-4"><div class="glass-card p-4 h-100"><div class="d-flex justify-content-between align-items-start"><div><p class="text-muted mb-1">Diverifikasi Bulan Ini</p><h2 class="fw-bold mb-0">{{ $verifiedThisMonth }}</h2></div><div class="rounded-circle bg-success-subtle text-success p-3"><i class="bi bi-check2-circle fs-4"></i></div></div><small class="text-muted">Data yang telah Anda sahkan</small></div></div>
    </div>
    <div class="row g-4 mt-1">
        <div class="col-lg-6"><div class="glass-card p-4 h-100"><div class="d-flex justify-content-between mb-3"><div><h5 class="fw-bold mb-1">Prestasi Menunggu Verifikasi</h5><small class="text-muted">Periksa bukti dan validitas data siswa.</small></div><a href="{{ route('teacher.verifications') }}" class="btn btn-light btn-sm">Lihat semua</a></div>
            @forelse($pendingAchievements as $item)<div class="d-flex align-items-center gap-3 py-3 border-top"><div class="rounded-3 bg-warning-subtle text-warning p-2"><i class="bi bi-trophy-fill"></i></div><div class="flex-grow-1"><strong>{{ $item->title }}</strong><div class="small text-muted">{{ $item->student->name ?? $item->student->user->name }} · {{ $item->level }}</div></div><span class="badge text-bg-warning">Menunggu</span></div>@empty <p class="text-muted text-center py-4 mb-0">Tidak ada prestasi yang menunggu.</p>@endforelse
        </div></div>
        <div class="col-lg-6"><div class="glass-card p-4 h-100"><div class="d-flex justify-content-between mb-3"><div><h5 class="fw-bold mb-1">Sertifikat Terbaru</h5><small class="text-muted">Validasi sertifikat yang dikirim siswa.</small></div><a href="{{ route('teacher.verifications') }}" class="btn btn-light btn-sm">Lihat semua</a></div>
            @forelse($pendingCertificates as $item)<div class="d-flex align-items-center gap-3 py-3 border-top"><div class="rounded-3 bg-info-subtle text-info p-2"><i class="bi bi-award-fill"></i></div><div class="flex-grow-1"><strong>{{ $item->title }}</strong><div class="small text-muted">{{ $item->student->name ?? $item->student->user->name }} · {{ $item->issuer }}</div></div><span class="badge text-bg-warning">Menunggu</span></div>@empty <p class="text-muted text-center py-4 mb-0">Tidak ada sertifikat yang menunggu.</p>@endforelse
        </div></div>
    </div>
</div>
@endsection
