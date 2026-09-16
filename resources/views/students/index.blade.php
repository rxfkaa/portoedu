@extends('layouts.guest')

@section('title', 'Direktori Siswa')

@section('content')

<style>
    .student-hero {
        background: linear-gradient(135deg, #1d4ed8, #60a5fa);
        color: #fff;
        padding: 70px 0;
        text-align: center;
    }
    .student-hero h1 { font-size: clamp(2rem, 4vw, 3.2rem); font-weight: 800; }
    .student-grid { padding: 60px 0; background: #f8fafc; min-height: 60vh; }
    .student-card {
        background: #fff;
        border-radius: 20px;
        padding: 28px;
        text-align: center;
        box-shadow: 0 12px 35px rgba(15, 23, 42, .08);
        transition: all .3s ease;
        height: 100%;
        display: block;
        color: #334155;
        text-decoration: none;
        border: 1px solid #e2e8f0;
    }
    .student-card:hover { transform: translateY(-8px); box-shadow: 0 22px 50px rgba(37, 99, 235, .18); color: #2563eb; }
    .student-card img { width: 96px; height: 96px; border-radius: 50%; object-fit: cover; margin-bottom: 16px; border: 4px solid #eff6ff; }
    .student-card h5 { font-weight: 700; margin-bottom: 4px; }
    .student-card .nis { color: #94a3b8; font-size: 13px; }
    .student-card .dept { color: #2563eb; font-size: 13px; font-weight: 600; }
    .student-stat { display: flex; justify-content: center; gap: 20px; margin-top: 16px; padding-top: 14px; border-top: 1px solid #eef2f7; font-size: 13px; color: #64748b; }
    .student-stat strong { color: #1e293b; }
</style>

<!-- Hero -->
<section class="student-hero">
    <div class="container">
        <span class="badge bg-white text-primary rounded-pill px-4 py-2 mb-3">🚀 Student Directory</span>
        <h1>Direktori Siswa</h1>
        <p class="mt-3 mb-4 opacity-75">Temukan portofolio digital seluruh siswa SMK.</p>

        <form method="GET" action="{{ route('students.index') }}" class="row justify-content-center g-2">
            <div class="col-md-5">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control py-3" placeholder="Cari nama atau NIS...">
            </div>
            <div class="col-md-3">
                <select name="department" class="form-select py-3">
                    <option value="">Semua Jurusan</option>
                    @foreach($departments as $d)
                        <option value="{{ $d->code }}" {{ request('department') == $d->code ? 'selected' : '' }}>{{ $d->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-light py-3 w-100"><i class="bi bi-search me-1"></i>Cari</button>
            </div>
        </form>
    </div>
</section>

<!-- Grid -->
<section class="student-grid">
    <div class="container">
        @if(request('search') || request('department'))
            <div class="mb-4">
                <a href="{{ route('students.index') }}" class="btn btn-sm btn-outline-primary rounded-pill"><i class="bi bi-x-circle me-1"></i>Reset Filter</a>
            </div>
        @endif

        @if($students->count())
            <div class="row g-4">
                @foreach($students as $student)
                    <div class="col-sm-6 col-lg-4 col-xl-3">
                        <a href="{{ route('portfolio.show', $student->user?->name ?? $student->name) }}" class="student-card">
                            @php $photo = $student->photo ?? 'https://ui-avatars.com/api/?name=' . urlencode($student->name) . '&background=2563EB&color=fff&size=120'; @endphp
                            <img src="{{ $student->photo ? asset('storage/' . $student->photo) : $photo }}" alt="{{ $student->name }}">
                            <h5>{{ $student->name }}</h5>
                            <div class="nis">{{ $student->nis }}</div>
                            <div class="dept mt-1">{{ $student->classRoom?->name ?? 'Belum Ada Kelas' }}</div>
                            <div class="student-stat">
                                <span>🏆 <strong>{{ $student->achievements_count }}</strong></span>
                                <span>💻 <strong>{{ $student->projects_count ?? 0 }}</strong></span>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="mt-5 d-flex justify-content-center">
                {{ $students->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-people display-1 text-muted"></i>
                <h4 class="mt-3">Tidak ada siswa ditemukan</h4>
                <p class="text-muted">Coba gunakan kata kunci lain.</p>
            </div>
        @endif
    </div>
</section>

@endsection
