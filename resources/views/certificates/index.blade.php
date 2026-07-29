@extends('layouts.app')

@section('title','Sertifikat')

@section('content')

<div class="container-fluid">

<div class="page-header">

<div>

<h2 class="fw-bold">

📜 Sertifikat Saya

</h2>

<p class="text-muted">

Kelola seluruh sertifikat yang dimiliki.

</p>

</div>

<button class="btn btn-primary rounded-4">

<i class="bi bi-upload"></i>

Upload Sertifikat

</button>

</div>

<div class="row g-4 mt-2">

@for($i=1;$i<=6;$i++)

<div class="col-lg-4">

<div class="certificate-card">

<img

src="https://placehold.co/700x500?text=Certificate"

class="certificate-image">

<div class="certificate-body">

<h5>

Laravel Certification

</h5>

<p>

Dicoding Indonesia

</p>

<span class="badge bg-success">

Verified

</span>

<div class="certificate-button">

<button class="btn btn-light">

Detail

</button>

<button class="btn btn-primary">

Download

</button>

</div>

</div>

</div>

</div>

@endfor

</div>

</div>

@endsection