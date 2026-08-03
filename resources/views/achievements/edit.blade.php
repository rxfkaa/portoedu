@extends('layouts.app')

@section('title', 'Edit Prestasi')

@section('content')
<div class="container-fluid">
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">✏️ Edit Prestasi</h2>
            <p class="text-muted">Perbarui data prestasi kamu.</p>
        </div>
        <a href="{{ route('achievements.index') }}" class="btn btn-outline-secondary rounded-4">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="glass-card p-4">
        <form action="{{ route('achievements.update', $achievement) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Prestasi <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title', $achievement->title) }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Tingkat <span class="text-danger">*</span></label>
                            <select name="level" class="form-select @error('level') is-invalid @enderror" required>
                                <option value="Sekolah" {{ old('level',$achievement->level)=='Sekolah' ? 'selected' : '' }}>Sekolah</option>
                                <option value="Kota" {{ old('level',$achievement->level)=='Kota' ? 'selected' : '' }}>Kota</option>
                                <option value="Provinsi" {{ old('level',$achievement->level)=='Provinsi' ? 'selected' : '' }}>Provinsi</option>
                                <option value="Nasional" {{ old('level',$achievement->level)=='Nasional' ? 'selected' : '' }}>Nasional</option>
                                <option value="Internasional" {{ old('level',$achievement->level)=='Internasional' ? 'selected' : '' }}>Internasional</option>
                            </select>
                            @error('level')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Kategori</label>
                            <select name="category" class="form-select">
                                <option value="">Pilih</option>
                                <option value="Akademik" {{ old('category',$achievement->category)=='Akademik' ? 'selected' : '' }}>Akademik</option>
                                <option value="Non-Akademik" {{ old('category',$achievement->category)=='Non-Akademik' ? 'selected' : '' }}>Non-Akademik</option>
                                <option value="Olahraga" {{ old('category',$achievement->category)=='Olahraga' ? 'selected' : '' }}>Olahraga</option>
                                <option value="Seni" {{ old('category',$achievement->category)=='Seni' ? 'selected' : '' }}>Seni</option>
                                <option value="Teknologi" {{ old('category',$achievement->category)=='Teknologi' ? 'selected' : '' }}>Teknologi</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Penyelenggara <span class="text-danger">*</span></label>
                            <input type="text" name="organizer" class="form-control @error('organizer') is-invalid @enderror"
                                   value="{{ old('organizer', $achievement->organizer) }}" required>
                            @error('organizer')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" name="date" class="form-control @error('date') is-invalid @enderror"
                                   value="{{ old('date', $achievement->date?->format('Y-m-d') ?? $achievement->achievement_date?->format('Y-m-d')) }}" required>
                            @error('date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="4">{{ old('description', $achievement->description) }}</textarea>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card border-0 bg-light rounded-4 p-4">
                        <h5 class="fw-bold mb-3">📎 Bukti/Sertifikat</h5>
                        @if($achievement->image)
                            <img src="{{ asset('storage/'.$achievement->image) }}" class="img-fluid rounded-3 mb-3">
                        @endif
                        <div class="upload-box text-center" onclick="document.getElementById('imageInput').click()">
                            <i class="bi bi-cloud-arrow-up-fill display-4 text-primary"></i>
                            <h6 class="mt-2">Ganti Bukti</h6>
                            <small class="text-muted">PNG, JPG (Max 2MB)</small>
                            <input type="file" name="image" id="imageInput" class="d-none" accept="image/*">
                        </div>
                        <img id="preview" class="img-fluid rounded-3 mt-3 d-none">
                    </div>
                </div>
            </div>
            <div class="text-end mt-4">
                <a href="{{ route('achievements.index') }}" class="btn btn-light rounded-4 px-4 me-2">Batal</a>
                <button type="submit" class="btn btn-primary rounded-4 px-5">
                    <i class="bi bi-check-circle-fill me-2"></i>Update Prestasi
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

