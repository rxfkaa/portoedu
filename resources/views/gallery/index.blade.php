@extends('layouts.app')
@section('title', 'Galeri')
@section('content')
<div class="container-fluid"><x-page-header title="Galeri Kegiatan" subtitle="Dokumentasi perjalanan dan pencapaianmu."><button class="btn btn-primary rounded-4"><i class="bi bi-upload me-1"></i>Tambah Foto</button></x-page-header>
<div class="row g-4">@foreach (['Lomba Web Technology','Presentasi Project','Kegiatan Organisasi','Workshop UI/UX','Penerimaan Penghargaan','Coding Session'] as $i => $title)<div class="col-sm-6 col-lg-4"><div class="certificate-card"><img src="https://placehold.co/800x520/2563eb/ffffff?text={{ urlencode($title) }}" class="certificate-image" alt="{{ $title }}"><div class="certificate-body"><h5>{{ $title }}</h5><p class="mb-0">Dokumentasi 2026</p></div></div></div>@endforeach</div></div>
@endsection
