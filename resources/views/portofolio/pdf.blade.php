<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Portofolio {{ $user->name }}</title>
    <style>
        @page { margin: 34px 42px 48px; }
        * { box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; color: #172033; font-size: 10px; line-height: 1.55; }
        .topline { height: 5px; background: #2563eb; margin: -34px -42px 26px; }
        .brand { color: #2563eb; font-size: 9px; font-weight: bold; letter-spacing: 1.4px; text-transform: uppercase; }
        .header { width: 100%; border-collapse: collapse; margin-bottom: 18px; }
        .header td { vertical-align: middle; }
        .profile-photo { width: 68px; height: 68px; border-radius: 50%; object-fit: cover; border: 0; }
        .header h1 { margin: 4px 0 3px; color: #101a32; font-size: 25px; line-height: 1.2; }
        .subtitle { color: #64748b; font-size: 11px; }
        .meta { color: #475569; font-size: 9px; margin-top: 8px; }
        .profile { background: #f1f5ff; border-left: 3px solid #2563eb; padding: 10px 12px; margin-bottom: 17px; color: #334155; }
        .profile-title { color: #1d4ed8; font-weight: bold; margin-bottom: 3px; font-size: 9px; text-transform: uppercase; letter-spacing: .5px; }
        .stats { width: 100%; border-collapse: separate; border-spacing: 5px 0; margin: 0 -5px 21px; }
        .stats td { width: 25%; background: #f8fafc; border: 1px solid #e2e8f0; padding: 8px 10px; }
        .stat-number { color: #1d4ed8; font-size: 17px; font-weight: bold; line-height: 1.2; }
        .stat-label { color: #64748b; font-size: 8px; text-transform: uppercase; letter-spacing: .4px; }
        .section { margin: 0 0 18px; }
        .section-heading { border-bottom: 1px solid #cbd5e1; padding: 0 0 6px; margin-bottom: 8px; color: #1d4ed8; font-size: 13px; font-weight: bold; }
        .entry { padding: 7px 0 8px; border-bottom: 1px solid #e8edf4; page-break-inside: avoid; }
        .entry:last-child { border-bottom: 0; }
        .entry-title { color: #172033; font-size: 10px; font-weight: bold; margin-bottom: 2px; }
        .entry-meta { color: #64748b; font-size: 8.5px; margin-bottom: 2px; }
        .entry-description { color: #475569; font-size: 9px; }
        .skills { margin-top: 4px; }
        .skill { display: inline-block; background: #eff6ff; color: #1d4ed8; border: 1px solid #dbeafe; padding: 3px 7px; margin: 0 4px 5px 0; font-size: 8.5px; }
        .empty-note { color: #94a3b8; font-style: italic; }
        .footer { position: fixed; bottom: -30px; left: 0; right: 0; border-top: 1px solid #e2e8f0; padding-top: 7px; color: #94a3b8; font-size: 8px; }
        .footer table { width: 100%; border-collapse: collapse; }
        .footer td:last-child { text-align: right; }
    </style>
</head>
<body>
    <div class="topline"></div>
    <table class="header">
        <tr>
            <td>
                <div class="brand">PortoEdu &nbsp; / &nbsp; Student Portfolio</div>
                <h1>{{ $user->name }}</h1>
                <div class="subtitle">Portofolio Siswa</div>
                <div class="meta">
                    @if($student->classRoom)
                        {{ $student->classRoom->level }} {{ $student->classRoom->name }}
                        @if($student->classRoom->department) &nbsp;|&nbsp; {{ $student->classRoom->department->name }} @endif
                    @endif
                    @if($student->nipd) &nbsp;|&nbsp; NIPD {{ $student->nipd }} @endif
                </div>
            </td>
            <td style="text-align:right; color:#64748b; font-size:9px; width:100px;">
                @if($photoDataUri)<img src="{{ $photoDataUri }}" class="profile-photo" alt="Foto {{ $user->name }}"><br>@endif
                Diperbarui<br><strong style="color:#172033">{{ now()->format('d M Y') }}</strong>
            </td>
        </tr>
    </table>

    @if($student->bio || $student->phone || $user->email || $student->address)
        <div class="profile">
            <div class="profile-title">Profil singkat</div>
            @if($student->bio)<div>{{ $student->bio }}</div>@endif
            @if($student->phone || $user->email)<div style="margin-top:3px">@if($student->phone){{ $student->phone }}@endif @if($student->phone && $user->email)&nbsp; | &nbsp;@endif @if($user->email){{ $user->email }}@endif</div>@endif
            @if($student->address)<div style="margin-top:2px">{{ $student->address }}</div>@endif
        </div>
    @endif

    <table class="stats">
        <tr>
            <td><div class="stat-number">{{ $achievements->count() }}</div><div class="stat-label">Prestasi</div></td>
            <td><div class="stat-number">{{ $projects->count() }}</div><div class="stat-label">Projek</div></td>
            <td><div class="stat-number">{{ $certificates->count() }}</div><div class="stat-label">Sertifikat</div></td>
            <td><div class="stat-number">{{ $organizations->count() + $internships->count() }}</div><div class="stat-label">Pengalaman</div></td>
        </tr>
    </table>

    @if($skills->isNotEmpty())
        <div class="section">
            <div class="section-heading">Keahlian</div>
            <div class="skills">
                @foreach($skills as $skill)<span class="skill">{{ $skill->name }}@if($skill->level) &nbsp;·&nbsp; {{ $skill->level }}@endif</span>@endforeach
            </div>
        </div>
    @endif

    @if($achievements->isNotEmpty())
        <div class="section">
            <div class="section-heading">Prestasi</div>
            @foreach($achievements as $item)
                <div class="entry">
                    <div class="entry-title">{{ $item->title }}</div>
                    <div class="entry-meta">{{ $item->level }}@if($item->organizer) &nbsp;·&nbsp; {{ $item->organizer }}@endif @if($item->date) &nbsp;·&nbsp; {{ $item->date->format('d M Y') }}@endif</div>
                    @if($item->description)<div class="entry-description">{{ $item->description }}</div>@endif
                </div>
            @endforeach
        </div>
    @endif

    @if($projects->isNotEmpty())
        <div class="section">
            <div class="section-heading">Projek</div>
            @foreach($projects as $project)
                <div class="entry">
                    <div class="entry-title">{{ $project->title }}</div>
                    @if($project->category || $project->technology)<div class="entry-meta">{{ $project->category }}@if($project->category && $project->technology) &nbsp;·&nbsp; @endif{{ $project->technology }}</div>@endif
                    @if($project->description)<div class="entry-description">{{ $project->description }}</div>@endif
                    @if($project->github || $project->demo)<div class="entry-meta">@if($project->github)GitHub: {{ $project->github }}@endif @if($project->github && $project->demo)&nbsp; | &nbsp;@endif @if($project->demo)Demo: {{ $project->demo }}@endif</div>@endif
                </div>
            @endforeach
        </div>
    @endif

    @if($certificates->isNotEmpty())
        <div class="section">
            <div class="section-heading">Sertifikat</div>
            @foreach($certificates as $certificate)
                <div class="entry">
                    <div class="entry-title">{{ $certificate->title }}</div>
                    <div class="entry-meta">{{ $certificate->issuer }}@if($certificate->issued_at) &nbsp;·&nbsp; {{ $certificate->issued_at->format('d M Y') }}@endif</div>
                    @if($certificate->certificate_number)<div class="entry-meta">Nomor: {{ $certificate->certificate_number }}</div>@endif
                    @if($certificate->description)<div class="entry-description">{{ $certificate->description }}</div>@endif
                </div>
            @endforeach
        </div>
    @endif

    @if($internships->isNotEmpty())
        <div class="section">
            <div class="section-heading">Praktik Kerja Lapangan</div>
            @foreach($internships as $internship)
                <div class="entry">
                    <div class="entry-title">{{ $internship->position }}@if($internship->company) &nbsp;·&nbsp; {{ $internship->company }}@endif</div>
                    <div class="entry-meta">{{ $internship->started_at?->format('M Y') ?? '—' }} – {{ $internship->ended_at?->format('M Y') ?? 'Sekarang' }}@if($internship->address) &nbsp;·&nbsp; {{ $internship->address }}@endif</div>
                    @if($internship->description)<div class="entry-description">{{ $internship->description }}</div>@endif
                </div>
            @endforeach
        </div>
    @endif

    @if($organizations->isNotEmpty())
        <div class="section">
            <div class="section-heading">Organisasi</div>
            @foreach($organizations as $org)
                <div class="entry">
                    <div class="entry-title">{{ $org->organization_name ?? $org->name }}</div>
                    <div class="entry-meta">{{ $org->position }}@if($org->start_date || $org->started_at) &nbsp;·&nbsp; {{ $org->start_date?->format('M Y') ?? $org->started_at?->format('M Y') }} – {{ $org->end_date?->format('M Y') ?? $org->ended_at?->format('M Y') ?? 'Sekarang' }}@endif</div>
                    @if($org->description)<div class="entry-description">{{ $org->description }}</div>@endif
                </div>
            @endforeach
        </div>
    @endif

    @if($achievements->isEmpty() && $projects->isEmpty() && $certificates->isEmpty() && $organizations->isEmpty() && $skills->isEmpty() && $internships->isEmpty())
        <div class="profile"><div class="profile-title">Portofolio sedang disiapkan</div>Belum ada data portofolio yang dapat ditampilkan.</div>
    @endif

    <div class="footer">
        <table><tr><td>PortoEdu &nbsp;·&nbsp; Dokumen portofolio siswa</td><td>{{ now()->format('d M Y') }}</td></tr></table>
    </div>
</body>
</html>
