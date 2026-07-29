@extends('layouts.app')

@section('title','Prestasi')

@section('content')

<div class="container-fluid">

<div class="page-header">

    <div>

        <h2 class="fw-bold">

            🏆 Prestasi Saya

        </h2>

        <p class="text-muted">

            Kelola seluruh prestasi yang pernah diraih.

        </p>

    </div>

    <a href="{{ route('achievements.create') }}"
        class="btn btn-primary rounded-4">

        <i class="bi bi-plus-circle"></i>

        Tambah Prestasi

    </a>

</div>

<div class="glass-card mt-4">

<div class="search-filter">

<input

class="form-control"

placeholder="Cari Prestasi...">

</div>

<div class="achievement-list">

<div class="achievement-card">

<div class="achievement-icon">

🥇

</div>

<div class="achievement-content">

<h4>

Juara 1 LKS Web Technology

</h4>

<p>

Provinsi Jawa Barat

</p>

<small>

2026

</small>

</div>

<div>

<span class="badge bg-success">

Verified

</span>

</div>

<div class="achievement-action">

<button class="btn btn-light">

Detail

</button>

<button class="btn btn-warning">

Edit

</button>

<button class="btn btn-danger">

Hapus

</button>

</div>

</div>

<hr>

<div class="achievement-card">

<div class="achievement-icon">

🥈

</div>

<div class="achievement-content">

<h4>

Juara 2 UI Competition

</h4>

<p>

Nasional

</p>

<small>

2025

</small>

</div>

<div>

<span class="badge bg-success">

Verified

</span>

</div>

<div class="achievement-action">

<button class="btn btn-light">

Detail

</button>

<button class="btn btn-warning">

Edit

</button>

<button class="btn btn-danger">

Hapus

</button>

</div>

</div>

</div>

</div>

</div>

@endsection