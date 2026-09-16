@extends('layouts.app')

@section('title', 'Kelola Pengguna | PortoEdu')

@section('content')
<div class="container-fluid">
    <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1"><i class="bi bi-people-fill me-2"></i>Kelola Pengguna</h2>
            <p class="text-muted mb-0">Tinjau pendaftaran baru dan lihat status seluruh akun PortoEdu.</p>
        </div>
        <span class="admin-summary-badge"><i class="bi bi-hourglass-split"></i> {{ $pendingCount }} menunggu persetujuan</span>
    </div>

    @if(session('success'))<div class="alert alert-success rounded-4">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="alert alert-danger rounded-4">{{ session('error') }}</div>@endif

    <div class="glass-card p-4 admin-users-card">
        <form method="GET" class="row g-2 align-items-end mb-4">
            <div class="col-md-5"><label class="form-label small fw-semibold">Cari pengguna</label><input name="search" value="{{ request('search') }}" class="form-control" placeholder="Nama atau email"></div>
            <div class="col-md-3"><label class="form-label small fw-semibold">Status</label><select name="status" class="form-select"><option value="all">Semua status</option><option value="pending" @selected(request('status') === 'pending')>Menunggu</option><option value="active" @selected(request('status') === 'active')>Aktif</option><option value="rejected" @selected(request('status') === 'rejected')>Ditolak</option></select></div>
            <div class="col-md-2"><label class="form-label small fw-semibold">Peran</label><select name="role" class="form-select"><option value="all">Semua peran</option><option value="student" @selected(request('role') === 'student')>Siswa</option><option value="teacher" @selected(request('role') === 'teacher')>Guru</option><option value="admin" @selected(request('role') === 'admin')>Admin</option></select></div>
            <div class="col-md-2 d-flex gap-2"><button class="btn btn-primary flex-grow-1">Filter</button><a href="{{ route('admin.users') }}" class="btn btn-outline-secondary">Reset</a></div>
        </form>
        <div class="table-responsive">
            <table class="table align-middle admin-users-table mb-0">
                <thead><tr><th>Pengguna</th><th>Email</th><th>Peran</th><th>Status</th><th class="text-end">Aksi</th></tr></thead>
                <tbody>
                    @forelse($users as $user)
                    <tr class="admin-user-row {{ $user->status === 'pending' ? 'is-pending' : '' }}">
                        <td><div class="admin-user-name">{{ $user->name }}</div><span class="admin-user-id">Terdaftar {{ $user->created_at?->format('d M Y') }}</span></td>
                        <td><span class="admin-user-email">{{ $user->email }}</span></td>
                        <td>
                            @if($user->status === 'pending')
                                <span class="admin-role-request"><i class="bi bi-person-plus"></i> Meminta {{ $user->requested_role === 'teacher' ? 'Guru' : 'Siswa' }}</span>
                            @else
                                <span class="admin-role-label admin-role-label--{{ $user->role }}">{{ $user->role === 'teacher' ? 'Guru' : ($user->role === 'student' ? 'Siswa' : 'Admin') }}</span>
                            @endif
                        </td>
                        <td>
                            @if($user->status === 'pending')
                                <span class="admin-status admin-status--pending"><i class="bi bi-clock-history"></i> Menunggu</span>
                            @elseif($user->status === 'rejected')
                                <span class="admin-status admin-status--rejected"><i class="bi bi-x-circle"></i> Ditolak</span>
                            @else
                                <span class="admin-status admin-status--active"><i class="bi bi-check-circle"></i> Aktif</span>
                            @endif
                        </td>
                        <td class="text-end"><a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm {{ $user->status === 'pending' ? 'btn-primary' : 'btn-outline-primary' }} rounded-3 px-3">{{ $user->status === 'pending' ? 'Tinjau' : 'Detail' }} <i class="bi bi-arrow-right-short"></i></a></td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted py-5"><i class="bi bi-people fs-2 d-block mb-2"></i>Belum ada pengguna.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="admin-pagination mt-4">{{ $users->links() }}</div>
    </div>
</div>
@endsection
