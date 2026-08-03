<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title','PortoEdu')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/landing.css') }}">

</head>

<body>

<div class="bg-blur blur-1"></div>
<div class="bg-blur blur-2"></div>
<div class="bg-blur blur-3"></div>

<button id="backToTop" class="back-to-top">
    <i class="bi bi-arrow-up"></i>
</button>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top landing-navbar">

    <div class="container">

        <a class="navbar-brand fw-bold fs-3" href="{{ route('landing') }}">
            PortoEdu
        </a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarMenu">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div
            class="collapse navbar-collapse"
            id="navbarMenu">

            <ul class="navbar-nav ms-auto align-items-lg-center">

                <li class="nav-item">
                    <a class="nav-link" href="#home">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#features">Features</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#about">About</a>
                </li>

                <li class="nav-item ms-lg-3">

                    <a
                        href="{{ route('login') }}"
                        class="btn btn-outline-light rounded-pill px-4">

                        Login

                    </a>

                </li>

                <li class="nav-item ms-lg-2">

                    <a
                        href="{{ route('register') }}"
                        class="btn btn-primary rounded-pill px-4">

                        Register

                    </a>

                </li>

            </ul>

        </div>

    </div>

</nav>

@yield('content')

<footer class="footer-section">

    <div class="container">

        <div class="row gy-4">

            <div class="col-lg-5">

                <h2 class="fw-bold mb-3">

                    PortoEdu

                </h2>

                <p>

                    Platform portfolio digital untuk siswa dan mahasiswa.
                    Simpan prestasi, project, sertifikat, organisasi,
                    serta perjalanan belajarmu dalam satu tempat.

                </p>

            </div>

            <div class="col-lg-3">

                <h5 class="mb-3">

                    Navigasi

                </h5>

                <ul class="footer-menu">

                    <li><a href="#home">Home</a></li>

                    <li><a href="#features">Features</a></li>

                    <li><a href="#about">About</a></li>

                </ul>

            </div>

            <div class="col-lg-4">

                <h5 class="mb-3">

                    Social Media

                </h5>

                <div class="social-icons">

                    <a href="#"><i class="bi bi-github"></i></a>

                    <a href="#"><i class="bi bi-instagram"></i></a>

                    <a href="#"><i class="bi bi-linkedin"></i></a>

                    <a href="#"><i class="bi bi-envelope-fill"></i></a>

                </div>

            </div>

        </div>

        <hr class="my-5">

        <div class="text-center">

            © {{ date('Y') }} PortoEdu.
            All Rights Reserved.

        </div>

    </div>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>

<script src="{{ asset('assets/js/landing.js') }}"></script>

</body>

</html>