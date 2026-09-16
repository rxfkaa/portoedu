@extends('layouts.guest')

@section('title', ($user->name ?? 'Portfolio') . ' - Digital Student Portfolio')

@section('content')
<style>
    @php
        $themeColors = [
            'indigo'  => ['#2563eb', '#4f46e5'],
            'emerald' => ['#059669', '#0d9488'],
            'rose'    => ['#e11d48', '#be123c'],
            'amber'   => ['#d97706', '#b45309'],
            'slate'   => ['#334155', '#1e293b'],
        ];
        $theme = $portfolioSetting?->theme ?? 'indigo';
        [$c1, $c2] = $themeColors[$theme] ?? $themeColors['indigo'];
    @endphp
    .public-portfolio {
        --portfolio-primary: {{ $c1 }};
        --portfolio-secondary: {{ $c2 }};
        --portfolio-soft: color-mix(in srgb, {{ $c1 }} 10%, white);
    }
    .public-portfolio .portfolio-hero {
        background: linear-gradient(135deg, var(--portfolio-primary), var(--portfolio-secondary));
        color: white;
        padding: 60px 0;
    }
    .public-portfolio .portfolio-avatar {
        width: 180px;
        height: 180px;
        border-radius: 50%;
        border: 5px solid rgba(255,255,255,0.3);
        object-fit: cover;
    }
    .public-portfolio .portfolio-section {
        padding: 40px 0;
    }
    .public-portfolio .portfolio-section:nth-child(even) {
        background: #f8fafc;
    }
    .public-portfolio .p-item {
        background: #fff;
        border-radius: 20px;
        padding: 22px;
        box-shadow: 0 10px 30px rgba(15,23,42,.06);
        height: 100%;
        transition: .3s;
    }
    .public-portfolio .p-item:hover {
        transform: translateY(-6px);
    }
    .public-portfolio .text-primary { color: var(--portfolio-primary) !important; }
    .public-portfolio .bg-primary, .public-portfolio .btn-primary, .public-portfolio .progress-bar { background-color: var(--portfolio-primary) !important; border-color: var(--portfolio-primary) !important; }
    .public-portfolio .bg-primary-subtle { background-color: var(--portfolio-soft) !important; }
    .public-portfolio .btn-outline-primary { border-color: var(--portfolio-primary); color: var(--portfolio-primary); }
    .public-portfolio .btn-outline-primary:hover { background: var(--portfolio-primary); border-color: var(--portfolio-primary); color: #fff; }
</style>

<div class="public-portfolio">
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
            @if($student?->instagram)
                <a href="{{ $student->instagram }}" target="_blank" class="text-white fs-4" title="Instagram"><i class="bi bi-instagram"></i></a>
            @endif
            @foreach($socialLinks as $sl)
                @php
                    $icons = ['github'=>'bi-github','linkedin'=>'bi-linkedin','instagram'=>'bi-instagram','twitter'=>'bi-twitter','youtube'=>'bi-youtube','website'=>'bi-globe'];
                    $icon = $icons[$sl->platform] ?? 'bi-link-45deg';
                @endphp
                <a href="{{ $sl->url }}" target="_blank" class="text-white fs-4" title="{{ ucfirst($sl->platform) }}"><i class="bi {{ $icon }}"></i></a>
            @endforeach
        </div>
        <div class="mt-4 d-flex justify-content-center gap-2">
            <button class="btn btn-light btn-sm rounded-pill px-3" onclick="navigator.clipboard.writeText(window.location.href);alert('Link portfolio disalin!')">
                <i class="bi bi-share me-1"></i>Share
            </button>
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

{{-- Skills --}}
@if($skills->isNotEmpty())
<div class="portfolio-section">
    <div class="container">
        <h3 class="fw-bold mb-4">⚡ Skills</h3>
        <div class="row g-4">
            @foreach($skills as $skill)
                <div class="col-md-4 col-lg-3">
                    <div class="p-item text-center">
                        <div class="display-6 mb-2">
                            <i class="bi bi-lightning-fill text-primary"></i>
                        </div>
                        <h5 class="fw-bold">{{ $skill->name }}</h5>
                        @php
                            $levelMap = ['Pemula' => 25, 'Menengah' => 50, 'Mahir' => 75, 'Expert' => 100];
                            $percent = $levelMap[$skill->level] ?? 50;
                        @endphp
                        <div class="progress mt-2" style="height:8px;">
                            <div class="progress-bar bg-primary rounded-pill" style="width:{{ $percent }}%"></div>
                        </div>
                        <span class="badge bg-primary-subtle text-primary mt-2">{{ $skill->level }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- Internship / PKL --}}
@if($internships->isNotEmpty())
<div class="portfolio-section">
    <div class="container">
        <h3 class="fw-bold mb-4">💼 Pengalaman PKL / Internship</h3>
        <div class="row g-4">
            @foreach($internships as $internship)
                <div class="col-md-6">
                    <div class="p-item">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <div class="rounded-3 bg-primary-subtle text-primary p-3 fs-3">
                                <i class="bi bi-building"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0">{{ $internship->company }}</h5>
                                <small class="text-muted">{{ $internship->position }}</small>
                            </div>
                        </div>
                        <small class="text-muted">
                            <i class="bi bi-calendar me-1"></i>
                            {{ $internship->started_at?->format('M Y') ?? '-' }}
                            -
                            {{ $internship->ended_at?->format('M Y') ?? 'Sekarang' }}
                        </small>
                        @if($internship->description)
                            <p class="mt-2 mb-0 text-muted">{{ $internship->description }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- Gallery --}}
@if($galleries->isNotEmpty())
<div class="portfolio-section">
    <div class="container">
        <h3 class="fw-bold mb-4">📸 Galeri</h3>
        <div class="row g-4">
            @foreach($galleries as $gallery)
                <div class="col-sm-6 col-lg-4">
                    <div class="p-item p-0 overflow-hidden">
                        <img src="{{ asset('storage/' . $gallery->image) }}" class="img-fluid w-100" style="height:180px;object-fit:cover;" alt="{{ $gallery->title }}">
                        <div class="p-3">
                            <h6 class="fw-bold mb-0">{{ $gallery->title }}</h6>
                            @if($gallery->description)
                                <small class="text-muted">{{ Str::limit($gallery->description, 80) }}</small>
                            @endif
                        </div>
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
</div>
@endsection

