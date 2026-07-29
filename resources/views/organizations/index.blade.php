@extends('layouts.app')
@section('title', 'Organisasi')
@section('content')
<div class="container-fluid"><x-page-header title="Pengalaman Organisasi" subtitle="Catatan kontribusi dan peranmu di setiap kegiatan."><button class="btn btn-primary rounded-4"><i class="bi bi-plus-circle me-1"></i>Tambah Organisasi</button></x-page-header>
<div class="glass-card"><div class="achievement-card"><div class="achievement-icon">🏫</div><div class="achievement-content"><h4>OSIS SMKN 4 Bandung</h4><p>Koordinator Divisi Teknologi dan Informasi</p><small>2025 — Sekarang</small></div><span class="badge bg-success">Aktif</span></div><hr><div class="achievement-card"><div class="achievement-icon">💡</div><div class="achievement-content"><h4>Komunitas Coding Sekolah</h4><p>Mentor Frontend Development</p><small>2024 — 2025</small></div><span class="badge bg-secondary">Selesai</span></div></div></div>
@endsection
