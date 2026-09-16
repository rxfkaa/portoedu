@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    <div class="page-header mb-4">
        <div>
            <h2 class="fw-bold">👑 Admin Dashboard</h2>
            <p class="text-muted mb-0">Kelola seluruh data pengguna, kelas, dan jurusan sistem.</p>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="stats-card">
                <div>
                    <small>Total Users</small>
                    <h2>{{ $totalUsers }}</h2>
                </div>
                <i class="bi bi-people-fill text-primary fs-1"></i>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div>
                    <small>Siswa</small>
                    <h2>{{ $totalStudents }}</h2>
                </div>
                <i class="bi bi-person-fill text-success fs-1"></i>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div>
                    <small>Guru</small>
                    <h2>{{ $totalTeachers }}</h2>
                </div>
                <i class="bi bi-person-badge-fill text-warning fs-1"></i>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div>
                    <small>Kelas / Jurusan</small>
                    <h2>{{ $totalClasses }} / {{ $totalDepartments }}</h2>
                </div>
                <i class="bi bi-building-fill text-info fs-1"></i>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <a href="{{ route('admin.classes') }}" class="text-decoration-none">
                <div class="glass-card p-4 text-center h-100">
                    <i class="bi bi-door-open-fill fs-1 text-primary mb-3 d-block"></i>
                    <h5 class="fw-bold">Kelola Kelas</h5>
                    <p class="text-muted mb-0 small">Atur penempatan kelas dan jurusan</p>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('admin.departments') }}" class="text-decoration-none">
                <div class="glass-card p-4 text-center h-100">
                    <i class="bi bi-building-fill fs-1 text-success mb-3 d-block"></i>
                    <h5 class="fw-bold">Kelola Jurusan</h5>
                    <p class="text-muted mb-0 small">Tambah atau edit data jurusan</p>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('admin.users') }}" class="text-decoration-none">
                <div class="glass-card p-4 text-center h-100">
                    <i class="bi bi-people-fill fs-1 text-warning mb-3 d-block"></i>
                    <h5 class="fw-bold">Kelola User</h5>
                    <p class="text-muted mb-0 small">Atur akun pengguna sistem</p>
                </div>
            </a>
        </div>
    </div>

{{-- Statistik Aktivitas (Tracking) --}}
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="stats-card">
                <div>
                    <small>Aktivitas Siswa (7 hari)</small>
                    <h2>{{ $studentActivity }}</h2>
                </div>
                <i class="bi bi-person-fill text-primary fs-1"></i>
            </div>
        </div>
        <div class="col-md-6">
            <div class="stats-card">
                <div>
                    <small>Aktivitas Guru (7 hari)</small>
                    <h2>{{ $teacherActivity }}</h2>
                </div>
                <i class="bi bi-person-badge-fill text-warning fs-1"></i>
            </div>
        </div>
    </div>

    {{-- Aktivitas Terbaru --}}
    <div class="glass-card p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold">🔔 Aktivitas Terbaru</h5>
            <a href="{{ route('admin.activities') }}" class="btn btn-primary btn-sm rounded-3">Lihat Semua</a>
        </div>
        @if($recentActivities->isNotEmpty())
            @foreach($recentActivities as $activity)
            <div class="d-flex align-items-center gap-3 py-2 {{ !$loop->first ? 'border-top' : '' }}">
                <div class="rounded-3 p-2 bg-{{ ($activity->user?->role ?? 'student') === 'teacher' ? 'warning' : (($activity->user?->role ?? '') === 'admin' ? 'danger' : 'primary') }}-subtle text-{{ ($activity->user?->role ?? 'student') === 'teacher' ? 'warning' : (($activity->user?->role ?? '') === 'admin' ? 'danger' : 'primary') }}">
                    <i class="bi bi-{{ ($activity->user?->role ?? 'student') === 'teacher' ? 'person-badge' : (($activity->user?->role ?? '') === 'admin' ? 'shield' : 'person') }}-fill"></i>
                </div>
                <div class="flex-grow-1">
                    <strong>{{ $activity->user?->name ?? 'User Terhapus' }}</strong>
                    <p class="text-muted small mb-0">{{ $activity->activity }}</p>
                </div>
                <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
            </div>
            @endforeach
        @else
            <div class="text-center py-4">
                <i class="bi bi-activity display-4 text-muted"></i>
                <p class="text-muted mt-2 mb-0">Belum ada aktivitas tercatat.</p>
            </div>
        @endif
    </div>

    <div class="glass-card p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold">User Terbaru</h5>
            <a href="{{ route('admin.users') }}" class="btn btn-primary btn-sm rounded-3">Kelola User</a>
        </div>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Tanggal Daftar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentUsers as $user)
                    <tr>
                        <td><strong>{{ $user->name }}</strong></td>
                        <td>{{ $user->email }}</td>
                        <td><span class="badge bg-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'teacher' ? 'warning' : 'primary') }}">{{ ucfirst($user->role) }}</span></td>
                        <td>{{ $user->created_at->diffForHumans() }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
