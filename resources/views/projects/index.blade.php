@extends('layouts.app')
@section('title', 'Project')
@section('content')
<div class="container-fluid"><x-page-header title="Project Saya" subtitle="Kumpulan karya terbaik yang pernah dibuat."><a href="#" class="btn btn-primary rounded-4"><i class="bi bi-plus-circle me-1"></i>Tambah Project</a></x-page-header>
<div class="row g-4">
@foreach ([['Sistem Kasir UMKM','Laravel · MySQL','bi-cart-check-fill','bg-primary'],['UI Aplikasi Edukasi','Figma · UI/UX','bi-palette-fill','bg-warning'],['Website Portfolio','HTML · CSS · JavaScript','bi-window-stack','bg-success']] as [$title,$tech,$icon,$color])
<div class="col-md-6 col-xl-4"><article class="certificate-card"><div class="p-4 text-white {{ $color }}"><i class="bi {{ $icon }} display-5"></i><span class="float-end badge text-bg-light">2026</span></div><div class="certificate-body"><h5>{{ $title }}</h5><p>{{ $tech }}</p><div class="d-flex gap-2"><a href="#" class="btn btn-sm btn-outline-primary">Preview</a><a href="#" class="btn btn-sm btn-light">Detail</a></div></div></article></div>
@endforeach
</div></div>
@endsection
