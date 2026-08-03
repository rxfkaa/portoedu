@extends('layouts.app')

@section('title', 'Prestasi')

@section('content')
<div class="container-fluid">
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">🏆 Prestasi Saya</h2>
            <p class="text-muted">Kelola seluruh prestasi yang pernah diraih.</p>
        </div>
        <a href="{{ route('achievements.create') }}" class="btn btn-primary rounded-4">
            <i class="bi bi-plus-circle"></i> Tambah Prestasi
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-4">{{ session('success') }}</div>
    @endif

    <div class="glass-card mt-4 p-4">
        @forelse($achievements as $item)
            <div class="d-flex align-items-center gap-3 py-3 {{ !$loop->first ? 'border-top' : '' }}">
                <div class="achievement-icon rounded-3 p-3 fs-3
                    {{ $item->status === 'verified' ? 'bg-success-subtle' : ($item->status === 'rejected' ? 'bg-danger-subtle' : 'bg-warning-subtle') }}">
                    🏆
                </div>
                <div class="flex-grow-1">
                    <h5 class="fw-bold mb-1">{{ $item->title }}</h5>
                    <p class="text-muted mb-1 small">{{ $item->level }} • {{ $item->organizer }}</p>
                    <small class="text-muted">{{ $item->date?->format('d M Y') ?? '-' }}</small>
                </div>
                <div>
                    <span class="badge bg-{{ $item->status === 'verified' ? 'success' : ($item->status === 'rejected' ? 'danger' : 'warning') }} fs-6">
                        {{ $item->status === 'verified' ? 'Terverifikasi' : ($item->status === 'rejected' ? 'Ditolak' : 'Menunggu') }}
                    </span>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('achievements.show', $item->id) }}" class="btn btn-outline-primary btn-sm rounded-3">Detail</a>
                    <a href="{{ route('achievements.edit', $item->id) }}" class="btn btn-warning btn-sm rounded-3">Edit</a>
                    <form action="{{ route('achievements.destroy', $item->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm rounded-3" onclick="return confirm('Yakin ingin menghapus prestasi ini?')">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            @include('components.empty-state', [
                'title' => 'Belum ada prestasi',
                'description' => 'Klik tombol Tambah Prestasi untuk membuat data pertama.'
            ])
        @endforelse
        <div class="mt-4">{{ $achievements->links() }}</div>
    </div>
</div>
@endsection

