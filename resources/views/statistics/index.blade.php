@extends('layouts.app')
@section('title', 'Statistik')
@section('content')
<div class="container-fluid"><x-page-header title="Statistik Portfolio" subtitle="Ringkasan progres dan pencapaianmu tahun ini." />
<div class="row g-4 mb-4">@include('components.stat-card',['title'=>'Prestasi','value'=>12,'icon'=>'bi bi-trophy-fill','growth'=>'+15% bulan ini','color'=>'bg-blue'])@include('components.stat-card',['title'=>'Sertifikat','value'=>8,'icon'=>'bi bi-patch-check-fill','growth'=>'+10% bulan ini','color'=>'bg-green'])@include('components.stat-card',['title'=>'Project','value'=>5,'icon'=>'bi bi-kanban-fill','growth'=>'+8% bulan ini','color'=>'bg-orange'])@include('components.stat-card',['title'=>'Organisasi','value'=>3,'icon'=>'bi bi-people-fill','growth'=>'+2% bulan ini','color'=>'bg-red'])</div>
<div class="glass-card"><h5 class="fw-bold">Aktivitas Portfolio per Bulan</h5><canvas id="statisticsChart" height="100"></canvas></div></div>
@push('scripts')<script>new Chart(document.getElementById('statisticsChart'),{type:'bar',data:{labels:['Jan','Feb','Mar','Apr','Mei','Jun'],datasets:[{label:'Aktivitas',data:[3,5,4,7,8,12],backgroundColor:'#2563eb',borderRadius:8}]},options:{plugins:{legend:{display:false}},scales:{y:{beginAtZero:true,ticks:{precision:0}}}}});</script>@endpush
@endsection
