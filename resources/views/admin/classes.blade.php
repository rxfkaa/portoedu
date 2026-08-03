@extends('layouts.app')

@section('title', 'Kelola Kelas')

@section('content')
<div class="container-fluid">
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">🏫 Kelola Kelas</h2>
            <p class="text-muted">Manajemen data kelas dan penempatan jurusan.</p>
        </div>
        <button class="btn btn-primary rounded-4" data-bs-toggle="modal" data-bs-target="#createClassModal">
            <i class="bi bi-plus-circle me-1"></i>Tambah Kelas
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger rounded-4">{{ session('error') }}</div>
    @endif

    <div class="glass-card p-4">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Nama Kelas</th>
                        <th>Tingkat</th>
                        <th>Jurusan</th>
                        <th>Jumlah Siswa</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($classes as $class)
                    <tr>
                        <td><strong>{{ $class->name }}</strong></td>
                        <td><span class="badge bg-light text-dark">{{ $class->level }}</span></td>
                        <td>{{ $class->department->name ?? '-' }}</td>
                        <td>{{ $class->students_count ?? 0 }} siswa</td>
                        <td class="text-end">
                            <button class="btn btn-warning btn-sm rounded-3" data-bs-toggle="modal"
                                    data-bs-target="#editClassModal{{ $class->id }}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="{{ route('admin.classes.destroy', $class) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm rounded-3" onclick="return confirm('Hapus kelas ini?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editClassModal{{ $class->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content rounded-4 border-0 shadow">
                                <div class="modal-header border-0">
                                    <h5 class="fw-bold">Edit Kelas</h5>
                                    <button class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <form action="{{ route('admin.classes.update', $class) }}" method="POST">
                                        @csrf @method('PUT')
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Nama Kelas</label>
                                            <input type="text" name="name" class="form-control" value="{{ $class->name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Tingkat</label>
                                            <select name="level" class="form-select" required>
                                                @foreach(['X', 'XI', 'XII'] as $lv)
                                                    <option value="{{ $lv }}" {{ $class->level === $lv ? 'selected' : '' }}>{{ $lv }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Jurusan</label>
                                            <select name="department_id" class="form-select" required>
                                                @foreach($departments as $dept)
                                                    <option value="{{ $dept->id }}" {{ $class->department_id === $dept->id ? 'selected' : '' }}>
                                                        {{ $dept->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="text-end">
                                            <button class="btn btn-warning rounded-4 px-4">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Belum ada data kelas.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $classes->links() }}</div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createClassModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="fw-bold">Tambah Kelas</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('admin.classes.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Kelas</label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: XII RPL 1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tingkat</label>
                        <select name="level" class="form-select" required>
                            <option value="X">X</option>
                            <option value="XI">XI</option>
                            <option value="XII">XII</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jurusan</label>
                        <select name="department_id" class="form-select" required>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="text-end">
                        <button class="btn btn-primary rounded-4 px-4">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

