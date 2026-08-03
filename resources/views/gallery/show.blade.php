@extends('layouts.app')

@section('title', 'Detail Foto')

@section('content')
<div class="container-fluid">
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">📸 Detail Foto</h2>
            <p class="text-muted">Lihat detail dokumentasi kegiatan.</p>
        </div>
        <a href="{{ route('gallery.index') }}" class="btn btn-outline-secondary rounded-4">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="glass-card p-4 text-center">
                <img src="{{ asset('storage/'.$gallery->image) }}" class="img-fluid rounded-4" alt="{{ $gallery->title }}">
            </div>
        </div>
        <div class="col-lg-4">
            <div class="glass-card p-4">
                <h4 class="fw-bold mb-3">{{ $gallery->title }}</h4>
                <p class="text-muted">{{ $gallery->description ?? 'Tidak ada deskripsi.' }}</p>
                <small class="text-muted">
                    <i class="bi bi-calendar me-1"></i>{{ $gallery->created_at->format('d M Y') }}
                </small>
                <hr>
                <div class="d-flex gap-2">
                    <a href="{{ route('gallery.edit', $gallery) }}" class="btn btn-warning rounded-3">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>
                    <form action="{{ route('gallery.destroy', $gallery) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger rounded-3" onclick="return confirm('Hapus foto ini?')">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

