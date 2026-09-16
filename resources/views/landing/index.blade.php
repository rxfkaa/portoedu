@extends('landing.guest')

@section('title', 'PortoEdu | Digital Student Portfolio')

@section('content')

<!-- HERO -->
<section id="home" class="hero-section">

    <div class="container">

        <div class="row align-items-center min-vh-100">

            <div class="col-lg-6">

                <span class="hero-badge">

                    🚀 Welcome to PortoEdu

                </span>

                <h1 class="hero-title mt-4">

    Bangun

    <span
        id="typingText"
        class="text-gradient">

        Portfolio Digital

    </span>

    Terbaikmu.

</h1>
                <p class="hero-description">

                    PortoEdu membantu siswa menyimpan prestasi,
                    project, sertifikat, organisasi, dan seluruh
                    perjalanan belajar dalam satu website modern.

                </p>

                <div class="hero-button mt-4">

                    <a href="{{ route('register') }}"
                        class="btn btn-primary btn-lg rounded-pill px-4">

                        <i class="bi bi-person-plus-fill me-2"></i>

                        Mulai Sekarang

                    </a>

<a href="{{ route('login') }}"
                        class="btn btn-outline-light btn-lg rounded-pill px-4 ms-3">

                        Login

                    </a>

                    <a href="{{ route('students.index') }}"
                        class="btn btn-outline-light btn-lg rounded-pill px-4 ms-3 mt-2 mt-sm-0">

                        <i class="bi bi-people-fill me-2"></i>

                        Direktori Siswa

                    </a>

                </div>

                <div class="hero-counter mt-5">

                    <div>

                        <h3>

                            100+

                        </h3>

                        <small>

                            Student

                        </small>

                    </div>

                    <div>

                        <h3>

                            500+

                        </h3>

                        <small>

                            Achievement

                        </small>

                    </div>

                    <div>

                        <h3>

                            250+

                        </h3>

                        <small>

                            Project

                        </small>

                    </div>

                </div>

            </div>

<div class="col-lg-6 text-center">

                <img
                    src="{{ asset('assets/images/dashboard-preview.png') }}"
                    class="hero-image img-fluid">

            </div>

        </div>

    </div>

</section>

<!-- FEATURES -->

<section class="feature-section py-5">

    <div class="container">

        <div class="text-center mb-5">

            <h2 class="section-title">

                Semua Kebutuhan Portfolio

            </h2>

            <p class="text-muted">

                Kelola seluruh pencapaianmu dalam satu aplikasi.

            </p>

        </div>

        <div class="row g-4">

            <div class="col-lg-3">

                <div class="feature-card">

                    <div class="feature-icon bg-primary">

                        <i class="bi bi-trophy-fill"></i>

                    </div>

                    <h4>

                        Achievement

                    </h4>

                    <p>

                        Simpan seluruh prestasi akademik maupun non akademik.

                    </p>

                </div>

            </div>

            <div class="col-lg-3">

                <div class="feature-card">

                    <div class="feature-icon bg-success">

                        <i class="bi bi-code-slash"></i>

                    </div>

                    <h4>

                        Projects

                    </h4>

                    <p>

                        Tampilkan project website, mobile, maupun desktop.

                    </p>

                </div>

            </div>

            <div class="col-lg-3">

                <div class="feature-card">

                    <div class="feature-icon bg-warning">

                        <i class="bi bi-award-fill"></i>

                    </div>

                    <h4>

                        Certificates

                    </h4>

                    <p>

                        Simpan sertifikat lengkap dengan QR Verification.

                    </p>

                </div>

            </div>

            <div class="col-lg-3">

                <div class="feature-card">

                    <div class="feature-icon bg-danger">

                        <i class="bi bi-patch-check-fill"></i>

                    </div>

                    <h4>

                        Verification

                    </h4>

                    <p>

                        Semua data dapat diverifikasi langsung oleh guru.

                    </p>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- ABOUT -->


<section id="about" class="about-section">

    <div class="container">

        <div class="row align-items-center">

<div class="col-lg-6">

                <img
                    src="{{ asset('assets/images/dashboard-preview.png') }}"
                    class="img-fluid rounded-4 shadow-lg">

            </div>

            <div class="col-lg-6">

                <span class="hero-badge">

                    Tentang PortoEdu

                </span>

                <h2 class="mt-4">

                    Satu Tempat Untuk Seluruh Perjalanan Belajarmu.

                </h2>

                <p class="mt-3 text-muted">

                    PortoEdu dirancang khusus bagi siswa SMK maupun
                    mahasiswa untuk mendokumentasikan seluruh
                    perjalanan belajar mulai dari prestasi,
                    sertifikat, project, organisasi hingga
                    pengalaman PKL.

                </p>

                <ul class="about-list">

                    <li>

                        <i class="bi bi-check-circle-fill text-success"></i>

                        Dashboard Modern

                    </li>

                    <li>

                        <i class="bi bi-check-circle-fill text-success"></i>

                        Responsive Semua Device

                    </li>

                    <li>

                        <i class="bi bi-check-circle-fill text-success"></i>

                        Teacher Verification

                    </li>

                    <li>

                        <i class="bi bi-check-circle-fill text-success"></i>

                        Public Portfolio

                    </li>

                </ul>

            </div>

        </div>

    </div>

</section>

<!-- CTA -->

<section class="cta-section">

    <div class="container text-center">

        <h2>

            Siap Membangun Portfolio Profesional?

        </h2>

        <p>

            Mulai sekarang dan tampilkan semua pencapaianmu.

        </p>

        <a href="{{ route('register') }}"
            class="btn btn-light btn-lg rounded-pill px-5">

            Daftar Gratis

        </a>

    </div>

</section>

@endsection