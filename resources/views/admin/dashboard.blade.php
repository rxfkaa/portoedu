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
