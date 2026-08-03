@extends('layouts.app')

@section('title', 'Edit PKL')

@section('content')
<div class="container-fluid">
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">💼 Edit PKL / Internship</h2>
            <p class="text-muted">Perbarui data pengalaman kerja.</p>
        </div>
        <a href="{{ route('internships.index') }}" class="btn btn-outline-secondary rounded-4">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="glass-card p-4">
        <form action="{{ route('internships.update', $internship) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Nama Perusahaan <span class="text-danger">*</span></label>
                    <input type="text" name="company" class="form-control @error('company') is-invalid @enderror"
                           value="{{ old('company', $internship->company) }}" required>
                    @error('company')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Posisi <span class="text-danger">*</span></label>
                    <input type="text" name="position" class="form-control @error('position') is-invalid @enderror"
                           value="{{ old('position', $internship->position) }}" required>
                    @error('position')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Tanggal Mulai <span class="text-danger">*</span></label>
                    <input type="date" name="started_at" class="form-control @error('started_at') is-invalid @enderror"
                           value="{{ old('started_at', optional($internship->started_at)->format('Y-m-d')) }}" required>
                    @error('started_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Tanggal Selesai</label>
                    <input type="date" name="ended_at" class="form-control"
                           value="{{ old('ended_at', optional($internship->ended_at)->format('Y-m-d')) }}">
                    <small class="text-muted">Kosongkan jika masih berlangsung</small>
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label fw-semibold">Alamat Perusahaan</label>
                    <input type="text" name="address" class="form-control" value="{{ old('address', $internship->address) }}">
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label fw-semibold">Deskripsi</label>
                    <textarea name="description" rows="4" class="form-control">{{ old('description', $internship->description) }}</textarea>
                </div>
            </div>
            <div class="text-end">
                <a href="{{ route('internships.index') }}" class="btn btn-light rounded-4 px-4 me-2">Batal</a>
                <button class="btn btn-warning rounded-4 px-5">
                    <i class="bi bi-save me-2"></i>Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

