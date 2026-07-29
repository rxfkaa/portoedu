@extends('layouts.app')

@section('title','Profile')

@section('content')

<div class="container-fluid">

<div class="profile-header">

    <div class="profile-left">

        <img
        src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Rafka') }}&background=2563EB&color=fff"
        class="profile-avatar">

        <div>

            <h2>

                {{ Auth::user()->name ?? 'Rafka Aleandra Putra' }}

            </h2>

            <p>

                XI RPL • SMKN 4 Bandung

            </p>

            <span>

                📍 Bandung, Indonesia

            </span>

        </div>

    </div>

    <button class="btn btn-primary rounded-4">

        <i class="bi bi-pencil-fill"></i>

        Edit Profile

    </button>

</div>

<div class="row mt-4">

<div class="col-lg-8">

<div class="glass-card">

<h4 class="fw-bold mb-4">

Informasi Pribadi

</h4>

<div class="row">

<div class="col-md-6 mb-4">

<label>Email</label>

<input
class="form-control"
value="rafka@email.com">

</div>

<div class="col-md-6 mb-4">

<label>No HP</label>

<input
class="form-control"
value="08123456789">

</div>

<div class="col-md-6 mb-4">

<label>Tanggal Lahir</label>

<input
class="form-control"
value="04 Agustus 2009">

</div>

<div class="col-md-6 mb-4">

<label>Kelas</label>

<input
class="form-control"
value="XI RPL">

</div>

<div class="col-12">

<label>Alamat</label>

<textarea
class="form-control"
rows="4">Bandung</textarea>

</div>

</div>

</div>

</div>

<div class="col-lg-4">

<div class="glass-card">

<h5>

Progress Profile

</h5>

<h2>

82%

</h2>

<div class="custom-progress mt-3">

<div
class="custom-progress-bar"
style="width:82%">

</div>

</div>

<p class="mt-3">

Lengkapi data profile agar menjadi 100%.

</p>

</div>

<div class="glass-card mt-4">

<h5>

Statistik

</h5>

<div class="mini-stat">

🏆 Prestasi

<strong>12</strong>

</div>

<div class="mini-stat">

📜 Sertifikat

<strong>8</strong>

</div>

<div class="mini-stat">

💻 Project

<strong>5</strong>

</div>

<div class="mini-stat">

👥 Organisasi

<strong>3</strong>

</div>

</div>

</div>

</div>

</div>

@endsection