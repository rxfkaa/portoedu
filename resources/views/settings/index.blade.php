@extends('layouts.app')

@section('title', 'Settings')

@section('content')
<div class="container-fluid">

    <div class="page-header mb-4">
        <div>
            <h2 class="fw-bold">⚙️ Settings</h2>
            <p class="text-muted">Kelola akun dan preferensi aplikasi.</p>
        </div>
    </div>

    <div class="row g-4">

        <!-- Sidebar Menu -->
        <div class="col-lg-3">
            <div class="glass-card p-4">
                <div class="list-group settings-menu">
                    <a href="#profile" class="list-group-item list-group-item-action active">
                        <i class="bi bi-person-circle me-2"></i>Profile
                    </a>
                    <a href="#password" class="list-group-item list-group-item-action">
                        <i class="bi bi-lock-fill me-2"></i>Password
                    </a>
                    <a href="#appearance" class="list-group-item list-group-item-action">
                        <i class="bi bi-moon-stars-fill me-2"></i>Appearance
                    </a>
                    <a href="#notification" class="list-group-item list-group-item-action">
                        <i class="bi bi-bell-fill me-2"></i>Notification
                    </a>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="col-lg-9">

            <!-- Profile -->
            <div class="glass-card p-4 mb-4" id="profile">
                <h4 class="fw-bold mb-4">Informasi Profil</h4>
                <div class="text-center mb-4">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&background=2563EB&color=fff&size=220" class="portfolio-avatar">
                    <br>
                    <button class="btn btn-outline-primary rounded-4 mt-3">Ganti Foto</button>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Nama</label>
                        <input type="text" class="form-control" value="{{ Auth::user()->name }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Email</label>
                        <input type="email" class="form-control" value="{{ Auth::user()->email }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>No HP</label>
                        <input class="form-control" value="{{ Auth::user()->student->phone ?? 'Belum diisi' }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Sekolah</label>
                        <input class="form-control" value="SMKN 4 Bandung">
                    </div>
                    <div class="col-12">
                        <label>Bio</label>
                        <textarea rows="5" class="form-control">{{ Auth::user()->student->bio ?? 'Belum ada bio' }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Password -->
            <div class="glass-card p-4 mb-4" id="password">
                <h4 class="fw-bold mb-4">Ganti Password</h4>
                <form action="{{ route('profile.password') }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label>Password Lama</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password Baru</label>
                        <input type="password" name="password" class="form-control" required min="8">
                    </div>
                    <div class="mb-3">
                        <label>Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    <button class="btn btn-primary rounded-4">Update Password</button>
                </form>
            </div>

            <!-- Appearance -->
            <div class="glass-card p-4 mb-4" id="appearance">
                <h4 class="fw-bold mb-4">Tampilan</h4>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h6 class="mb-1">Dark Mode</h6>
                        <small class="text-muted">Aktifkan tema gelap.</small>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="darkMode">
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1">Animasi</h6>
                        <small class="text-muted">Aktifkan animasi aplikasi.</small>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" checked>
                    </div>
                </div>
            </div>

            <!-- Notification -->
            <div class="glass-card p-4 mb-4" id="notification">
                <h4 class="fw-bold mb-4">Pengaturan Notifikasi</h4>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" checked>
                    <label class="form-check-label">Email Notification</label>
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" checked>
                    <label class="form-check-label">Push Notification</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox">
                    <label class="form-check-label">SMS Notification</label>
                </div>
            </div>

            <!-- Export Data -->
            <div class="glass-card p-4 mb-4">
                <h4 class="fw-bold mb-4">Export Data</h4>
                <p class="text-muted">Download seluruh data portfolio Anda.</p>
                <button class="btn btn-success rounded-4">
                    <i class="bi bi-download me-2"></i>Download Portfolio
                </button>
            </div>

            <!-- Danger Zone -->
            <div class="glass-card p-4 border border-danger">
                <h4 class="fw-bold text-danger mb-3">Danger Zone</h4>
                <p class="text-muted">Menghapus akun akan menghapus seluruh data portfolio secara permanen.</p>
                <button class="btn btn-outline-danger rounded-4" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    <i class="bi bi-trash-fill me-2"></i>Hapus Akun
                </button>
            </div>

        </div>
    </div>

</div>

@include('components.modal-delete')
@endsection

@push('scripts')
<script>
const darkSwitch = document.getElementById('darkMode');
if (localStorage.getItem('theme') === 'dark') {
    document.body.classList.add('dark-mode');
    darkSwitch.checked = true;
}
darkSwitch.addEventListener('change', function() {
    if (this.checked) {
        document.body.classList.add('dark-mode');
        localStorage.setItem('theme', 'dark');
    } else {
        document.body.classList.remove('dark-mode');
        localStorage.setItem('theme', 'light');
    }
});
</script>
@endpush
