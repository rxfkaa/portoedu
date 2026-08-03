@extends('layouts.app')

@section('title','Detail Organisasi')

@section('content')

<div class="container-fluid">

    <div class="page-header d-flex justify-content-between align-items-center">

        <div>

            <h2 class="fw-bold">

                👥 Detail Organisasi

            </h2>

            <p class="text-muted">

                Informasi lengkap organisasi.

            </p>

        </div>

        <div>

            <a
                href="{{ route('organizations.edit',$organization) }}"
                class="btn btn-warning">

                <i class="bi bi-pencil-square"></i>

                Edit

            </a>

            <a
                href="{{ route('organizations.index') }}"
                class="btn btn-secondary">

                <i class="bi bi-arrow-left"></i>

                Kembali

            </a>

        </div>

    </div>

    <div class="glass-card mt-4">

        <div class="row">

            <div class="col-lg-4 text-center">

                <div class="achievement-icon bg-primary mx-auto mb-4"
                    style="width:130px;height:130px;font-size:60px;">

                    <i class="bi bi-people-fill text-white"></i>

                </div>

                <h3>

                    {{ $organization->organization_name }}

                </h3>

                <span class="badge bg-primary">

                    {{ $organization->position }}

                </span>

            </div>

            <div class="col-lg-8">

                <table class="table table-borderless">

                    <tr>

                        <th width="220">

                            Nama Organisasi

                        </th>

                        <td>

                            {{ $organization->organization_name }}

                        </td>

                    </tr>

                    <tr>

                        <th>

                            Jabatan

                        </th>

                        <td>

                            {{ $organization->position }}

                        </td>

                    </tr>

                    <tr>

                        <th>

                            Mulai

                        </th>

                        <td>

                            {{ \Carbon\Carbon::parse($organization->start_date)->translatedFormat('d F Y') }}

                        </td>

                    </tr>

                    <tr>

                        <th>

                            Selesai

                        </th>

                        <td>

                            {{ $organization->end_date
                                ? \Carbon\Carbon::parse($organization->end_date)->translatedFormat('d F Y')
                                : 'Masih Aktif' }}

                        </td>

                    </tr>

                    <tr>

                        <th>

                            Deskripsi

                        </th>

                        <td>

                            {{ $organization->description ?: '-' }}

                        </td>

                    </tr>

                    <tr>

                        <th>

                            Dibuat

                        </th>

                        <td>

                            {{ $organization->created_at->diffForHumans() }}

                        </td>

                    </tr>

                </table>

                <hr>

                <div class="d-flex gap-2">

                    <a
                        href="{{ route('organizations.edit',$organization) }}"
                        class="btn btn-warning">

                        <i class="bi bi-pencil"></i>

                        Edit

                    </a>

                    <form
                        action="{{ route('organizations.destroy',$organization) }}"
                        method="POST">

                        @csrf

                        @method('DELETE')

                        <button
                            onclick="return confirm('Yakin ingin menghapus organisasi ini?')"
                            class="btn btn-danger">

                            <i class="bi bi-trash"></i>

                            Hapus

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection