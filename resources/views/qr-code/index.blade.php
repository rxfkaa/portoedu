@extends('layouts.app')

@section('title', 'QR Code Portfolio')

@section('content')
<div class="container-fluid">
    <div class="page-header mb-4">
        <div>
            <h2 class="fw-bold">📱 QR Code Portfolio</h2>
            <p class="text-muted">Bagikan portfolio kamu dengan sekali pindai.</p>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="glass-card text-center p-5">
                <span class="badge text-bg-primary mb-3">Portfolio Publik</span>
                <h3 class="fw-bold">Bagikan profilmu lebih mudah</h3>
                <p class="text-muted">Pindai kode ini untuk membuka halaman portfolio digital.</p>

@php $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=500x500&data=' . urlencode($portfolioUrl); @endphp
                <img class="img-fluid border rounded-4 p-3 my-3" width="250"
                     src="{{ $qrUrl }}"
                     alt="QR Code Portfolio" id="qrImage">

                <div class="input-group mt-3 mb-3">
                    <input class="form-control" value="{{ $portfolioUrl }}" readonly id="portfolioUrlInput">
                    <button class="btn btn-primary" type="button" onclick="copyUrl()">
                        <i class="bi bi-copy"></i> Salin
                    </button>
                </div>

                <div class="d-flex justify-content-center gap-2">
                    <a href="{{ $qrUrl }}" download="qr-portfolio-{{ \Illuminate\Support\Str::slug($user->name ?? 'user') }}.png"
                       class="btn btn-success rounded-4 px-4">
                        <i class="bi bi-download me-2"></i>Download QR
                    </a>
                    <a href="{{ $portfolioUrl }}" target="_blank" class="btn btn-outline-primary rounded-4 px-4">
                        <i class="bi bi-box-arrow-up-right me-2"></i>Buka Portfolio
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function copyUrl() {
    var input = document.getElementById('portfolioUrlInput');
    input.select();
    input.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(input.value).then(function() {
        alert('Link portfolio berhasil disalin!');
    });
}
</script>
@endpush

