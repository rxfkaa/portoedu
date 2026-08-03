@extends('layouts.app')

@section('title', 'Kelola Jurusan')

@section('content')
<div class="container-fluid">
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">🏛️ Kelola Jurusan</h2>
            <p class="text-muted">Manajemen data jurusan di sekolah.</p>
        </div>
        <button class="btn btn-primary rounded-4" data-bs-toggle="modal" data-bs-target="#createDepartmentModal">
            <i class="bi bi-plus-circle me-1"></i>Tambah Jurusan
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
                        <th>Kode</th>
                        <th>Nama Jurusan</th>
                        <th>Jumlah Kelas</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($departments as $department)
                    <tr>
                        <td><span class="badge bg-primary">{{ $department->code }}</span></td>
                        <td><strong>{{ $department->name }}</strong></td>
                        <td>{{ $department->classes_count }} kelas</td>
                        <td class="text-end">
                            <button class="btn btn-warning btn-sm rounded-3" data-bs-toggle="modal"
                                    data-bs-target="#editDepartmentModal{{ $department->id }}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form action="{{ route('admin.departments.destroy', $department) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm rounded-3" onclick="return confirm('Hapus jurusan ini?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editDepartmentModal{{ $department->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content rounded-4 border-0 shadow">
                                <div class="modal-header border-0">
                                    <h5 class="fw-bold">Edit Jurusan</h5>
                                    <button class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <form action="{{ route('admin.departments.update', $department) }}" method="POST">
                                        @csrf @method('PUT')
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Kode Jurusan</label>
                                            <input type="text" name="code" class="form-control" value="{{ $department->code }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Nama Jurusan</label>
                                            <input type="text" name="name" class="form-control" value="{{ $department->name }}" required>
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
                        <td colspan="4" class="text-center text-muted py-4">Belum ada data jurusan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $departments->links() }}</div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createDepartmentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="fw-bold">Tambah Jurusan</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('admin.departments.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kode Jurusan</label>
                        <input type="text" name="code" class="form-control" placeholder="Contoh: RPL" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Jurusan</label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: Rekayasa Perangkat Lunak" required>
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

