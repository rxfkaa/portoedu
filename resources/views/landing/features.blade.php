<section id="features" class="py-5">

<div class="container">

<div class="text-center mb-5">

<h2 class="fw-bold">

Fitur Unggulan

</h2>

<p class="text-muted">

Semua kebutuhan portofolio siswa dalam satu tempat.

</p>

</div>

<div class="row g-4">

@php

$features=[

['bi-trophy-fill','Prestasi'],

['bi-patch-check-fill','Sertifikat'],

['bi-kanban-fill','Project'],

['bi-people-fill','Organisasi'],

['bi-images','Gallery'],

['bi-file-earmark-pdf-fill','Export PDF']

];

@endphp

@foreach($features as $item)

<div class="col-lg-4">

<div class="feature-card">

<i class="bi {{ $item[0] }}"></i>

<h5>{{ $item[1] }}</h5>

<p>

Kelola data dengan mudah dan cepat.

</p>

</div>

</div>

@endforeach

</div>

</div>

</section>