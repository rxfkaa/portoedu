@extends('layouts.app')

@section('title', 'Tambah Foto')

@section('content')
<div class="container-fluid">
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">📸 Tambah Foto</h2>
            <p class="text-muted">Upload dokumentasi kegiatan atau momen berharga.</p>
        </div>
        <a href="{{ route('gallery.index') }}" class="btn btn-outline-secondary rounded-4">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="glass-card p-4">
        <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul Foto <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title') }}" placeholder="Contoh: Lomba Web Technology 2026" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Caption</label>
                        <textarea name="description" class="form-control" rows="4"
                                  placeholder="Ceritakan tentang foto ini...">{{ old('description') }}</textarea>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card border-0 bg-light rounded-4 p-4">
                        <h5 class="fw-bold mb-3">📷 Upload Foto</h5>
                        <div class="upload-box text-center" onclick="document.getElementById('imageInput').click()">
                            <i class="bi bi-cloud-arrow-up-fill display-4 text-primary"></i>
                            <h6 class="mt-2">Klik untuk Upload</h6>
                            <small class="text-muted">PNG, JPG (Max 2MB)</small>
                            <input type="file" name="image" id="imageInput" class="d-none" accept="image/*" required>
                        </div>
                        <img id="preview" class="img-fluid rounded-3 mt-3 d-none">
                    </div>
                </div>
            </div>
            <div class="text-end mt-4">
                <a href="{{ route('gallery.index') }}" class="btn btn-light rounded-4 px-4 me-2">Batal</a>
                <button type="submit" class="btn btn-primary rounded-4 px-5">
                    <i class="bi bi-check-circle-fill me-2"></i>Upload Foto
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

