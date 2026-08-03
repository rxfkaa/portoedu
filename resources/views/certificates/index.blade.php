@extends('layouts.app')

@section('title','Certificates')

@section('content')

<div class="container-fluid">

    <div class="page-header d-flex justify-content-between align-items-center">

        <div>

            <h2 class="fw-bold">

                🏅 Sertifikat Saya

            </h2>

            <p class="text-muted">

                Kelola seluruh sertifikat yang telah diperoleh.

            </p>

        </div>

        <a
            href="{{ route('certificates.create') }}"
            class="btn btn-primary rounded-4">

            <i class="bi bi-plus-circle"></i>

            Tambah Sertifikat

        </a>

    </div>

    @if(session('success'))

        <div class="alert alert-success mt-3">

            {{ session('success') }}

        </div>

    @endif

    <div class="glass-card mt-4">

        <div class="mb-4">

            <input
                class="form-control"
                placeholder="Cari Sertifikat...">

        </div>

        @forelse($certificates as $certificate)

        <div class="achievement-card">

            <div class="achievement-icon bg-success">

                <i class="bi bi-award-fill text-white"></i>

            </div>

            <div class="achievement-content">

                <h4>

                    {{ $certificate->title }}

                </h4>

                <p>

                    {{ $certificate->issuer }}

                </p>

                <small>

                    {{ \Carbon\Carbon::parse($certificate->issued_at)->format('d M Y') }}

                </small>

            </div>

            <div>

                <a
                    href="{{ route('certificates.show',$certificate) }}"
                    class="btn btn-light">

                    Detail

                </a>

                <a
                    href="{{ route('certificates.edit',$certificate) }}"
                    class="btn btn-warning">

                    Edit

                </a>

                <form
                    action="{{ route('certificates.destroy',$certificate) }}"
                    method="POST"
                    class="d-inline">

                    @csrf

                    @method('DELETE')

                    <button
                        onclick="return confirm('Hapus sertifikat?')"
                        class="btn btn-danger">

                        Hapus

                    </button>

                </form>

            </div>

        </div>

        <hr>

        @empty

        <div class="text-center py-5">

            <i class="bi bi-award display-1 text-muted"></i>

            <h4 class="mt-3">

                Belum ada sertifikat

            </h4>

            <p class="text-muted">

                Tambahkan sertifikat pertamamu.

            </p>

        </div>

        @endforelse

        <div class="mt-4">

            {{ $certificates->links() }}

        </div>

    </div>

</div>

@endsection