@extends('layouts.app')

@section('title', 'Edit Skill')

@section('content')
<div class="container-fluid">
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">✏️ Edit Skill</h2>
            <p class="text-muted">Perbarui skill kamu.</p>
        </div>
        <a href="{{ route('skills.index') }}" class="btn btn-outline-secondary rounded-4">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="glass-card p-4">
        <form action="{{ route('skills.update', $skill) }}" method="POST">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Nama Skill <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $skill->name) }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Level <span class="text-danger">*</span></label>
                    <select name="level" class="form-select @error('level') is-invalid @enderror" required>
                        <option value="Pemula" {{ old('level', $skill->level) == 'Pemula' ? 'selected' : '' }}>Pemula</option>
                        <option value="Menengah" {{ old('level', $skill->level) == 'Menengah' ? 'selected' : '' }}>Menengah</option>
                        <option value="Mahir" {{ old('level', $skill->level) == 'Mahir' ? 'selected' : '' }}>Mahir</option>
                        <option value="Expert" {{ old('level', $skill->level) == 'Expert' ? 'selected' : '' }}>Expert</option>
                    </select>
                    @error('level')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="text-end mt-3">
                <a href="{{ route('skills.index') }}" class="btn btn-light rounded-4 px-4 me-2">Batal</a>
                <button class="btn btn-warning rounded-4 px-5">
                    <i class="bi bi-save me-2"></i>Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

