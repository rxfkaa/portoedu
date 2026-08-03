@extends('layouts.app')

@section('title', 'Detail Prestasi')

@section('content')
<div class="container-fluid">
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">🏆 Detail Prestasi</h2>
            <p class="text-muted">Informasi lengkap tentang prestasi ini.</p>
        </div>
        <div>
            <a href="{{ route('achievements.edit', $achievement) }}" class="btn btn-warning rounded-4 me-2">
                <i class="bi bi-pencil-square"></i> Edit
            </a>
            <a href="{{ route('achievements.index') }}" class="btn btn-outline-secondary rounded-4">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="glass-card p-4">
                <div class="d-flex align-items-center mb-4">
                    <div class="achievement-icon-large rounded-4 bg-warning-subtle p-4 fs-1 me-4">
                        🏆
                    </div>
                    <div>
                        <h2 class="fw-bold mb-2">{{ $achievement->title }}</h2>
                        <span class="badge bg-{{ $achievement->status === 'verified' ? 'success' : ($achievement->status === 'rejected' ? 'danger' : 'warning') }} fs-6">
                            {{ $achievement->status === 'verified' ? 'Terverifikasi' : ($achievement->status === 'rejected' ? 'Ditolak' : 'Menunggu') }}
                        </span>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="text-muted small">Tingkat</label>
                        <h5 class="fw-bold">{{ $achievement->level }}</h5>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="text-muted small">Kategori</label>
                        <h5 class="fw-bold">{{ $achievement->category ?? '-' }}</h5>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="text-muted small">Penyelenggara</label>
                        <h5 class="fw-bold">{{ $achievement->organizer }}</h5>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="text-muted small">Tanggal</label>
                        <h5 class="fw-bold">{{ $achievement->date?->format('d M Y') ?? $achievement->achievement_date?->format('d M Y') ?? '-' }}</h5>
                    </div>
                </div>
                @if($achievement->description)
                    <h5 class="fw-bold mt-3">Deskripsi</h5>
                    <p class="text-muted">{{ $achievement->description }}</p>
                @endif
            </div>
        </div>
        <div class="col-lg-4">
            <div class="glass-card p-4">
                @if($achievement->image)
                    <img src="{{ asset('storage/'.$achievement->image) }}" class="img-fluid rounded-4 mb-4">
                @else
                    <div class="bg-light rounded-4 p-5 text-center mb-4">
                        <i class="bi bi-image display-1 text-muted"></i>
                        <p class="mt-2 text-muted">Belum ada bukti</p>
                    </div>
                @endif
                <div class="d-grid gap-2">
                    <a href="{{ route('achievements.edit', $achievement) }}" class="btn btn-warning rounded-4">
                        <i class="bi bi-pencil-square me-2"></i>Edit Prestasi
                    </a>
                    <form action="{{ route('achievements.destroy', $achievement) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger rounded-4 w-100" onclick="return confirm('Yakin hapus prestasi ini?')">
                            <i class="bi bi-trash me-2"></i>Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

