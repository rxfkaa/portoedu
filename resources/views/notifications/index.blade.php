@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<div class="container-fluid">
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">🔔 Notifications</h2>
            <p class="text-muted">Semua aktivitas terbaru portfolio kamu.</p>
        </div>
        @if($unreadCount > 0)
            <form action="{{ route('notifications.readAll') }}" method="POST">
                @csrf
                <button class="btn btn-primary rounded-4">
                    <i class="bi bi-check2-all me-2"></i>Tandai Semua Dibaca
                </button>
            </form>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-4">{{ session('success') }}</div>
    @endif

    <div class="glass-card p-4">
        @forelse($notifications as $notification)
            <div class="notification-item {{ !$notification->is_read ? 'unread' : '' }}">
                <div class="notification-icon bg-primary">
                    <i class="bi bi-bell-fill"></i>
                </div>
                <div class="flex-grow-1">
                    <h6 class="fw-bold mb-1">{{ $notification->title }}</h6>
                    <p class="text-muted mb-1 small">{{ $notification->message }}</p>
                    <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                </div>
                <div>
                    @if(!$notification->is_read)
                        <form action="{{ route('notifications.read', $notification) }}" method="POST">
                            @csrf
                            <button class="btn btn-sm btn-outline-primary rounded-3">Tandai Dibaca</button>
                        </form>
                    @else
                        <span class="badge bg-light text-muted">Sudah dibaca</span>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <i class="bi bi-bell-slash display-1 text-muted"></i>
                <h4 class="mt-3">Belum ada notifikasi</h4>
                <p class="text-muted">Notifikasi akan muncul saat ada aktivitas baru.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-4">{{ $notifications->links() }}</div>
</div>
@endsection

