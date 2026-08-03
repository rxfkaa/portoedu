@extends('layouts.app')

@section('title','Tambah Sertifikat')

@section('content')

<div class="container-fluid">

    <div class="page-header d-flex justify-content-between align-items-center">

        <div>

            <h2 class="fw-bold">

                ➕ Tambah Sertifikat

            </h2>

            <p class="text-muted">

                Tambahkan sertifikat baru ke portfolio.

            </p>

        </div>

        <a
            href="{{ route('certificates.index') }}"
            class="btn btn-secondary rounded-4">

            <i class="bi bi-arrow-left"></i>

            Kembali

        </a>

    </div>

    <div class="glass-card mt-4">

        <form
            action="{{ route('certificates.store') }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf

            <div class="row">

                <div class="col-lg-6 mb-3">

                    <label class="form-label">

                        Nama Sertifikat

                    </label>

                    <input
                        type="text"
                        name="title"
                        class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title') }}">

                    @error('title')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                    @enderror

                </div>

                <div class="col-lg-6 mb-3">

                    <label class="form-label">

                        Penerbit

                    </label>

                    <input
                        type="text"
                        name="issuer"
                        class="form-control @error('issuer') is-invalid @enderror"
                        value="{{ old('issuer') }}">

                    @error('issuer')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                    @enderror

                </div>

            </div>

            <div class="row">

                <div class="col-lg-6 mb-3">

                    <label class="form-label">

                        Tanggal Terbit

                    </label>

                    <input
                        type="date"
                        name="issued_at"
                        class="form-control @error('issued_at') is-invalid @enderror"
                        value="{{ old('issued_at') }}">

                    @error('issued_at')

                    <div class="invalid-feedback">

                        {{ $message }}

                    </div>

                    @enderror

                </div>

                <div class="col-lg-6 mb-3">

                    <label class="form-label">

                        Nomor Sertifikat

                    </label>

                    <input
                        type="text"
                        name="certificate_number"
                        class="form-control"
                        value="{{ old('certificate_number') }}">

                </div>

            </div>

            <div class="mb-4">

                <label class="form-label">

                    Upload Gambar Sertifikat

                </label>

                <input
                    type="file"
                    name="image"
                    id="image"
                    class="form-control"
                    accept="image/*">

            </div>

            <div class="text-center mb-4">

                <img
                    id="preview"
                    src="https://placehold.co/500x300?text=Preview+Certificate"
                    class="img-fluid rounded shadow"
                    style="max-height:300px;">

            </div>

            <div class="d-flex justify-content-end">

                <button
                    type="submit"
                    class="btn btn-primary px-5">

                    <i class="bi bi-check-circle"></i>

                    Simpan Sertifikat

                </button>

            </div>

        </form>

    </div>

</div>

<script>

document
.getElementById('image')
.addEventListener('change',function(e){

    const reader = new FileReader();

    reader.onload = function(){

        document
        .getElementById('preview')
        .src = reader.result;

    }

    reader.readAsDataURL(e.target.files[0]);

});

</script>

@endsection