@extends('layouts.app')

@section('title', 'Tambah PKL')

@section('content')
<div class="container-fluid">
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">💼 Tambah PKL / Internship</h2>
            <p class="text-muted">Tambahkan pengalaman kerja baru.</p>
        </div>
        <a href="{{ route('internships.index') }}" class="btn btn-outline-secondary rounded-4">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="glass-card p-4">
        <form action="{{ route('internships.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Nama Perusahaan <span class="text-danger">*</span></label>
                    <input type="text" name="company" class="form-control @error('company') is-invalid @enderror"
                           value="{{ old('company') }}" required>
                    @error('company')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Posisi <span class="text-danger">*</span></label>
                    <input type="text" name="position" class="form-control @error('position') is-invalid @enderror"
                           value="{{ old('position') }}" required>
                    @error('position')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Tanggal Mulai <span class="text-danger">*</span></label>
                    <input type="date" name="started_at" class="form-control @error('started_at') is-invalid @enderror"
                           value="{{ old('started_at') }}" required>
                    @error('started_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Tanggal Selesai</label>
                    <input type="date" name="ended_at" class="form-control" value="{{ old('ended_at') }}">
                    <small class="text-muted">Kosongkan jika masih berlangsung</small>
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label fw-semibold">Alamat Perusahaan</label>
                    <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label fw-semibold">Deskripsi</label>
                    <textarea name="description" rows="4" class="form-control">{{ old('description') }}</textarea>
                </div>
            </div>
            <div class="text-end mt-3">
                <a href="{{ route('internships.index') }}" class="btn btn-light rounded-4 px-4 me-2">Batal</a>
                <button class="btn btn-primary rounded-4 px-5">
                    <i class="bi bi-check-circle me-2"></i>Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

