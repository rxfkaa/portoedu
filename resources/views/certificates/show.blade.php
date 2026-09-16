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

                {{-- QR VERIFIKASI --}}
                <div class="text-center mt-4 p-3 rounded-4 border">
                    <p class="fw-bold mb-2"><i class="bi bi-qr-code me-1"></i> QR Verifikasi Keaslian</p>
                    <img
                        src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode(route('verify.certificate', $certificate->id)) }}"
                        class="img-fluid rounded-3"
                        alt="QR Verifikasi Sertifikat"
                        style="width:180px;">
                    <p class="small text-muted mt-2 mb-0">Pindai untuk memverifikasi keaslian sertifikat ini.</p>
                    <a
                        href="{{ route('verify.certificate', $certificate->id) }}"
                        class="btn btn-sm btn-outline-primary mt-2 rounded-pill"
                        target="_blank">
                        <i class="bi bi-patch-check-fill me-1"></i> Buka Halaman Verifikasi
                    </a>
                </div>

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

                    <tr>

                        <th>

                            Status Verifikasi

                        </th>

                        <td>

                            @if($certificate->status === 'verified')
                                <span class="badge bg-success"><i class="bi bi-check-circle-fill me-1"></i>Verified</span>
                            @elseif($certificate->status === 'rejected')
                                <span class="badge bg-danger"><i class="bi bi-x-circle-fill me-1"></i>Ditolak</span>
                            @else
                                <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i>Menunggu</span>
                            @endif

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