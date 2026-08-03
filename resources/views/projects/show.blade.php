@extends('layouts.app')

@section('title', 'Detail Project')

@section('content')
<div class="container-fluid">
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">📂 Detail Project</h2>
            <p class="text-muted">Informasi lengkap project.</p>
        </div>
        <a href="{{ route('projects.index') }}" class="btn btn-secondary rounded-4">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="glass-card p-4">
        @if($project->image)
            <img src="{{ asset('storage/'.$project->image) }}" class="project-detail-image mb-4">
        @else
            <img src="https://placehold.co/1200x500?text=Project" class="project-detail-image mb-4">
        @endif

        <div class="row">
            <div class="col-lg-8">
                <h2 class="fw-bold">{{ $project->title }}</h2>
                <span class="badge bg-primary mb-3">{{ $project->category ?? 'Umum' }}</span>
                <p>{{ $project->description }}</p>
            </div>
            <div class="col-lg-4">
                <div class="project-info">
                    <div class="mb-3">
                        <strong>Teknologi</strong>
                        <p>{{ $project->technology ?? '-' }}</p>
                    </div>
                    <div class="mb-3">
                        <strong>Kategori</strong>
                        <p>{{ $project->category ?? '-' }}</p>
                    </div>
                    <div class="mb-3">
                        <strong>Github</strong>
                        <p>
                            @if($project->github)
                                <a href="{{ $project->github }}" target="_blank">{{ $project->github }}</a>
                            @else
                                -
                            @endif
                        </p>
                    </div>
                    <div class="mb-4">
                        <strong>Demo Website</strong>
                        <p>
                            @if($project->demo)
                                <a href="{{ $project->demo }}" target="_blank">{{ $project->demo }}</a>
                            @else
                                -
                            @endif
                        </p>
                    </div>
                    <div class="d-grid gap-2">
                        <a href="{{ route('projects.edit', $project) }}" class="btn btn-warning">
                            <i class="bi bi-pencil-square me-2"></i> Edit Project
                        </a>
                        <form action="{{ route('projects.destroy', $project) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger w-100" onclick="return confirm('Yakin ingin menghapus project ini?')">
                                <i class="bi bi-trash me-2"></i> Hapus Project
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

