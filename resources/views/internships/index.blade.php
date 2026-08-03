@extends('layouts.app')

@section('title', 'Pengalaman PKL')

@section('content')
<div class="container-fluid">
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">💼 Pengalaman PKL / Internship</h2>
            <p class="text-muted">Catat semua pengalaman kerja dan PKL.</p>
        </div>
        <a href="{{ route('internships.create') }}" class="btn btn-primary rounded-4">
            <i class="bi bi-plus-circle me-1"></i>Tambah
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-4">{{ session('success') }}</div>
    @endif

    <div class="row g-4">
        @forelse($internships as $internship)
            <div class="col-lg-6">
                <div class="glass-card p-4 h-100">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-4 bg-primary-subtle text-primary p-3 fs-2">
                            <i class="bi bi-building"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">{{ $internship->company }}</h5>
                            <p class="text-muted mb-0">{{ $internship->position }}</p>
                        </div>
                    </div>
                    @if($internship->address)
                        <p class="text-muted small mb-2"><i class="bi bi-geo-alt me-1"></i>{{ $internship->address }}</p>
                    @endif
                    <p class="small mb-2">
                        <i class="bi bi-calendar me-1"></i>
                        {{ $internship->started_at?->format('M Y') }}
                        @if($internship->ended_at)
                            - {{ $internship->ended_at->format('M Y') }}
                        @else
                            - Sekarang
                        @endif
                    </p>
                    @if($internship->description)
                        <p class="small text-muted">{{ Str::limit($internship->description, 120) }}</p>
                    @endif
                    <div class="d-flex gap-2 mt-3">
                        <a href="{{ route('internships.edit', $internship) }}" class="btn btn-warning btn-sm rounded-3">Edit</a>
                        <form action="{{ route('internships.destroy', $internship) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm rounded-3" onclick="return confirm('Hapus data ini?')">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                @include('components.empty-state', [
                    'title' => 'Belum ada pengalaman PKL',
                    'description' => 'Tambahkan pengalaman PKL/internship kamu.'
                ])
            </div>
        @endforelse
    </div>

    <div class="mt-4">{{ $internships->links() }}</div>
</div>
@endsection

