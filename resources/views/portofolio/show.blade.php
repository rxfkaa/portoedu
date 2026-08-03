@extends('layouts.guest')

@section('title', ($user->name ?? 'Portfolio') . ' - Digital Student Portfolio')

@section('content')
<style>
    .portfolio-hero {
        background: linear-gradient(135deg, #2563eb, #4f46e5);
        color: white;
        padding: 60px 0;
    }
    .portfolio-avatar {
        width: 180px;
        height: 180px;
        border-radius: 50%;
        border: 5px solid rgba(255,255,255,0.3);
        object-fit: cover;
    }
    .portfolio-section {
        padding: 40px 0;
    }
    .portfolio-section:nth-child(even) {
        background: #f8fafc;
    }
    .p-item {
        background: #fff;
        border-radius: 20px;
        padding: 22px;
        box-shadow: 0 10px 30px rgba(15,23,42,.06);
        height: 100%;
        transition: .3s;
    }
    .p-item:hover {
        transform: translateY(-6px);
    }
</style>

<div class="portfolio-hero">
    <div class="container text-center">
        @php
            $avatar = 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'User') . '&background=2563EB&color=fff&size=200';
            if ($student && $student->photo) {
                $avatar = asset('storage/' . $student->photo);
            }
        @endphp
        <img src="{{ $avatar }}" class="portfolio-avatar mb-4" alt="{{ $user->name ?? 'Student' }}">
        <h1 class="fw-bold display-5">{{ $user->name ?? 'Student' }}</h1>
        <p class="lead opacity-90 mb-0">Digital Student Portfolio</p>
        @if($student && $student->classRoom)
            <p class="mb-0 opacity-75 mt-2">
                {{ $student->classRoom->level }} {{ $student->classRoom->name }}
                @if($student->classRoom->department) · {{ $student->classRoom->department->name }} @endif
            </p>
        @endif
        @if($student && $student->bio)
            <p class="mt-3 opacity-80 mx-auto" style="max-width:640px;">{{ $student->bio }}</p>
        @endif
        <div class="mt-3 d-flex justify-content-center gap-3">
            @if($student?->github)
                <a href="{{ $student->github }}" target="_blank" class="text-white fs-4" title="GitHub"><i class="bi bi-github"></i></a>
            @endif
            @if($student?->linkedin)
                <a href="{{ $student->linkedin }}" target="_blank" class="text-white fs-4" title="LinkedIn"><i class="bi bi-linkedin"></i></a>
            @endif
            @if($student?->website)
                <a href="{{ $student->website }}" target="_blank" class="text-white fs-4" title="Website"><i class="bi bi-globe"></i></a>
            @endif
        </div>
    </div>
</div>

{{-- Statistik --}}
<div class="container py-5">
    <div class="row g-4 text-center">
        <div class="col-md-3">
            <div class="stats-card p-4">
                <h2 class="fw-bold text-primary">{{ $achievements->count() }}</h2>
                <p class="text-muted mb-0">Prestasi</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card p-4">
                <h2 class="fw-bold text-success">{{ $projects->count() }}</h2>
                <p class="text-muted mb-0">Project</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card p-4">
                <h2 class="fw-bold text-warning">{{ $certificates->count() }}</h2>
                <p class="text-muted mb-0">Sertifikat</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card p-4">
                <h2 class="fw-bold text-danger">{{ $organizations->count() }}</h2>
                <p class="text-muted mb-0">Organisasi</p>
            </div>
        </div>
    </div>
</div>

{{-- Prestasi --}}
@if($achievements->isNotEmpty())
<div class="portfolio-section">
    <div class="container">
        <h3 class="fw-bold mb-4">🏆 Prestasi</h3>
        <div class="row g-4">
            @foreach($achievements as $item)
                <div class="col-md-6">
                    <div class="p-item">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="fw-bold mb-0">{{ $item->title }}</h5>
                            <span class="badge bg-{{ $item->status === 'verified' ? 'success' : ($item->status === 'rejected' ? 'danger' : 'warning') }}">
                                {{ $item->status === 'verified' ? 'Terverifikasi' : ($item->status === 'rejected' ? 'Ditolak' : 'Menunggu') }}
                            </span>
                        </div>
                        <p class="text-muted small mb-1">
                            {{ $item->level }}
                            @if($item->organizer) · {{ $item->organizer }} @endif
                        </p>
                        @if($item->date)<small class="text-muted">{{ $item->date->format('d M Y') }}</small>@endif
                        @if($item->description)<p class="mt-2 mb-0">{{ $item->description }}</p>@endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- Project --}}
@if($projects->isNotEmpty())
<div class="portfolio-section">
    <div class="container">
        <h3 class="fw-bold mb-4">💻 Project</h3>
        <div class="row g-4">
            @foreach($projects as $project)
                <div class="col-md-6 col-lg-4">
                    <div class="p-item">
                        @if($project->image || $project->thumbnail)
                            <img src="{{ asset('storage/' . ($project->image ?? $project->thumbnail)) }}"
                                 class="img-fluid rounded-3 mb-3" style="height:160px;width:100%;object-fit:cover;">
                        @endif
                        <h5 class="fw-bold">{{ $project->title }}</h5>
                        @if($project->category)
                            <span class="badge bg-light text-dark">{{ $project->category }}</span>
                        @endif
                        <p class="text-muted small mt-2">{{ Str::limit($project->description, 100) }}</p>
                        @if($project->technology)
                            <div class="mb-2">
                                @foreach(explode(',', $project->technology) as $tech)
                                    @if(trim($tech))
                                        <span class="badge bg-primary-subtle text-primary me-1">{{ trim($tech) }}</span>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                        <div class="d-flex gap-2 mt-2">
                            @if($project->github)
                                <a href="{{ $project->github }}" target="_blank" class="btn btn-sm btn-outline-dark"><i class="bi bi-github"></i> Code</a>
                            @endif
                            @if($project->demo)
                                <a href="{{ $project->demo }}" target="_blank" class="btn btn-sm btn-primary"><i class="bi bi-box-arrow-up-right"></i> Demo</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- Sertifikat --}}
@if($certificates->isNotEmpty())
<div class="portfolio-section">
    <div class="container">
        <h3 class="fw-bold mb-4">📜 Sertifikat</h3>
        <div class="row g-4">
            @foreach($certificates as $certificate)
                <div class="col-md-4">
                    <div class="p-item text-center">
                        @if($certificate->image)
                            <img src="{{ asset('storage/' . $certificate->image) }}" class="img-fluid rounded-3 mb-3" style="max-height:140px;">
                        @else
                            <i class="bi bi-award display-3 text-primary mb-3 d-block"></i>
                        @endif
                        <h5 class="fw-bold">{{ $certificate->title }}</h5>
                        <p class="text-muted small mb-1">{{ $certificate->issuer }}</p>
                        @if($certificate->issued_at)
                            <small class="text-muted">{{ $certificate->issued_at->format('d M Y') }}</small>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- Organisasi --}}
@if($organizations->isNotEmpty())
<div class="portfolio-section">
    <div class="container">
        <h3 class="fw-bold mb-4">👥 Organisasi</h3>
        <div class="row g-4">
            @foreach($organizations as $org)
                <div class="col-md-6">
                    <div class="p-item">
                        <h5 class="fw-bold">{{ $org->organization_name ?? $org->name }}</h5>
                        <p class="text-muted">{{ $org->position }}</p>
                        <small class="text-muted">
                            {{ $org->start_date?->format('M Y') ?? $org->started_at?->format('M Y') ?? '-' }}
                            -
                            {{ $org->end_date?->format('M Y') ?? $org->ended_at?->format('M Y') ?? 'Sekarang' }}
                        </small>
                        @if($org->description)<p class="mt-2 mb-0">{{ $org->description }}</p>@endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<div class="text-center py-4 text-muted">
    <small>Portfolio ini dibuat dengan PortoEdu - Digital Student Portfolio</small>
</div>
@endsection

