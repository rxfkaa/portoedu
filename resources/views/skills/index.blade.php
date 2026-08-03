@extends('layouts.app')

@section('title', 'Skills')

@section('content')
<div class="container-fluid">
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">⚡ Skills Saya</h2>
            <p class="text-muted">Kelola keahlian dan kemampuan yang kamu miliki.</p>
        </div>
        <a href="{{ route('skills.create') }}" class="btn btn-primary rounded-4">
            <i class="bi bi-plus-circle me-1"></i>Tambah Skill
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-4">{{ session('success') }}</div>
    @endif

    <div class="row g-4">
        @forelse($skills as $skill)
            <div class="col-md-4 col-lg-3">
                <div class="glass-card p-4 text-center h-100">
                    <div class="display-5 mb-3">
                        <i class="bi bi-code-slash text-primary"></i>
                    </div>
                    <h5 class="fw-bold">{{ $skill->name }}</h5>
                    @php
                        $levelMap = ['Pemula' => 25, 'Menengah' => 50, 'Mahir' => 75, 'Expert' => 100];
                        $percent = $levelMap[$skill->level] ?? 50;
                    @endphp
                    <div class="progress mt-3" style="height:10px;">
                        <div class="progress-bar bg-primary rounded-pill" style="width:{{ $percent }}%"></div>
                    </div>
                    <span class="badge bg-{{ $skill->level === 'Expert' ? 'success' : ($skill->level === 'Mahir' ? 'primary' : ($skill->level === 'Menengah' ? 'warning' : 'info')) }} mt-2">
                        {{ $skill->level }}
                    </span>
                    <div class="mt-3 d-flex justify-content-center gap-2">
                        <a href="{{ route('skills.edit', $skill) }}" class="btn btn-warning btn-sm rounded-3">Edit</a>
                        <form action="{{ route('skills.destroy', $skill) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm rounded-3" onclick="return confirm('Hapus skill ini?')">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                @include('components.empty-state', [
                    'title' => 'Belum ada skill',
                    'description' => 'Tambahkan skill/keahlian yang kamu kuasai.'
                ])
            </div>
        @endforelse
    </div>

    <div class="mt-4">{{ $skills->links() }}</div>
</div>
@endsection

