@extends('layouts.app')

@section('title', 'Review Project')

@section('content')
<div class="container-fluid">
    <div class="page-header mb-4">
        <h2 class="fw-bold mb-1">Review Project Siswa</h2>
        <p class="text-muted mb-0">Beri umpan balik yang membangun untuk karya siswa.</p>
    </div>

    <div class="row g-4">
        @forelse($projects as $project)
            <div class="col-lg-6">
                <div class="glass-card p-4 h-100">
                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-4 bg-primary-subtle text-primary p-3"><i class="bi bi-code-square fs-3"></i></div>
                        <div class="flex-grow-1"><h5 class="fw-bold mb-1">{{ $project->title }}</h5><p class="text-muted small mb-2">Oleh {{ $project->student->name ?? $project->student->user->name }}</p><p class="mb-0 small">{{ Str::limit($project->description, 145) }}</p></div>
                    </div>
                    <div class="mt-3 pt-3 border-top">
                        @forelse($project->comments as $comment)
                            <div class="comment-card rounded-3 p-3 mb-2 small">
                                <strong>{{ $comment->teacher->name }}:</strong>
                                @if($comment->teacher_id === auth()->user()?->teacher?->id)
                                    <form method="POST" action="{{ route('teacher.comments.update', $comment) }}" class="d-flex gap-2 mt-2">
                                        @csrf @method('PUT')
                                        <input name="comment" class="form-control form-control-sm" maxlength="2000" value="{{ $comment->comment }}" aria-label="Edit masukan" required>
                                        <button class="btn btn-sm btn-outline-primary">Simpan</button>
                                    </form>
                                    <form method="POST" action="{{ route('teacher.comments.destroy', $comment) }}" class="mt-2">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-link text-danger p-0" onclick="return confirm('Hapus masukan ini?')">Hapus</button>
                                    </form>
                                @else
                                    <p class="mb-0 mt-1 text-muted">Masukan dari guru lain</p>
                                @endif
                            </div>
                        @empty
                            <p class="small text-muted">Belum ada masukan dari guru.</p>
                        @endforelse
                        <form method="POST" action="{{ route('teacher.projects.comment', $project) }}" class="mt-3">
                            @csrf
                            <div class="input-group"><input class="form-control" name="comment" maxlength="2000" placeholder="Tulis masukan untuk siswa..." required><button class="btn btn-primary" type="submit" aria-label="Kirim masukan"><i class="bi bi-send"></i></button></div>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12"><div class="glass-card p-5 text-center text-muted"><i class="bi bi-folder2-open fs-1 d-block mb-2"></i>Belum ada project yang dikirim siswa.</div></div>
        @endforelse
    </div>
</div>
@endsection
