@extends('layouts.app')

@section('title', 'Edit Foto')

@section('content')
<div class="container-fluid">
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">✏️ Edit Foto</h2>
            <p class="text-muted">Perbarui informasi foto kegiatan.</p>
        </div>
        <a href="{{ route('gallery.index') }}" class="btn btn-outline-secondary rounded-4">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="glass-card p-4">
        <form action="{{ route('gallery.update', $gallery) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul Foto <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title', $gallery->title) }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Caption</label>
                        <textarea name="description" class="form-control" rows="4">{{ old('description', $gallery->description) }}</textarea>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card border-0 bg-light rounded-4 p-4">
                        <h5 class="fw-bold mb-3">📷 Ganti Foto</h5>
                        <img src="{{ asset('storage/'.$gallery->image) }}" class="img-fluid rounded-3 mb-3">
                        <div class="upload-box text-center" onclick="document.getElementById('imageInput').click()">
                            <i class="bi bi-cloud-arrow-up-fill display-4 text-primary"></i>
                            <h6 class="mt-2">Klik untuk Ganti</h6>
                            <small class="text-muted">PNG, JPG (Max 2MB)</small>
                            <input type="file" name="image" id="imageInput" class="d-none" accept="image/*">
                        </div>
                        <img id="preview" class="img-fluid rounded-3 mt-3 d-none">
                    </div>
                </div>
            </div>
            <div class="text-end mt-4">
                <a href="{{ route('gallery.index') }}" class="btn btn-light rounded-4 px-4 me-2">Batal</a>
                <button type="submit" class="btn btn-warning rounded-4 px-5">
                    <i class="bi bi-save me-2"></i>Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('imageInput')?.addEventListener('change', function(e) {
    const reader = new FileReader();
    reader.onload = function() {
        const preview = document.getElementById('preview');
        preview.src = reader.result;
        preview.classList.remove('d-none');
    }
    if (e.target.files[0]) reader.readAsDataURL(e.target.files[0]);
});
</script>
@endpush

