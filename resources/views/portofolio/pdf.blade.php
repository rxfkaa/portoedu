<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Portofolio {{ $user->name }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #1e293b;
            font-size: 12px;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            padding: 30px 20px;
            background: linear-gradient(135deg, #2563eb, #4f46e5);
            color: white;
            border-radius: 0 0 20px 20px;
        }
        .header h1 { font-size: 28px; margin-bottom: 5px; }
        .header p { font-size: 14px; opacity: 0.9; }
        .section { padding: 20px; }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #2563eb;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }
        .item {
            margin-bottom: 12px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e2e8f0;
        }
        .item:last-child { border-bottom: none; }
        .item h4 { font-size: 13px; font-weight: bold; margin-bottom: 3px; }
        .item p { font-size: 11px; color: #475569; }
        .item small { font-size: 10px; color: #94a3b8; }
        .stats {
            display: flex;
            justify-content: space-around;
            padding: 20px;
            text-align: center;
        }
        .stat h3 { font-size: 20px; color: #2563eb; }
        .stat p { font-size: 10px; color: #64748b; }
        .footer {
            text-align: center;
            padding: 15px;
            font-size: 10px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
        }
        .badge {
            display: inline-block;
            background: #2563eb;
            color: white;
            font-size: 9px;
            padding: 2px 8px;
            border-radius: 10px;
            margin-right: 4px;
        }
        .badge-success { background: #22c55e; }
        .badge-warning { background: #f59e0b; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $user->name }}</h1>
        <p>Digital Student Portfolio</p>
        @if($student->classRoom)
            <p style="font-size: 12px; opacity: 0.8; margin-top: 5px;">
                {{ $student->classRoom->name }} · {{ $student->classRoom->department->name ?? '' }}
            </p>
        @endif
    </div>

    <div class="stats">
        <div class="stat"><h3>{{ $achievements->count() }}</h3><p>Prestasi</p></div>
        <div class="stat"><h3>{{ $projects->count() }}</h3><p>Project</p></div>
        <div class="stat"><h3>{{ $certificates->count() }}</h3><p>Sertifikat</p></div>
        <div class="stat"><h3>{{ $organizations->count() }}</h3><p>Organisasi</p></div>
    </div>

    @if($achievements->isNotEmpty())
    <div class="section">
        <div class="section-title">🏆 Prestasi</div>
        @foreach($achievements as $item)
        <div class="item">
            <h4>{{ $item->title }}</h4>
<p>{{ $item->level }} · {{ $item->organizer }}@if($item->date) · {{ $item->date->format('d M Y') }}@endif</p>
            @if($item->description)<small>{{ $item->description }}</small>@endif
        </div>
        @endforeach
    </div>
    @endif

    @if($projects->isNotEmpty())
    <div class="section">
        <div class="section-title">💻 Project</div>
        @foreach($projects as $project)
        <div class="item">
            <h4>{{ $project->title }}</h4>
            <p>{!! nl2br(e($project->description)) !!}</p>
            @if($project->technology)<small>Teknologi: {{ $project->technology }}</small>@endif
        </div>
        @endforeach
    </div>
    @endif

    @if($certificates->isNotEmpty())
    <div class="section">
        <div class="section-title">📜 Sertifikat</div>
        @foreach($certificates as $certificate)
        <div class="item">
            <h4>{{ $certificate->title }}</h4>
            <p>{{ $certificate->issuer }}@if($certificate->issued_at) · {{ $certificate->issued_at->format('d M Y') }}@endif</p>
            @if($certificate->certificate_number)<small>No: {{ $certificate->certificate_number }}</small>@endif
        </div>
        @endforeach
    </div>
    @endif

    @if($organizations->isNotEmpty())
    <div class="section">
        <div class="section-title">👥 Organisasi</div>
        @foreach($organizations as $org)
        <div class="item">
            <h4>{{ $org->organization_name ?? $org->name }}</h4>
            <p>{{ $org->position }}</p>
            <small>{{ $org->start_date?->format('M Y') ?? $org->started_at?->format('M Y') }} -
                   {{ $org->end_date?->format('M Y') ?? $org->ended_at?->format('M Y') ?? 'Sekarang' }}</small>
        </div>
        @endforeach
    </div>
    @endif

    <div class="footer">
        <p>Dokumen ini dibuat secara otomatis dari Digital Student Portfolio</p>
        <p>{{ date('d F Y') }}</p>
    </div>
</body>
</html>
