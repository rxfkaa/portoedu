@extends('layouts.app')

@section('title','Dashboard')

@section('content')

<div class="container-fluid">

    {{-- HERO --}}

    <div class="dashboard-hero mb-4">

        <div class="row align-items-center">

            <div class="col-lg-8">

                <span class="dashboard-badge">

                    {{ $greeting }}

                </span>

                <h2 class="mt-4 fw-bold">

                    Halo,
                    {{ Auth::user()->name }}

                </h2>

                <p class="mt-3 text-light">

                    Selamat datang kembali di PortoEdu.
                    Semua pencapaian akademikmu dapat
                    dikelola dalam satu dashboard modern.

                </p>

            </div>

            <div class="col-lg-4 text-center">

                <img
                    src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png"
                    class="hero-avatar img-fluid">

            </div>

        </div>

    </div>

    {{-- STATISTIC --}}

    <div class="row g-4">

        <div class="col-lg-3">

            <div class="stats-card">

                <small>Total Prestasi</small>

                <h2>

                    {{ $achievementCount }}

                </h2>

                <i class="bi bi-trophy-fill text-warning"></i>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="stats-card">

                <small>Total Project</small>

                <h2>

                    {{ $projectCount }}

                </h2>

                <i class="bi bi-code-slash text-primary"></i>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="stats-card">

                <small>Sertifikat</small>

                <h2>

                    {{ $certificateCount }}

                </h2>

                <i class="bi bi-award-fill text-success"></i>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="stats-card">

                <small>Organisasi</small>

                <h2>

                    {{ $organizationCount }}

                </h2>

                <i class="bi bi-people-fill text-danger"></i>

            </div>

        </div>

    </div>

{{-- BADGE & LEVEL --}}

    <div class="row mt-4 g-4">

        <div class="col-lg-4">

            <div class="chart-card d-flex align-items-center gap-3">

                <div class="display-4">{{ $currentBadge['icon'] }}</div>

                <div>

                    <small class="text-muted">Level Portfolio</small>

                    <h4 class="fw-bold mb-1">{{ $currentBadge['level'] }}</h4>

                    <div class="progress mt-2" style="height:8px; width:150px;">

                        <div class="progress-bar bg-primary" style="width: {{ $nextProgress }}%"></div>

                    </div>

                    @if($nextBadge)
                        <small class="text-muted">{{ $nextProgress }}% menuju {{ $nextBadge['icon'] }} {{ $nextBadge['level'] }}</small>
                    @else
                        <small class="text-success">Level maksimal tercapai! 🎉</small>
                    @endif

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="chart-card d-flex align-items-center gap-3">

                <div class="display-4">⭐</div>

                <div>

                    <small class="text-muted">Total Poin</small>

                    <h4 class="fw-bold mb-0">{{ number_format($score) }}</h4>

                    <small class="text-muted">Dari prestasi, sertifikat & project</small>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="chart-card d-flex align-items-center gap-3">

                <div class="display-4">🎯</div>

                <div>

                    <small class="text-muted">Kelengkapan Portfolio</small>

                    <h4 class="fw-bold mb-0">{{ number_format($progress) }}%</h4>

                    <div class="progress mt-2" style="height:8px;">

                        <div class="progress-bar bg-success" style="width: {{ $progress }}%"></div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- QUICK MENU --}}

    <div class="row mt-4 g-4">

            <div class="col-lg-3">

            <a
                href="{{ route('achievements.index') }}"
                class="quick-card">

                <i class="bi bi-trophy-fill"></i>

                <h5>

                    Prestasi

                </h5>

                <p>

                    Kelola seluruh prestasi.

                </p>

            </a>

        </div>

        <div class="col-lg-3">

            <a
                href="{{ route('projects.index') }}"
                class="quick-card">

                <i class="bi bi-code-slash"></i>

                <h5>

                    Project

                </h5>

                <p>

                    Kelola semua project.

                </p>

            </a>

        </div>

        <div class="col-lg-3">

            <a
                href="{{ route('certificates.index') }}"
                class="quick-card">

                <i class="bi bi-award-fill"></i>

                <h5>

                    Certificate

                </h5>

                <p>

                    Kelola sertifikat.

                </p>

            </a>

        </div>

        <div class="col-lg-3">

            <a
                href="{{ route('profile') }}"
                class="quick-card">

                <i class="bi bi-person-fill"></i>

                <h5>

                    Profile

                </h5>

                <p>

                    Edit profil.

                </p>

            </a>

        </div>

    </div>

    {{-- CHART & PROGRESS --}}

<div class="row mt-4 g-4">

    <div class="col-lg-8">

        <div class="chart-card">

<div class="d-flex justify-content-between align-items-center mb-4">

                <h5 class="fw-bold">

                    Statistik Prestasi

                </h5>

                <span class="badge bg-primary">

                    {{ date('Y') }}

                </span>

            </div>

            <canvas id="achievementChart" height="110"></canvas>

        </div>

    </div>

    <div class="col-lg-4">

        <div class="chart-card">

            <h5 class="fw-bold mb-4">

                Progress Portfolio

            </h5>

            <h2 class="fw-bold text-primary">

                {{ number_format($progress) }}%

            </h2>

            <p class="text-muted">

                Tingkat kelengkapan portfolio kamu.

            </p>

            <div class="progress mt-4 mb-4" style="height:12px;">

                <div
                    class="progress-bar bg-success"
                    style="width: {{ $progress }}%">

                </div>

            </div>

            <hr>

            <div class="d-flex justify-content-between mt-3">

                <span>

                    Prestasi

                </span>

                <strong>

                    {{ $achievementCount }}

                </strong>

            </div>

            <div class="d-flex justify-content-between mt-2">

                <span>

                    Project

                </span>

                <strong>

                    {{ $projectCount }}

                </strong>

            </div>

            <div class="d-flex justify-content-between mt-2">

                <span>

                    Sertifikat

                </span>

                <strong>

                    {{ $certificateCount }}

                </strong>

            </div>

            <div class="d-flex justify-content-between mt-2">

                <span>

                    Organisasi

                </span>

                <strong>

                    {{ $organizationCount }}

                </strong>

            </div>

        </div>

    </div>

</div>

{{-- RECENT ACTIVITY --}}

<div class="row mt-4">

    <div class="col-lg-12">

        <div class="activity-card">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <h5 class="fw-bold">

                    Aktivitas Terbaru

                </h5>

                <span class="badge bg-success">

                    Live

                </span>

            </div>

            @forelse($recentAchievements as $achievement)

            <div class="activity-item">

                <div class="activity-icon bg-warning">

                    <i class="bi bi-trophy-fill"></i>

                </div>

                <div class="activity-info">

                    <h6>

                        {{ $achievement->title }}

                    </h6>

                    <small>

                        {{ $achievement->created_at->diffForHumans() }}

                    </small>

                </div>

            </div>

            @empty

            <div class="text-center py-5">

                <i class="bi bi-inbox display-5 text-muted"></i>

                <p class="mt-3 text-muted">

                    Belum ada aktivitas.

                </p>

            </div>

            @endforelse

        </div>

    </div>

</div>

{{-- TARGET --}}

<div class="row mt-4 g-4">

    <div class="col-lg-6">

        <div class="chart-card">

            <h5 class="fw-bold mb-4">

                Target Tahun Ini

            </h5>

            <ul class="list-group list-group-flush">

                <li class="list-group-item d-flex justify-content-between">

                    Upload 10 Project

                    <span class="badge bg-primary">

                        {{ $projectCount }}/10

                    </span>

                </li>

                <li class="list-group-item d-flex justify-content-between">

                    Upload 20 Sertifikat

                    <span class="badge bg-success">

                        {{ $certificateCount }}/20

                    </span>

                </li>

                <li class="list-group-item d-flex justify-content-between">

                    Prestasi Baru

                    <span class="badge bg-warning">

                        {{ $achievementCount }}/15

                    </span>

                </li>

            </ul>

        </div>

    </div>

    <div class="col-lg-6">

        <div class="chart-card text-center">

            <i class="bi bi-stars display-1 text-warning"></i>

            <h3 class="mt-4">

                Keep Going 🚀

            </h3>

            <p class="text-muted">

                Terus tambahkan prestasi, project,
                sertifikat, dan organisasi agar
                portfolio kamu semakin lengkap.

            </p>

        </div>

    </div>

</div>

</div>

@endsection

@push('scripts')
<script>
    var monthlyData = [{{ $monthlyDataStr }}];
    var chartCanvas = document.getElementById('achievementChart');
    if (chartCanvas && typeof Chart !== 'undefined') {
        var ctx = chartCanvas.getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Aktivitas',
                    data: monthlyData,
                    fill: true,
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37,99,235,.15)',
                    tension: .4,
                    pointBackgroundColor: '#2563eb'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
            }
        });
    }
</script>
@endpush
