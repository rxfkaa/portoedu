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

                <img class="img-fluid border rounded-4 p-3 my-3" width="250"
                     src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={{ urlencode($portfolioUrl) }}"
                     alt="QR Code Portfolio">

                <div class="input-group mt-3">
                    <input class="form-control" value="{{ $portfolioUrl }}" readonly id="portfolioUrlInput">
                    <button class="btn btn-primary" type="button" onclick="copyUrl()">
                        <i class="bi bi-copy"></i> Salin
                    </button>
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

