@extends('layouts.app')

@section('title', 'Log Aktivitas')

@section('content')
<div class="container-fluid">
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">📋 Log Aktivitas</h2>
            <p class="text-muted">Pantau seluruh aktivitas siswa, guru, dan admin dalam sistem.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-4">{{ session('success') }}</div>
    @endif

    <div class="glass-card p-4">
        @if($activities->isNotEmpty())
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Role</th>
                            <th>Aktivitas</th>
                            <th>IP Address</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($activities as $activity)
                        <tr>
                            <td>
                                <strong>{{ $activity->user?->name ?? 'User Terhapus' }}</strong><br>
                                <small class="text-muted">{{ $activity->user?->email ?? '-' }}</small>
                            </td>
                            <td>
                                @php $role = $activity->user?->role ?? 'unknown'; @endphp
                                <span class="badge bg-{{ $role === 'admin' ? 'danger' : ($role === 'teacher' ? 'warning' : ($role === 'student' ? 'primary' : 'secondary')) }}">
                                    {{ ucfirst($role === 'unknown' ? 'terhapus' : $role) }}
                                </span>
                            </td>
                            <td>{{ $activity->activity }}</td>
                            <td><small class="text-muted">{{ $activity->ip_address ?? '-' }}</small></td>
                            <td><small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $activities->links() }}</div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-activity display-1 text-muted"></i>
                <h4 class="mt-3">Belum ada aktivitas</h4>
                <p class="text-muted">Aktivitas siswa dan guru akan muncul di sini.</p>
            </div>
        @endif
    </div>
</div>
@endsection
