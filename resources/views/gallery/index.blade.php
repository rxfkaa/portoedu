@extends('layouts.app')

@section('title', 'Galeri')

@section('content')
<div class="container-fluid">
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">📸 Galeri Kegiatan</h2>
            <p class="text-muted">Dokumentasi perjalanan dan pencapaianmu.</p>
        </div>
        <a href="{{ route('gallery.create') }}" class="btn btn-primary rounded-4">
            <i class="bi bi-upload me-1"></i>Tambah Foto
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-4">{{ session('success') }}</div>
    @endif

    <div class="row g-4">
        @forelse($galleries as $gallery)
            <div class="col-sm-6 col-lg-4">
                <div class="certificate-card h-100">
                    <img src="{{ asset('storage/'.$gallery->image) }}"
                         class="certificate-image" alt="{{ $gallery->title }}"
                         style="height:240px;object-fit:cover;width:100%;">
                    <div class="certificate-body">
                        <h5 class="fw-bold">{{ $gallery->title }}</h5>
                        @if($gallery->description)
                            <p class="text-muted small">{{ Str::limit($gallery->description, 100) }}</p>
                        @endif
                        <small class="text-muted">{{ $gallery->created_at->format('d M Y') }}</small>
                        <div class="mt-3 d-flex gap-2">
                            <a href="{{ route('gallery.edit', $gallery) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('gallery.destroy', $gallery) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus foto ini?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="bi bi-images display-1 text-muted"></i>
                    <h4 class="mt-3">Belum ada foto</h4>
                    <p class="text-muted">Upload foto kegiatan pertamamu!</p>
                    <a href="{{ route('gallery.create') }}" class="btn btn-primary rounded-4 mt-2">
                        <i class="bi bi-upload me-1"></i>Upload Foto
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-4">{{ $galleries->links() }}</div>
</div>
@endsection

