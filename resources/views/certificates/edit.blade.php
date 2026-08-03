@extends('layouts.app')

@section('title','Edit Sertifikat')

@section('content')

<div class="container-fluid">

    <div class="page-header d-flex justify-content-between align-items-center">

        <div>

            <h2 class="fw-bold">

                ✏️ Edit Sertifikat

            </h2>

            <p class="text-muted">

                Perbarui informasi sertifikat.

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
            action="{{ route('certificates.update',$certificate) }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="row">

                <div class="col-lg-6 mb-3">

                    <label class="form-label">

                        Nama Sertifikat

                    </label>

                    <input
                        type="text"
                        name="title"
                        class="form-control"
                        value="{{ old('title',$certificate->title) }}">

                </div>

                <div class="col-lg-6 mb-3">

                    <label class="form-label">

                        Penerbit

                    </label>

                    <input
                        type="text"
                        name="issuer"
                        class="form-control"
                        value="{{ old('issuer',$certificate->issuer) }}">

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
                        class="form-control"
                        value="{{ old('issued_at',$certificate->issued_at) }}">

                </div>

                <div class="col-lg-6 mb-3">

                    <label class="form-label">

                        Nomor Sertifikat

                    </label>

                    <input
                        type="text"
                        name="certificate_number"
                        class="form-control"
                        value="{{ old('certificate_number',$certificate->certificate_number) }}">

                </div>

            </div>

            <div class="mb-3">

                <label class="form-label">

                    Ganti Gambar Sertifikat

                </label>

                <input
                    type="file"
                    name="image"
                    id="image"
                    class="form-control"
                    accept="image/*">

            </div>

            <div class="text-center mb-4">

                @if($certificate->image)

                    <img
                        id="preview"
                        src="{{ asset('storage/'.$certificate->image) }}"
                        class="img-fluid rounded shadow"
                        style="max-height:300px;">

                @else

                    <img
                        id="preview"
                        src="https://placehold.co/500x300?text=Certificate"
                        class="img-fluid rounded shadow"
                        style="max-height:300px;">

                @endif

            </div>

            <div class="d-flex justify-content-end">

                <button
                    class="btn btn-warning px-5">

                    <i class="bi bi-save"></i>

                    Update Sertifikat

                </button>

            </div>

        </form>

    </div>

</div>

<script>

document.getElementById('image').onchange=function(e){

    const reader=new FileReader();

    reader.onload=function(){

        document.getElementById('preview').src=reader.result;

    }

    if(e.target.files[0]){

        reader.readAsDataURL(e.target.files[0]);

    }

}

</script>

@endsection