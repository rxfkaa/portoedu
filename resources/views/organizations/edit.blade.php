@extends('layouts.app')

@section('title', 'Edit Organisasi')

@section('content')
<div class="container-fluid">
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">✏️ Edit Organisasi</h2>
            <p class="text-muted">Perbarui data pengalaman organisasi.</p>
        </div>
        <a href="{{ route('organizations.index') }}" class="btn btn-outline-secondary rounded-4">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="glass-card p-4">
        <form action="{{ route('organizations.update', $organization) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Nama Organisasi <span class="text-danger">*</span></label>
                    <input type="text" name="organization_name" class="form-control @error('organization_name') is-invalid @enderror"
                           value="{{ old('organization_name', $organization->organization_name) }}" required>
                    @error('organization_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Jabatan <span class="text-danger">*</span></label>
                    <input type="text" name="position" class="form-control @error('position') is-invalid @enderror"
                           value="{{ old('position', $organization->position) }}" required>
                    @error('position')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Tanggal Mulai <span class="text-danger">*</span></label>
                    <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror"
                           value="{{ old('start_date', $organization->start_date?->format('Y-m-d') ?? $organization->started_at?->format('Y-m-d')) }}" required>
                    @error('start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Tanggal Selesai</label>
                    <input type="date" name="end_date" class="form-control"
                           value="{{ old('end_date', $organization->end_date?->format('Y-m-d') ?? $organization->ended_at?->format('Y-m-d')) }}">
                    <small class="text-muted">Kosongkan jika masih aktif</small>
                </div>
                <div class="col-12 mb-4">
                    <label class="form-label fw-semibold">Deskripsi</label>
                    <textarea name="description" rows="4" class="form-control">{{ old('description', $organization->description) }}</textarea>
                </div>
            </div>
            <div class="text-end">
                <a href="{{ route('organizations.index') }}" class="btn btn-light rounded-4 px-4 me-2">Batal</a>
                <button class="btn btn-primary rounded-4 px-5">
                    <i class="bi bi-check-circle me-2"></i>Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

