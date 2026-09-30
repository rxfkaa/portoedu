@extends('layouts.app')

@section('title', 'Verifikasi Portofolio')

@section('content')
<div class="container-fluid">
    <div class="page-header mb-4"><h2 class="fw-bold mb-1">Verifikasi Portofolio</h2><p class="text-muted mb-0">Tinjau dan sahkan data prestasi serta sertifikat siswa.</p></div>
    @foreach(['achievement' => ['title' => 'Prestasi Siswa', 'items' => $achievements], 'certificate' => ['title' => 'Sertifikat Siswa', 'items' => $certificates]] as $type => $section)
        <div class="glass-card p-4 mb-4">
            <h5 class="fw-bold mb-3">{{ $section['title'] }}</h5>
            <div class="table-responsive"><table class="table align-middle mb-0">
                <thead><tr><th>Siswa</th><th>Data</th><th>Tanggal</th><th>Status</th><th class="text-end">Aksi</th></tr></thead>
                <tbody>
                @forelse($section['items'] as $item)
                    <tr>
                        <td><strong>{{ $item->student->name ?? $item->student->user->name }}</strong><br><small class="text-muted">{{ $item->student->nis }}</small></td>
                        <td><strong>{{ $item->title }}</strong><br><small class="text-muted">{{ $type === 'achievement' ? $item->organizer : $item->issuer }}</small></td>
                        <td>{{ ($type === 'achievement' ? $item->date : $item->issued_at)?->format('d M Y') }}</td>
                        <td><span class="badge {{ $item->status === 'verified' ? 'text-bg-success' : ($item->status === 'rejected' ? 'text-bg-danger' : 'text-bg-warning') }}">{{ $item->status === 'pending' ? 'Menunggu' : ucfirst($item->status) }}</span>@if($item->status === 'rejected' && $item->rejection_reason)<small class="d-block text-danger mt-1">{{ $item->rejection_reason }}</small>@endif</td>
                        <td class="text-end">
                            @if($item->status === 'pending')
                                <form class="d-inline" method="POST" action="{{ route('teacher.verify', ['type' => $type, 'id' => $item->id]) }}">@csrf @method('PATCH')<input type="hidden" name="status" value="verified"><button class="btn btn-sm btn-success" onclick="return confirm('Terima data ini?')">Terima</button></form>
                                <form class="d-inline-flex gap-1 mt-1" method="POST" action="{{ route('teacher.verify', ['type' => $type, 'id' => $item->id]) }}">@csrf @method('PATCH')<input type="hidden" name="status" value="rejected"><input class="form-control form-control-sm" name="rejection_reason" maxlength="1000" required placeholder="Alasan penolakan" aria-label="Alasan penolakan"><button class="btn btn-sm btn-outline-danger" onclick="return confirm('Tolak data ini?')">Tolak</button></form>
                            @else
                                <span class="text-muted small">Sudah diproses</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Belum ada data.</td></tr>
                @endforelse
                </tbody>
            </table></div>
        </div>
    @endforeach
</div>
@endsection
