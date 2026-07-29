@extends('layouts.app')

@section('title','Tambah Prestasi')

@section('content')

<div class="container-fluid">

<div class="glass-card">

<h2 class="fw-bold mb-4">

Tambah Prestasi

</h2>

<form>

<div class="mb-3">

<label>Nama Prestasi</label>

<input

class="form-control"

placeholder="Masukkan nama prestasi">

</div>

<div class="mb-3">

<label>Tingkat</label>

<select class="form-select">

<option>Sekolah</option>

<option>Kota</option>

<option>Provinsi</option>

<option>Nasional</option>

<option>Internasional</option>

</select>

</div>

<div class="mb-3">

<label>Tahun</label>

<input

type="number"

class="form-control"

placeholder="2026">

</div>

<div class="mb-3">

<label>Sertifikat</label>

<input

type="file"

class="form-control">

</div>

<button class="btn btn-primary rounded-4">

Simpan Prestasi

</button>

</form>

</div>

</div>

@endsection