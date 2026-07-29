<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Digital Student Portfolio</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css" rel="stylesheet">

    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

</head>

<body class="landing-page">

@include('landing.hero')

@include('landing.features')

@include('landing.preview')

@include('landing.faq')

@include('landing.cta')

@include('landing.footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>