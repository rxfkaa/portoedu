@extends('layouts.app')

@section('title', 'Edit Project')

@section('content')
<div class="container-fluid">
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">✏️ Edit Project</h2>
            <p class="text-muted">Perbarui informasi project kamu.</p>
        </div>
        <a href="{{ route('projects.index') }}" class="btn btn-outline-secondary rounded-4">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="glass-card p-4">
        <form action="{{ route('projects.update', $project) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Nama Project <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title', $project->title) }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Kategori</label>
                    <select name="category" class="form-select">
                        <option value="">Pilih</option>
                        <option value="Website" {{ old('category', $project->category)=='Website' ? 'selected' : '' }}>Website</option>
                        <option value="Mobile App" {{ old('category', $project->category)=='Mobile App' ? 'selected' : '' }}>Mobile App</option>
                        <option value="Desktop" {{ old('category', $project->category)=='Desktop' ? 'selected' : '' }}>Desktop</option>
                        <option value="Game" {{ old('category', $project->category)=='Game' ? 'selected' : '' }}>Game</option>
                        <option value="UI/UX" {{ old('category', $project->category)=='UI/UX' ? 'selected' : '' }}>UI/UX</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Teknologi</label>
                    <input type="text" name="technology" class="form-control"
                           value="{{ old('technology', $project->technology) }}" placeholder="Laravel, Bootstrap, MySQL">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Github</label>
                    <input type="url" name="github" class="form-control" value="{{ old('github', $project->github) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Demo Website</label>
                    <input type="url" name="demo" class="form-control" value="{{ old('demo', $project->demo) }}">
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label fw-semibold">Gambar Project</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/*">
                </div>
                <div class="col-12 mb-4">
                    @if($project->image)
                        <img id="preview" src="{{ asset('storage/'.$project->image) }}"
                             class="img-fluid rounded-4 border" style="max-height:350px;">
                    @else
                        <img id="preview" src="https://placehold.co/900x450?text=Preview+Image"
                             class="img-fluid rounded-4 border">
                    @endif
                </div>
                <div class="col-12 mb-4">
                    <label class="form-label fw-semibold">Deskripsi <span class="text-danger">*</span></label>
                    <textarea name="description" rows="6"
                              class="form-control @error('description') is-invalid @enderror"
                              required>{{ old('description', $project->description) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="text-end">
                <a href="{{ route('projects.index') }}" class="btn btn-light rounded-4 px-4 me-2">Batal</a>
                <button class="btn btn-primary rounded-4 px-5">
                    <i class="bi bi-check-circle me-2"></i>Update Project
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('image')?.addEventListener('change', function(e) {
    const [file] = e.target.files;
    if (file) document.getElementById('preview').src = URL.createObjectURL(file);
});
</script>
@endpush
