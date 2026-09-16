@extends('layouts.guest')

@section('title', 'Verifikasi Sertifikat')

@section('content')

<div class="auth-shell">

    <!-- Panel Branding -->
    <section class="auth-panel auth-panel--brand">
        <span class="auth-eyebrow"><i class="bi bi-patch-check-fill"></i> PortoEdu Verify</span>
        <h1>Verifikasi keaslian sertifikat.</h1>
        <p>Pindai QR Code atau masukkan nomor sertifikat untuk memastikan keaslian dan status verifikasi.</p>
        <div class="mt-4">
            <a href="{{ route('landing') }}" class="btn btn-light rounded-pill px-4">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda
            </a>
        </div>
    </section>

    <!-- Panel Form -->
    <section class="auth-panel auth-panel--form">
        <div class="auth-form">

            @if(session('error'))
                <div class="alert alert-danger rounded-3">{{ session('error') }}</div>
            @endif

            <div class="glass-card p-4 mb-4">
                <h4 class="fw-bold mb-3"><i class="bi bi-qr-code me-2"></i>Cek Nomor Sertifikat</h4>
                <form action="{{ route('verify.lookup') }}" method="GET">
                    <div class="input-group">
                        <input type="text" name="number" class="form-control" placeholder="Masukkan nomor sertifikat" required>
                        <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </form>
            </div>

            <div class="glass-card p-4 text-center">
                @if($isVerified)
                    <div class="display-5 text-success"><i class="bi bi-check-circle-fill"></i></div>
                    <h3 class="fw-bold mt-3 text-success">Sertifikat Valid</h3>
                    <p class="text-muted">Sertifikat ini telah diverifikasi dan sah.</p>
                @else
                    <div class="display-5 text-warning"><i class="bi bi-hourglass-split"></i></div>
                    <h3 class="fw-bold mt-3 text-warning">Menunggu Verifikasi</h3>
                    <p class="text-muted">Sertifikat ini terdaftar namun belum diverifikasi guru.</p>
                @endif

                <hr class="my-4">

                <table class="table table-borderless text-start align-middle mb-0">
                    <tr>
                        <th class="text-muted">Nama Pemilik</th>
                        <td class="fw-semibold">{{ $certificate->student->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted">Nama Sertifikat</th>
                        <td class="fw-semibold">{{ $certificate->title }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted">Penerbit</th>
                        <td>{{ $certificate->issuer }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted">Nomor</th>
                        <td>{{ $certificate->certificate_number ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted">Tanggal Terbit</th>
                        <td>{{ \Carbon\Carbon::parse($certificate->issued_at)->translatedFormat('d F Y') }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted">Diverifikasi Oleh</th>
                        <td>
                            @if($certificate->verifier)
                                {{ $certificate->verifier->name }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="text-muted">Waktu Verifikasi</th>
                        <td>
                            @if($certificate->verified_at)
                                {{ \Carbon\Carbon::parse($certificate->verified_at)->translatedFormat('d F Y H:i') }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>

        </div>
    </section>

</div>

@endsection
