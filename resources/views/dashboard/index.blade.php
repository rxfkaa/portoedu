@extends('layouts.app')

@section('title','Dashboard')

@section('content')

<div class="container-fluid">

    {{-- HERO --}}
    @include('dashboard.components.hero')

    {{-- STATISTIK --}}
    <div class="row g-4 mt-1">

        @include('components.stat-card',[
            'title'=>'Prestasi',
            'value'=>12,
            'icon'=>'bi bi-trophy-fill',
            'growth'=>'+15% bulan ini',
            'color'=>'bg-blue'
        ])

        @include('components.stat-card',[
            'title'=>'Sertifikat',
            'value'=>8,
            'icon'=>'bi bi-patch-check-fill',
            'growth'=>'+10% bulan ini',
            'color'=>'bg-green'
        ])

        @include('components.stat-card',[
            'title'=>'Project',
            'value'=>5,
            'icon'=>'bi bi-kanban-fill',
            'growth'=>'+8% bulan ini',
            'color'=>'bg-orange'
        ])

        @include('components.stat-card',[
            'title'=>'Organisasi',
            'value'=>3,
            'icon'=>'bi bi-people-fill',
            'growth'=>'+2% bulan ini',
            'color'=>'bg-red'
        ])

    </div>

    {{-- BARIS 2 --}}
    <div class="row mt-4">

        <div class="col-lg-8">

            @include('dashboard.components.chart')

        </div>

        <div class="col-lg-4">

            @include('dashboard.components.progress')

        </div>

    </div>

    {{-- BARIS 3 --}}
    <div class="row mt-4">

        <div class="col-lg-8">

            @include('dashboard.components.activity')

        </div>

        <div class="col-lg-4">

            @include('dashboard.components.top-achievement')

        </div>

    </div>

    {{-- BARIS 4 --}}
    <div class="row mt-4">

        <div class="col-lg-6">

            @include('dashboard.components.quick-action')

        </div>

        <div class="col-lg-6">

            @include('dashboard.components.calendar')

        </div>

    </div>

</div>

@endsection