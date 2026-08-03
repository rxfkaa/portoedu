@extends('layouts.app')

@section('title', 'Statistik')

@section('content')
<div class="container-fluid">
    <div class="page-header mb-4">
        <div>
            <h2 class="fw-bold">📊 Statistik Portfolio</h2>
            <p class="text-muted">Ringkasan progres dan pencapaianmu tahun ini.</p>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="stats-card">
                <div>
                    <small>Prestasi</small>
                    <h2>{{ $achievementCount }}</h2>
                </div>
                <i class="bi bi-trophy-fill text-warning fs-1"></i>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div>
                    <small>Sertifikat</small>
                    <h2>{{ $certificateCount }}</h2>
                </div>
                <i class="bi bi-patch-check-fill text-success fs-1"></i>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div>
                    <small>Project</small>
                    <h2>{{ $projectCount }}</h2>
                </div>
                <i class="bi bi-kanban-fill text-primary fs-1"></i>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <div>
                    <small>Organisasi</small>
                    <h2>{{ $organizationCount }}</h2>
                </div>
                <i class="bi bi-people-fill text-danger fs-1"></i>
            </div>
        </div>
    </div>

    <div class="glass-card p-4">
        <h5 class="fw-bold mb-4">Aktivitas Portfolio per Bulan</h5>
        <canvas id="statisticsChart" height="100"></canvas>
    </div>
</div>
@endsection

@push('scripts')
<script>
new Chart(document.getElementById('statisticsChart'), {
    type: 'bar',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
        datasets: [{
            label: 'Aktivitas',
            data: [{{ $monthlyDataStr }}],
            backgroundColor: '#2563eb',
            borderRadius: 8
        }]
    },
    options: {
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
    }
});
</script>
@endpush

