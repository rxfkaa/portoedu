@extends('layouts.app')

@section('title', 'Kelola User')

@section('content')
<div class="container-fluid">
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">👥 Kelola User</h2>
            <p class="text-muted">Manajemen seluruh pengguna sistem.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-4">{{ session('success') }}</div>
    @endif

    <div class="glass-card p-4">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td><strong>{{ $user->name }}</strong></td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <form action="{{ route('admin.users.update', $user) }}" method="POST" class="d-inline">
                                @csrf @method('PUT')
                                <select name="role" class="form-select form-select-sm d-inline w-auto" onchange="this.form.submit()">
                                    <option value="student" {{ $user->role === 'student' ? 'selected' : '' }}>Student</option>
                                    <option value="teacher" {{ $user->role === 'teacher' ? 'selected' : '' }}>Teacher</option>
                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            </form>
                        </td>
                        <td><span class="badge bg-success">Active</span></td>
                        <td class="text-end">
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus user {{ $user->name }}?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $users->links() }}</div>
    </div>
</div>
@endsection

