@extends('layouts.app')

@section('title', 'Settings')

@section('content')
<div class="container-fluid">

    <div class="page-header mb-4">
        <div>
            <h2 class="fw-bold">⚙️ Settings</h2>
            <p class="text-muted">Kelola profil, keamanan, dan preferensi aplikasi kamu.</p>
        </div>
    </div>

    <div class="row g-4">

        <!-- Sidebar Menu (Tab Nav) -->
        <div class="col-lg-3">
            <div class="glass-card p-3 settings-sidebar">
                <div class="list-group settings-menu" id="settingsNav">
                    <a href="#profile" data-tab="profile" class="list-group-item list-group-item-action active">
                        <i class="bi bi-person-circle me-2"></i>Profile
                    </a>
                    <a href="#password" data-tab="password" class="list-group-item list-group-item-action">
                        <i class="bi bi-lock-fill me-2"></i>Password
                    </a>
                    <a href="#appearance" data-tab="appearance" class="list-group-item list-group-item-action">
                        <i class="bi bi-moon-stars-fill me-2"></i>Appearance
                    </a>
                    <a href="#notification" data-tab="notification" class="list-group-item list-group-item-action">
                        <i class="bi bi-bell-fill me-2"></i>Notification
                    </a>
                    <a href="#export" data-tab="export" class="list-group-item list-group-item-action">
                        <i class="bi bi-download me-2"></i>Export
                    </a>
                    <a href="#danger" data-tab="danger" class="list-group-item list-group-item-action">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>Danger Zone
                    </a>
                </div>
            </div>
        </div>

        <!-- Content: hanya satu panel yang tampil -->
        <div class="col-lg-9">

            {{-- PANEL: PROFILE --}}
            <div class="glass-card p-4 tab-panel" data-panel="profile">
                <div class="d-flex align-items-center gap-2 mb-4">
                    <i class="bi bi-person-circle fs-3 text-primary"></i>
                    <div>
                        <h4 class="fw-bold mb-0">Informasi Profil</h4>
                        <small class="text-muted">Perbarui data pribadi dan foto kamu.</small>
                    </div>
                </div>

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    <div class="text-center mb-4">
                        <img src="{{ $student && $student->photo ? asset('storage/'.$student->photo) : 'https://ui-avatars.com/api/?name='.urlencode($user->name ?? 'User').'&background=2563EB&color=fff&size=220' }}"
                             class="portfolio-avatar" id="settingsAvatar">
                        <br>
                        <label class="btn btn-outline-primary rounded-4 mt-3">
                            <i class="bi bi-camera-fill me-1"></i>Ganti Foto
                            <input type="file" name="photo" accept="image/*" class="d-none" id="photoInput">
                        </label>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">No HP</label>
                            <input name="phone" class="form-control" value="{{ old('phone', $student?->phone ?? '') }}" placeholder="08xxxxxxxxxx">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Alamat</label>
                            <input name="address" class="form-control" value="{{ old('address', $student?->address ?? '') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tempat Lahir</label>
                            <input name="birth_place" class="form-control" value="{{ old('birth_place', $student?->birth_place ?? '') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date', $student?->birth_date ? \Carbon\Carbon::parse($student->birth_date)->format('Y-m-d') : '') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Bio</label>
                            <textarea name="bio" rows="4" class="form-control" placeholder="Ceritakan tentang dirimu...">{{ old('bio', $student?->bio ?? '') }}</textarea>
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <button class="btn btn-primary rounded-4 px-5">
                            <i class="bi bi-check-circle-fill me-2"></i>Simpan Perubahan Profil
                        </button>
                    </div>
                </form>
            </div>

            {{-- PANEL: PASSWORD --}}
            <div class="glass-card p-4 tab-panel d-none" data-panel="password">
                <div class="d-flex align-items-center gap-2 mb-4">
                    <i class="bi bi-lock-fill fs-3 text-primary"></i>
                    <div>
                        <h4 class="fw-bold mb-0">Ganti Password</h4>
                        <small class="text-muted">Gunakan password yang kuat dan mudah diingat.</small>
                    </div>
                </div>

                <form action="{{ route('profile.password') }}" method="POST">
                    @csrf @method('PUT')
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Password Lama</label>
                            <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" autocomplete="current-password" required>
                            @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" autocomplete="new-password" required minlength="8">
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" autocomplete="new-password" required minlength="8">
                        </div>
                    </div>
                    <div class="text-end mt-2">
                        <button class="btn btn-primary rounded-4 px-4">
                            <i class="bi bi-shield-lock-fill me-2"></i>Update Password
                        </button>
                    </div>
                </form>
            </div>

{{-- PANEL: APPEARANCE --}}
            <div class="glass-card p-4 tab-panel d-none" data-panel="appearance">
                <div class="d-flex align-items-center gap-2 mb-4">
                    <i class="bi bi-moon-stars-fill fs-3 text-primary"></i>
                    <div>
                        <h4 class="fw-bold mb-0">Tampilan</h4>
                        <small class="text-muted">Atur tema aplikasi dan portfolio publik.</small>
                    </div>
                </div>

                <form action="{{ route('settings.appearance') }}" method="POST">
                    @csrf

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between align-items-center border rounded-3 p-3">
                                <div>
                                    <h6 class="mb-1 fw-semibold">Dark Mode</h6>
                                    <small class="text-muted">Aktifkan tema gelap aplikasi.</small>
                                </div>
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" id="themeSwitch">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between align-items-center border rounded-3 p-3">
                                <div>
                                    <h6 class="mb-1 fw-semibold">Animasi</h6>
                                    <small class="text-muted">Aktifkan animasi aplikasi.</small>
                                </div>
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" id="animSwitch" checked>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h6 class="fw-bold mb-3">🎨 Tema Portfolio Publik</h6>
                    <div class="row g-3 mb-4">
                        @php
                            $themes = [
                                'indigo'  => ['#2563eb', 'Indigo'],
                                'emerald' => ['#059669', 'Emerald'],
                                'rose'    => ['#e11d48', 'Rose'],
                                'amber'   => ['#d97706', 'Amber'],
                                'slate'   => ['#334155', 'Slate'],
                            ];
                            $currentTheme = $portfolioSetting?->theme ?? 'indigo';
                        @endphp
                        @foreach($themes as $key => [$color, $label])
                        <div class="col-6 col-md-4">
                            <label class="theme-option {{ $currentTheme === $key ? 'selected' : '' }}" data-theme="{{ $key }}">
                                <input type="radio" name="theme" value="{{ $key }}" class="d-none"
                                       {{ $currentTheme === $key ? 'checked' : '' }}>
                                <span class="theme-circle" style="background:{{ $color }}"></span>
                                <span class="ms-2">{{ $label }}</span>
                            </label>
                        </div>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-between align-items-center border rounded-3 p-3 mb-4">
                        <div>
                            <h6 class="mb-1 fw-semibold">Portfolio Publik</h6>
                            <small class="text-muted">Izinkan orang lain melihat portfolio kamu.</small>
                        </div>
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" name="is_public" value="1"
                                   id="publicSwitch" {{ $portfolioSetting?->is_public ? 'checked' : '' }}>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h6 class="fw-bold mb-3">🔗 Akun Media Sosial</h6>
                    <div id="socialLinksContainer">
                        @forelse($socialLinks as $i => $link)
                        <div class="row g-2 mb-2 social-link-row">
                            <div class="col-4">
                                <select name="social_links[{{ $i }}][platform]" class="form-select">
                                    @foreach(['github'=>'GitHub','linkedin'=>'LinkedIn','instagram'=>'Instagram','twitter'=>'Twitter','youtube'=>'YouTube','website'=>'Website'] as $pKey=>$pLabel)
                                        <option value="{{ $pKey }}" {{ $link->platform === $pKey ? 'selected' : '' }}>{{ $pLabel }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-7">
                                <input type="url" name="social_links[{{ $i }}][url]" class="form-control" value="{{ $link->url }}" placeholder="https://...">
                            </div>
                            <div class="col-1">
                                <button type="button" class="btn btn-outline-danger btn-sm remove-social"><i class="bi bi-x"></i></button>
                            </div>
                        </div>
                        @empty
                        <div class="row g-2 mb-2 social-link-row">
                            <div class="col-4">
                                <select name="social_links[0][platform]" class="form-select">
                                    <option value="github">GitHub</option>
                                    <option value="linkedin">LinkedIn</option>
                                    <option value="instagram">Instagram</option>
                                    <option value="twitter">Twitter</option>
                                    <option value="youtube">YouTube</option>
                                    <option value="website">Website</option>
                                </select>
                            </div>
                            <div class="col-7">
                                <input type="url" name="social_links[0][url]" class="form-control" placeholder="https://...">
                            </div>
                            <div class="col-1">
                                <button type="button" class="btn btn-outline-danger btn-sm remove-social"><i class="bi bi-x"></i></button>
                            </div>
                        </div>
                        @endforelse
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm rounded-3 mt-2" id="addSocialLink">
                        <i class="bi bi-plus-lg me-1"></i>Tambah Link
                    </button>

                    <div class="text-end mt-4">
                        <button class="btn btn-primary rounded-4 px-5">
                            <i class="bi bi-check-circle-fill me-2"></i>Simpan Tampilan
                        </button>
                    </div>
                </form>
            </div>

            {{-- PANEL: NOTIFICATION --}}
            <div class="glass-card p-4 tab-panel d-none" data-panel="notification">
                <div class="d-flex align-items-center gap-2 mb-4">
                    <i class="bi bi-bell-fill fs-3 text-primary"></i>
                    <div>
                        <h4 class="fw-bold mb-0">Pengaturan Notifikasi</h4>
                        <small class="text-muted">Pilih notifikasi yang ingin kamu terima.</small>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="border rounded-3 p-3 d-flex justify-content-between align-items-center">
                            <div>
                                <i class="bi bi-envelope-fill text-primary me-2"></i>
                                <span>Email</span>
                            </div>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" checked>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded-3 p-3 d-flex justify-content-between align-items-center">
                            <div>
                                <i class="bi bi-phone-fill text-primary me-2"></i>
                                <span>Push</span>
                            </div>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" checked>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded-3 p-3 d-flex justify-content-between align-items-center">
                            <div>
                                <i class="bi bi-chat-dots-fill text-primary me-2"></i>
                                <span>SMS</span>
                            </div>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- PANEL: EXPORT --}}
            <div class="glass-card p-4 tab-panel d-none" data-panel="export">
                <div class="d-flex align-items-center gap-2 mb-4">
                    <i class="bi bi-download fs-3 text-primary"></i>
                    <div>
                        <h4 class="fw-bold mb-0">Export Data</h4>
                        <small class="text-muted">Unduh seluruh data portfolio kamu.</small>
                    </div>
                </div>
<div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
                    <p class="text-muted mb-0">Download seluruh data portfolio dalam format PDF.</p>
                    <a href="{{ auth()->user()->student ? route('portfolio.export.pdf') : '#' }}"
                       class="btn btn-success rounded-4 px-4 {{ !auth()->user()->student ? 'disabled' : '' }}">
                        <i class="bi bi-file-earmark-pdf-fill me-2"></i>Download Portfolio PDF
                    </a>
                </div>
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
                    <p class="text-muted mb-0">Download seluruh data portfolio dalam format JSON (untuk backup/pindah akun).</p>
                    <a href="{{ route('settings.export-json') }}"
                       class="btn btn-outline-primary rounded-4 px-4 {{ !auth()->user()->student ? 'disabled' : '' }}">
                        <i class="bi bi-file-earmark-code-fill me-2"></i>Export Portfolio JSON
                    </a>
                </div>
            </div>

            {{-- PANEL: DANGER ZONE --}}
            <div class="glass-card p-4 border border-danger tab-panel d-none" data-panel="danger">
                <div class="d-flex align-items-center gap-2 mb-4">
                    <i class="bi bi-exclamation-triangle-fill fs-3 text-danger"></i>
                    <div>
                        <h4 class="fw-bold text-danger mb-0">Danger Zone</h4>
                        <small class="text-muted">Tindakan ini tidak dapat dibatalkan.</small>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <p class="text-muted mb-0">Menghapus akun akan menghapus seluruh data portfolio secara permanen.</p>
                    <button class="btn btn-outline-danger rounded-4 px-4" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="bi bi-trash-fill me-2"></i>Hapus Akun
                    </button>
                </div>
            </div>

        </div>
    </div>

</div>

@include('components.modal-delete')
@endsection

@push('scripts')
<script>
// ============================================================
// TAB SETTINGS: tampilkan satu panel dalam satu waktu
// ============================================================
(function initSettingsTabs() {
    const navLinks = document.querySelectorAll('#settingsNav .list-group-item');
    const panels = document.querySelectorAll('.tab-panel');

    const showTab = (tabName) => {
        panels.forEach(p => {
            p.classList.toggle('d-none', p.dataset.panel !== tabName);
        });
        navLinks.forEach(link => {
            link.classList.toggle('active', link.dataset.tab === tabName);
        });
        // save active tab
        localStorage.setItem('settings-tab', tabName);
    };

    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            showTab(this.dataset.tab);
        });
    });

    // Buka tab dari URL hash atau localStorage
    const hash = window.location.hash.replace('#', '');
    const initial = ['profile','password','appearance','notification','export','danger'].includes(hash)
        ? hash
        : (localStorage.getItem('settings-tab') || 'profile');
    showTab(initial);
})();

// ============================================================
// THEME (dark mode) - sinkronkan dengan app.js
// ============================================================
(function syncTheme() {
    const themeSwitch = document.getElementById('themeSwitch');
    if (themeSwitch) {
        themeSwitch.checked = document.body.classList.contains('dark-mode');
    }
})();

// ============================================================
// ANIMASI
// ============================================================
const animSwitch = document.getElementById('animSwitch');
if (localStorage.getItem('animation') === 'off') {
    animSwitch.checked = false;
    document.body.classList.add('no-anim');
}
animSwitch.addEventListener('change', function() {
    document.body.classList.toggle('no-anim', !this.checked);
    localStorage.setItem('animation', this.checked ? 'on' : 'off');
});

// ============================================================
// PREVIEW FOTO sebelum upload
// ============================================================
const photoInput = document.getElementById('photoInput');
const avatar = document.getElementById('settingsAvatar');
if (photoInput) {
    photoInput.addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(ev) {
                avatar.src = ev.target.result;
            };
            reader.readAsDataURL(e.target.files[0]);
        }
    });
}

// ============================================================
// THEME PORTFOLIO OPTION - tampilkan pilihan terpilih
// ============================================================
document.querySelectorAll('.theme-option').forEach(option => {
    option.addEventListener('click', function() {
        document.querySelectorAll('.theme-option').forEach(o => o.classList.remove('selected'));
        this.classList.add('selected');
        this.querySelector('input[type="radio"]').checked = true;
    });
});

// ============================================================
// SOCIAL LINKS - tambah / hapus baris
// ============================================================
const socialContainer = document.getElementById('socialLinksContainer');
let socialIndex = socialContainer.querySelectorAll('.social-link-row').length;

document.getElementById('addSocialLink')?.addEventListener('click', function() {
    const row = document.createElement('div');
    row.className = 'row g-2 mb-2 social-link-row';
    const platforms = ['github','linkedin','instagram','twitter','youtube','website'];
    const labels = {github:'GitHub',linkedin:'LinkedIn',instagram:'Instagram',twitter:'Twitter',youtube:'YouTube',website:'Website'};
    let options = '';
    platforms.forEach(p => { options += `<option value="${p}">${labels[p]}</option>`; });
    row.innerHTML = `
        <div class="col-4"><select name="social_links[${socialIndex}][platform]" class="form-select">${options}</select></div>
        <div class="col-7"><input type="url" name="social_links[${socialIndex}][url]" class="form-control" placeholder="https://..."></div>
        <div class="col-1"><button type="button" class="btn btn-outline-danger btn-sm remove-social"><i class="bi bi-x"></i></button></div>`;
    socialContainer.appendChild(row);
    socialIndex++;
    bindRemoveSocial();
});

function bindRemoveSocial() {
    document.querySelectorAll('.remove-social').forEach(btn => {
        btn.onclick = function() {
            this.closest('.social-link-row').remove();
        };
    });
}
bindRemoveSocial();
</script>
@endpush
