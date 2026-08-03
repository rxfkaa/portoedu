@extends('layouts.app')

@section('title', 'Tambah Skill')

@section('content')
<div class="container-fluid">
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">⚡ Tambah Skill</h2>
            <p class="text-muted">Tambahkan keahlian baru ke portfolio kamu.</p>
        </div>
        <a href="{{ route('skills.index') }}" class="btn btn-outline-secondary rounded-4">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="glass-card p-4">
        <form action="{{ route('skills.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Nama Skill <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}" placeholder="Contoh: Laravel, UI/UX Design, Public Speaking" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Level <span class="text-danger">*</span></label>
                    <select name="level" class="form-select @error('level') is-invalid @enderror" required>
                        <option value="">Pilih Level</option>
                        <option value="Pemula" {{ old('level')=='Pemula' ? 'selected' : '' }}>Pemula</option>
                        <option value="Menengah" {{ old('level')=='Menengah' ? 'selected' : '' }}>Menengah</option>
                        <option value="Mahir" {{ old('level')=='Mahir' ? 'selected' : '' }}>Mahir</option>
                        <option value="Expert" {{ old('level')=='Expert' ? 'selected' : '' }}>Expert</option>
                    </select>
                    @error('level')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="text-end">
                <a href="{{ route('skills.index') }}" class="btn btn-light rounded-4 px-4 me-2">Batal</a>
                <button class="btn btn-primary rounded-4 px-5">
                    <i class="bi bi-check-circle me-2"></i>Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

