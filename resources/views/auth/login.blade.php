<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login | Digital Student Portfolio</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" rel="stylesheet">

    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

</head>

<body class="login-page">

<div class="login-container">

    <!-- Kiri -->
    <div class="login-left">

        <div>

            <span class="badge bg-primary rounded-pill px-3 py-2">

                Digital Student Portfolio

            </span>

            <h1 class="mt-4">

                Selamat Datang 👋

            </h1>

            <p>

                Kelola seluruh prestasi, sertifikat, project dan organisasi dalam satu dashboard modern.

            </p>

        </div>

    </div>

    <!-- Kanan -->

    <div class="login-right">

        <div class="login-card">

            <h2 class="fw-bold mb-4">

                Login

            </h2>

            <form action="{{ route('login.store') }}" method="POST">

                @csrf

                <div class="mb-3">

                    <label>Email</label>

                    <input
                        type="email"
                        name="email"
                        class="form-control form-control-lg"
                        placeholder="Masukkan email"
                        value="{{ old('email') }}"
                        required
                        autofocus>

                    @error('email')
                        <div class="text-danger small mt-2">{{ $message }}</div>
                    @enderror

                </div>

                <div class="mb-4">

                    <label>Password</label>

                    <input
                        type="password"
                        name="password"
                        class="form-control form-control-lg"
                        placeholder="Masukkan password"
                        required>

                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Ingat saya</label>
                </div>

                <button
                    class="btn btn-primary w-100 btn-lg rounded-4">

                    Masuk

                </button>

            </form>

            <div class="text-center mt-4">

                <a href="{{ route('landing') }}">

                    ← Kembali ke Landing Page

                </a>

            </div>

        </div>

    </div>

</div>

</body>

</html>
