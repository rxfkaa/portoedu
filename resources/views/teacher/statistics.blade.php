@extends('layouts.app')
@section('title', 'Statistik Perbandingan')
@section('content')
<div class="container-fluid">

    <div class="page-header mb-4">
        <div>
            <h2 class="fw-bold mb-1"><i class="bi bi-bar-chart-fill me-2"></i>Statistik Perbandingan</h2>
            <p class="text-muted mb-0">Perbandingan prestasi & sertifikat per kelas, plus ranking siswa terbaik.</p>
        </div>
    </div>

    {{-- FILTER --}}
    <div class="glass-card p-4 mb-4">
        <form method="GET" action="{{ route('teacher.statistics') }}" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Jurusan</label>
                <select name="department_id" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua Jurusan</option>
                    @foreach($departments as $d)
                        <option value="{{ $d->id }}" {{ $departmentId == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Kelas (untuk ranking)</label>
                <select name="class_id" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua Kelas</option>
                    @foreach(\App\Models\SchoolClass::with('department')->get() as $c)
                        <option value="{{ $c->id }}" {{ $classId == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                @if($departmentId || $classId)
                    <a href="{{ route('teacher.statistics') }}" class="btn btn-outline-secondary w-100"><i class="bi bi-x-circle me-1"></i>Reset Filter</a>
                @endif
            </div>
        </form>
    </div>

    {{-- CHART PER KELAS --}}
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="glass-card">
                <h5 class="fw-bold mb-4"><i class="bi bi-grid-1x2-fill me-2 text-primary"></i>Data Aktivitas per Kelas</h5>
                <canvas id="classChart" height="110"></canvas>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="glass-card">
                <h5 class="fw-bold mb-4"><i class="bi bi-trophy-fill me-2 text-warning"></i>Ringkasan</h5>
                @php
                    $totAch = $classData->sum('achievement_count');
                    $totCert = $classData->sum('certificate_count');
                @endphp
                <div class="mini-stat"><span>Total Prestasi</span><strong>{{ $totAch }}</strong></div>
                <div class="mini-stat"><span>Total Sertifikat</span><strong>{{ $totCert }}</strong></div>
                <div class="mini-stat"><span>Total Kelas</span><strong>{{ $classData->count() }}</strong></div>
                <div class="mini-stat"><span>Total Siswa Ranking</span><strong>{{ $ranking->count() }}</strong></div>
            </div>
        </div>
    </div>

    {{-- RANKING --}}
    <div class="glass-card">
        <h5 class="fw-bold mb-4"><i class="bi bi-list-ol me-2 text-success"></i>Top 20 Siswa Terbaik</h5>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width:60px;">#</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th class="text-center"><i class="bi bi-trophy"></i></th>
                        <th class="text-center"><i class="bi bi-patch-check"></i></th>
                        <th class="text-center"><i class="bi bi-kanban"></i></th>
                        <th class="text-end">Skor</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ranking as $i => $s)
                        <tr>
                            <td>
                                @if($i === 0)<span class="badge text-bg-warning fs-6">🥇</span>
                                @elseif($i === 1)<span class="badge text-bg-secondary fs-6">🥈</span>
                                @elseif($i === 2)<span class="badge text-bg-danger fs-6">🥉</span>
                                @else<span class="text-muted fw-bold">{{ $i + 1 }}</span>@endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ $s->photo ? asset('storage/'.$s->photo) : 'https://ui-avatars.com/api/?name='.urlencode($s->name).'&background=2563EB&color=fff&size=40' }}" class="rounded-circle" width="36" height="36" style="object-fit:cover;">
                                    <strong>{{ $s->name }}</strong>
                                </div>
                            </td>
                            <td class="text-muted">{{ $s->classRoom?->name ?? '-' }}</td>
                            <td class="text-center"><span class="badge bg-warning-subtle">{{ $s->achievements_count }}</span></td>
                            <td class="text-center"><span class="badge bg-success-subtle">{{ $s->certificates_count }}</span></td>
                            <td class="text-center"><span class="badge bg-primary-subtle">{{ $s->projects_count }}</span></td>
                            <td class="text-end"><strong>{{ $s->achievements_count + $s->certificates_count + $s->projects_count }}</strong></td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">Belum ada data siswa.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@push('scripts')
<script>
    const classLabels = {!! json_encode($classData->pluck('name')->toArray()) !!};
    const classAch = {!! json_encode($classData->pluck('achievement_count')->toArray()) !!};
    const classCert = {!! json_encode($classData->pluck('certificate_count')->toArray()) !!};

    new Chart(document.getElementById('classChart'), {
        type: 'bar',
        data: {
            labels: classLabels,
            datasets: [
                { label: 'Prestasi', data: classAch, backgroundColor: '#f59e0b', borderRadius: 8 },
                { label: 'Sertifikat', data: classCert, backgroundColor: '#2563eb', borderRadius: 8 }
            ]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'top' } },
            scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
        }
    });
</script>
@endpush
@endsection
