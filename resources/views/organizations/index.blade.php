@extends('layouts.app')

@section('title','Organisasi')

@section('content')
<div class="container-fluid">
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">👥 Organisasi Saya</h2>
            <p class="text-muted">Kelola pengalaman organisasi yang pernah diikuti.</p>
        </div>
        <a href="{{ route('organizations.create') }}" class="btn btn-primary rounded-4">
            <i class="bi bi-plus-circle"></i> Tambah Organisasi
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-4">{{ session('success') }}</div>
    @endif

    <div class="row g-4">
        @forelse($organizations as $organization)
            <div class="col-lg-6">
                <div class="glass-card p-4 h-100">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-4 bg-primary-subtle text-primary p-3 fs-2">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">{{ $organization->organization_name ?? $organization->name }}</h5>
                            <p class="text-muted mb-0">{{ $organization->position }}</p>
                        </div>
                    </div>
                    <p class="small mb-2">
                        <i class="bi bi-calendar me-1"></i>
                        {{ $organization->start_date?->format('M Y') ?? $organization->started_at?->format('M Y') ?? '-' }}
                        -
                        {{ $organization->end_date?->format('M Y') ?? $organization->ended_at?->format('M Y') ?? 'Sekarang' }}
                    </p>
                    @if($organization->description)
                        <p class="small text-muted">{{ Str::limit($organization->description, 100) }}</p>
                    @endif
                    <div class="d-flex gap-2 mt-3">
                        <a href="{{ route('organizations.show', $organization) }}" class="btn btn-outline-primary btn-sm rounded-3">Detail</a>
                        <a href="{{ route('organizations.edit', $organization) }}" class="btn btn-warning btn-sm rounded-3">Edit</a>
                        <form action="{{ route('organizations.destroy', $organization) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm rounded-3" onclick="return confirm('Hapus organisasi ini?')">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                @include('components.empty-state', [
                    'title' => 'Belum ada organisasi',
                    'description' => 'Tambahkan pengalaman organisasi pertamamu.'
                ])
            </div>
        @endforelse
    </div>

    <div class="mt-4">{{ $organizations->links() }}</div>
</div>
@endsection
