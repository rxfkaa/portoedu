@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="container-fluid">

    @if(session('success'))
        <div class="alert alert-success rounded-4">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger rounded-4">{{ session('error') }}</div>
    @endif

    <!-- Profile Header -->
    <div class="profile-header d-flex justify-content-between align-items-center p-4">
        <div class="profile-left d-flex align-items-center gap-4">
            <img src="{{ $student && $student->photo ? asset('storage/'.$student->photo) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=2563EB&color=fff&size=200' }}"
                 class="profile-avatar" style="width:120px;height:120px;border-radius:50%;object-fit:cover;">
            <div>
                <h2 class="fw-bold mb-1">{{ $user->name }}</h2>
                <p class="text-muted mb-1">
                    @if($student && $student->classRoom)
                        {{ $student->classRoom->level }} {{ $student->classRoom->name }} •
                        {{ $student->classRoom->department->name ?? '' }}
                    @else
                        Student
                    @endif
                </p>
                @if($student && $student->nis)
                    <span class="badge bg-light text-dark me-1">NIS: {{ $student->nis }}</span>
                @endif
                @if($student && $student->nisn)
                    <span class="badge bg-light text-dark">NISN: {{ $student->nisn }}</span>
                @endif
                <div class="mt-2">
                    @if($student?->github)
                        <a href="{{ $student->github }}" target="_blank" class="text-decoration-none me-2 fs-5"><i class="bi bi-github"></i></a>
                    @endif
                    @if($student?->linkedin)
                        <a href="{{ $student->linkedin }}" target="_blank" class="text-decoration-none me-2 fs-5"><i class="bi bi-linkedin"></i></a>
                    @endif
                    @if($student?->website)
                        <a href="{{ $student->website }}" target="_blank" class="text-decoration-none fs-5"><i class="bi bi-globe"></i></a>
                    @endif
                </div>
            </div>
        </div>
        <div>
            <button class="btn btn-primary rounded-4" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                <i class="bi bi-pencil-fill me-1"></i> Edit Profile
            </button>
            <button class="btn btn-outline-secondary rounded-4" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                <i class="bi bi-lock me-1"></i> Password
            </button>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-8">
            <div class="glass-card p-4">
                <h4 class="fw-bold mb-4">Informasi Pribadi</h4>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Email</label>
                        <p class="fw-bold mb-0">{{ $user->email }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">No HP</label>
                        <p class="fw-bold mb-0">{{ $student?->phone ?? '-' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Tempat, Tanggal Lahir</label>
                        <p class="fw-bold mb-0">
                            {{ $student?->birth_place ?? '-' }}{{ $student?->birth_date ? ', '.$student->birth_date->format('d M Y') : '' }}
                        </p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Jenis Kelamin</label>
                        <p class="fw-bold mb-0">{{ $student?->gender === 'L' ? 'Laki-laki' : ($student?->gender === 'P' ? 'Perempuan' : '-') }}</p>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="text-muted small">Alamat</label>
                        <p class="fw-bold mb-0">{{ $student?->address ?? '-' }}</p>
                    </div>
                    @if($student?->bio)
                    <div class="col-12 mb-3">
                        <label class="text-muted small">Bio</label>
                        <p class="fw-bold mb-0">{{ $student->bio }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="glass-card p-4 mb-4">
                <h5 class="fw-bold mb-3">Progress Profile</h5>
                <h2 class="fw-bold text-primary">{{ $profileProgress }}%</h2>
                <div class="custom-progress mt-3">
                    <div class="custom-progress-bar" style="width:{{ $profileProgress }}%"></div>
                </div>
                <p class="text-muted mt-3 small">Lengkapi data profile agar portofoliomu maksimal.</p>
            </div>

            <div class="glass-card p-4">
                <h5 class="fw-bold mb-3">Statistik</h5>
                <div class="mini-stat d-flex justify-content-between py-2 border-bottom">
                    <span><i class="bi bi-trophy-fill text-warning me-2"></i>Prestasi</span>
                    <strong>{{ $achievementCount }}</strong>
                </div>
                <div class="mini-stat d-flex justify-content-between py-2 border-bottom">
                    <span><i class="bi bi-patch-check-fill text-success me-2"></i>Sertifikat</span>
                    <strong>{{ $certificateCount }}</strong>
                </div>
                <div class="mini-stat d-flex justify-content-between py-2 border-bottom">
                    <span><i class="bi bi-kanban-fill text-primary me-2"></i>Project</span>
                    <strong>{{ $projectCount }}</strong>
                </div>
                <div class="mini-stat d-flex justify-content-between py-2">
                    <span><i class="bi bi-people-fill text-danger me-2"></i>Organisasi</span>
                    <strong>{{ $organizationCount }}</strong>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Profile -->
    <div class="modal fade" id="editProfileModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-0">
                    <h5 class="fw-bold">Edit Profile</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">No HP</label>
                                <input type="text" name="phone" class="form-control" value="{{ $student?->phone ?? '' }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Jenis Kelamin</label>
                                <select name="gender" class="form-select">
                                    <option value="">Pilih</option>
                                    <option value="L" {{ $student?->gender === 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ $student?->gender === 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Tempat Lahir</label>
                                <input type="text" name="birth_place" class="form-control" value="{{ $student?->birth_place ?? '' }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Tanggal Lahir</label>
                                <input type="date" name="birth_date" class="form-control" value="{{ $student?->birth_date?->format('Y-m-d') ?? '' }}">
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-semibold">Alamat</label>
                                <textarea name="address" class="form-control" rows="2">{{ $student?->address ?? '' }}</textarea>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-semibold">Bio</label>
                                <textarea name="bio" class="form-control" rows="3">{{ $student?->bio ?? '' }}</textarea>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">GitHub</label>
                                <input type="url" name="github" class="form-control" value="{{ $student?->github ?? '' }}" placeholder="https://github.com/username">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">LinkedIn</label>
                                <input type="url" name="linkedin" class="form-control" value="{{ $student?->linkedin ?? '' }}" placeholder="https://linkedin.com/in/username">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Website</label>
                                <input type="url" name="website" class="form-control" value="{{ $student?->website ?? '' }}" placeholder="https://example.com">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Foto Profile</label>
                                <input type="file" name="photo" class="form-control" accept="image/*">
                            </div>
                        </div>
                        <div class="text-end mt-4">
                            <button type="button" class="btn btn-light rounded-4 px-4 me-2" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary rounded-4 px-5">
                                <i class="bi bi-check-circle-fill me-2"></i>Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Ganti Password -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-0">
                    <h5 class="fw-bold">Ganti Password</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('profile.password') }}" method="POST">
                        @csrf @method('PUT')
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Password Saat Ini</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Password Baru</label>
                            <input type="password" name="password" class="form-control" required min="8">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary rounded-4 px-5">
                                <i class="bi bi-check-circle-fill me-2"></i>Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
