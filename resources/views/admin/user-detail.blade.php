@extends('layouts.app')

@section('title', 'Detail Pendaftar | PortoEdu')

@section('content')
<div class="container-fluid">
    <div class="page-header d-flex align-items-center gap-3 flex-wrap mb-4">
        <a href="{{ route('admin.users') }}" class="btn btn-light rounded-3"><i class="bi bi-arrow-left"></i></a>
        <div><h2 class="fw-bold mb-1">Detail Pengguna</h2><p class="text-muted mb-0">Tinjau data dan proses pengajuan akun.</p></div>
    </div>
    @if(session('error'))<div class="alert alert-danger rounded-4">{{ session('error') }}</div>@endif
    @if(session('success'))<div class="alert alert-success rounded-4">{{ session('success') }}</div>@endif

    <div class="row g-4">
        <div class="col-lg-7"><div class="glass-card p-4 h-100">
            <div class="d-flex align-items-center gap-3 mb-4"><div class="admin-detail-avatar">{{ strtoupper(mb_substr($user->name, 0, 1)) }}</div><div><h4 class="fw-bold mb-1">{{ $user->name }}</h4><p class="text-muted mb-0">{{ $user->email }}</p></div></div>
            <dl class="row admin-detail-list mb-0">
                <dt class="col-sm-5">Tanggal pendaftaran</dt><dd class="col-sm-7">{{ $user->created_at?->translatedFormat('d F Y, H:i') }}</dd>
                <dt class="col-sm-5">Permintaan peran</dt><dd class="col-sm-7">{{ $user->requested_role === 'teacher' ? 'Guru' : ($user->requested_role === 'student' ? 'Siswa' : '-') }}</dd>
                <dt class="col-sm-5">Status akun</dt><dd class="col-sm-7 text-capitalize">{{ $user->status }}</dd>
                @if($user->status === 'rejected')<dt class="col-sm-5">Alasan penolakan</dt><dd class="col-sm-7">{{ $user->rejection_reason }}</dd>@endif
                @if($user->requested_role === 'student' || $user->student)
                    <dt class="col-sm-5">NIS</dt><dd class="col-sm-7">{{ $user->student?->nis ?? $user->registration_nis ?? '-' }}</dd>
                    <dt class="col-sm-5">Kelas</dt><dd class="col-sm-7">@php($class = $user->student?->classRoom ?? $user->registrationClass) {{ $class ? $class->level . ' ' . $class->name . ' — ' . $class->department?->name : '-' }}</dd>
                @endif
                @if($user->requested_role === 'teacher' || $user->teacher)
                    <dt class="col-sm-5">NIP</dt><dd class="col-sm-7">{{ $user->teacher?->nip ?? $user->registration_nip ?? '-' }}</dd>
                    <dt class="col-sm-5">Nomor HP</dt><dd class="col-sm-7">{{ $user->teacher?->phone ?? $user->registration_phone ?? '-' }}</dd>
                @endif
            </dl>
        </div></div>
        <div class="col-lg-5"><div class="glass-card p-4 h-100">
            @if($user->status === 'pending')
                <h5 class="fw-bold mb-2">Proses pendaftaran</h5><p class="text-muted small mb-4">Tentukan peran akhir sebelum menyetujui akun. Profil Siswa atau Guru akan dibuat otomatis.</p>
                <form action="{{ route('admin.users.approve', $user) }}" method="POST" class="mb-4">@csrf
                    <label class="form-label fw-semibold">Tetapkan sebagai</label>
                    <select name="role" class="form-select mb-3" required><option value="student" @selected($user->requested_role === 'student')>Siswa</option><option value="teacher" @selected($user->requested_role === 'teacher')>Guru</option></select>
                    <button class="btn btn-success w-100 rounded-3"><i class="bi bi-check-lg me-1"></i> Terima dan Aktifkan Akun</button>
                </form>
                <hr class="my-4">
                <form action="{{ route('admin.users.reject', $user) }}" method="POST">@csrf
                    <label class="form-label fw-semibold" for="rejection_reason">Alasan penolakan</label>
                    <textarea id="rejection_reason" name="rejection_reason" class="form-control mb-3" rows="3" maxlength="1000" required placeholder="Contoh: Data belum lengkap, silakan daftar kembali dengan informasi yang sesuai."></textarea>
                    <button class="btn btn-outline-danger w-100 rounded-3"><i class="bi bi-x-lg me-1"></i> Tolak Pendaftaran</button>
                </form>
            @else
                <h5 class="fw-bold mb-2">Status akun</h5><p class="text-muted mb-0">Akun ini sudah diproses. Perubahan peran tidak tersedia dari halaman ini untuk menjaga konsistensi profil dan akses.</p>
            @endif
        </div></div>
    </div>
</div>
@endsection
