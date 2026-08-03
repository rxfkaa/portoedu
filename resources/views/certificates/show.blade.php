@extends('layouts.app')

@section('title','Detail Sertifikat')

@section('content')

<div class="container-fluid">

    <div class="page-header d-flex justify-content-between align-items-center">

        <div>

            <h2 class="fw-bold">

                📜 Detail Sertifikat

            </h2>

            <p class="text-muted">

                Informasi lengkap sertifikat.

            </p>

        </div>

        <div>

            <a
                href="{{ route('certificates.edit',$certificate) }}"
                class="btn btn-warning">

                <i class="bi bi-pencil-square"></i>

                Edit

            </a>

            <a
                href="{{ route('certificates.index') }}"
                class="btn btn-secondary">

                <i class="bi bi-arrow-left"></i>

                Kembali

            </a>

        </div>

    </div>

    <div class="glass-card mt-4">

        <div class="row">

            <div class="col-lg-5">

                @if($certificate->image)

                    <img
                        src="{{ asset('storage/'.$certificate->image) }}"
                        class="img-fluid rounded shadow">

                @else

                    <img
                        src="https://placehold.co/600x400?text=Certificate"
                        class="img-fluid rounded shadow">

                @endif

            </div>

            <div class="col-lg-7">

                <table class="table table-borderless">

                    <tr>

                        <th width="220">

                            Nama Sertifikat

                        </th>

                        <td>

                            {{ $certificate->title }}

                        </td>

                    </tr>

                    <tr>

                        <th>

                            Penerbit

                        </th>

                        <td>

                            {{ $certificate->issuer }}

                        </td>

                    </tr>

                    <tr>

                        <th>

                            Nomor Sertifikat

                        </th>

                        <td>

                            {{ $certificate->certificate_number ?? '-' }}

                        </td>

                    </tr>

                    <tr>

                        <th>

                            Tanggal Terbit

                        </th>

                        <td>

                            {{ \Carbon\Carbon::parse($certificate->issued_at)->translatedFormat('d F Y') }}

                        </td>

                    </tr>

                    <tr>

                        <th>

                            Dibuat

                        </th>

                        <td>

                            {{ $certificate->created_at->diffForHumans() }}

                        </td>

                    </tr>

                </table>

                <hr>

                <div class="d-flex gap-2">

                    <a
                        href="{{ route('certificates.edit',$certificate) }}"
                        class="btn btn-warning">

                        <i class="bi bi-pencil-square"></i>

                        Edit

                    </a>

                    <form
                        action="{{ route('certificates.destroy',$certificate) }}"
                        method="POST">

                        @csrf
                        @method('DELETE')

                        <button
                            onclick="return confirm('Yakin ingin menghapus sertifikat ini?')"
                            class="btn btn-danger">

                            <i class="bi bi-trash"></i>

                            Hapus

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection