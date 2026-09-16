@extends('layouts.guest')

@section('title', 'Daftar | Digital Student Portfolio')

@section('content')
<div class="auth-shell">
    <section class="auth-panel auth-panel--brand">
        <span class="auth-eyebrow"><i class="bi bi-stars"></i> Digital Student Portfolio</span>
        <h1>Bangun portofolio yang membuatmu bangga.</h1>
        <p>Simpan karya, prestasi, dan pengalamanmu dalam satu tempat yang rapi.</p>
    </section>
    <section class="auth-panel auth-panel--form">
        <div class="auth-form">
            <a href="{{ route('landing') }}" class="text-decoration-none text-muted small"><i class="bi bi-arrow-left"></i> Kembali ke beranda</a>
            <h2 class="mt-4 fw-bold">Buat akun</h2>
            <p class="text-muted">Pilih jenis akun, lalu tunggu persetujuan dari admin.</p>
            <form action="{{ route('register.store') }}" method="POST" class="mt-4">
                @csrf
                <div class="mb-3"><label class="form-label">Nama lengkap</label><input name="name" value="{{ old('name') }}" class="form-control form-control-lg" required></div>
                <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" value="{{ old('email') }}" class="form-control form-control-lg" required>@error('email')<small class="text-danger">{{ $message }}</small>@enderror</div>
                <div class="mb-3">
                    <label class="form-label">Daftar sebagai</label>
                    <select name="requested_role" class="form-select form-select-lg @error('requested_role') is-invalid @enderror" required>
                        <option value="">Pilih jenis akun</option>
                        <option value="student" @selected(old('requested_role') === 'student')>Siswa</option>
                        <option value="teacher" @selected(old('requested_role') === 'teacher')>Guru</option>
                    </select>
                    @error('requested_role')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
                <div id="student-registration-fields" class="registration-role-fields" hidden>
                    <div class="mb-3"><label class="form-label">NIS</label><input name="nis" value="{{ old('nis') }}" class="form-control form-control-lg @error('nis') is-invalid @enderror" maxlength="50">@error('nis')<small class="text-danger">{{ $message }}</small>@enderror</div>
                    <div class="mb-3"><label class="form-label">Kelas</label><select name="class_id" class="form-select form-select-lg @error('class_id') is-invalid @enderror"><option value="">Pilih kelas</option>@foreach($classes as $class)<option value="{{ $class->id }}" @selected((string) old('class_id') === (string) $class->id)>{{ $class->level }} {{ $class->name }} — {{ $class->department?->name }}</option>@endforeach</select>@error('class_id')<small class="text-danger">{{ $message }}</small>@enderror</div>
                </div>
                <div id="teacher-registration-fields" class="registration-role-fields" hidden>
                    <div class="mb-3"><label class="form-label">NIP</label><input name="nip" value="{{ old('nip') }}" class="form-control form-control-lg @error('nip') is-invalid @enderror" maxlength="50">@error('nip')<small class="text-danger">{{ $message }}</small>@enderror</div>
                    <div class="mb-3"><label class="form-label">Nomor HP</label><input type="tel" name="phone" value="{{ old('phone') }}" class="form-control form-control-lg @error('phone') is-invalid @enderror" maxlength="20">@error('phone')<small class="text-danger">{{ $message }}</small>@enderror</div>
                </div>
                <div class="mb-3"><label class="form-label">Password</label><input type="password" name="password" class="form-control form-control-lg" autocomplete="new-password" required minlength="8"></div>
                <div class="mb-4"><label class="form-label">Konfirmasi password</label><input type="password" name="password_confirmation" class="form-control form-control-lg" autocomplete="new-password" required minlength="8"></div>
                <button class="btn btn-primary btn-lg w-100 rounded-4">Buat Akun <i class="bi bi-arrow-right ms-1"></i></button>
            </form>
            <p class="text-center mt-4 mb-0">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    const roleSelect = document.querySelector('[name="requested_role"]');
    const studentFields = document.getElementById('student-registration-fields');
    const teacherFields = document.getElementById('teacher-registration-fields');
    const setRoleFields = () => {
        studentFields.hidden = roleSelect.value !== 'student';
        teacherFields.hidden = roleSelect.value !== 'teacher';
        studentFields.querySelectorAll('input, select').forEach((field) => field.required = roleSelect.value === 'student');
        teacherFields.querySelectorAll('input').forEach((field) => field.required = roleSelect.value === 'teacher');
    };
    roleSelect.addEventListener('change', setRoleFields);
    setRoleFields();
</script>
@endpush
