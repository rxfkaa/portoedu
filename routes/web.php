<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\SchoolClass;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\InternshipController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\PortfolioExportController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\CertificateVerificationController;
use App\Http\Controllers\StudentDirectoryController;
use App\Http\Controllers\ForgotPasswordController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('landing.index');
})->name('landing');

/*
|--------------------------------------------------------------------------
| Public Directory Routes
|--------------------------------------------------------------------------
*/

Route::get('/students', [StudentDirectoryController::class, 'index'])
    ->name('students.index');

// Portfolio bersifat publik apabila pemilik mengaktifkannya. Pemeriksaan
// visibilitas (publik/pribadi) dilakukan oleh PortfolioController.
Route::get('/portfolio/{username}', [PortfolioController::class, 'show'])->name('portfolio.show');

/*
|--------------------------------------------------------------------------
| Language Switch
|--------------------------------------------------------------------------
*/

Route::get('/locale/{locale}', function ($locale) {
    if (in_array($locale, ['id', 'en'])) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return back();
})->name('locale');

/*
|--------------------------------------------------------------------------
| Public Verification Routes
|--------------------------------------------------------------------------
*/

Route::prefix('verify')->name('verify.')->group(function () {

    Route::get('/certificate/{id}', [CertificateVerificationController::class, 'show'])
        ->name('certificate');

    Route::get('/lookup', [CertificateVerificationController::class, 'lookup'])
        ->name('lookup');

    Route::get('/', function () {
        return redirect()->route('landing');
    })->name('index');
});

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', function (Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
        }

        if (!Auth::user()->isActive()) {
            $message = Auth::user()->status === 'rejected'
                ? 'Pendaftaran kamu belum disetujui. Alasan: ' . (Auth::user()->rejection_reason ?: 'Silakan hubungi admin.')
                : 'Akun kamu masih menunggu persetujuan admin.';
            Auth::logout();
            return back()->withErrors(['email' => $message])->onlyInput('email');
        }

        $request->session()->regenerate();
        return redirect()->route('dashboard');
    })->middleware('throttle:5,1')->name('login.store');

    Route::get('/register', function () {
        return view('auth.register', ['classes' => SchoolClass::with('department')->orderBy('level')->orderBy('name')->get()]);
    })->name('register');

    Route::post('/register', function (Request $request) {
        $data = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'requested_role' => 'required|in:student,teacher',
            'nis' => 'nullable|required_if:requested_role,student|string|max:50|unique:users,registration_nis|unique:students,nis',
            'class_id' => 'nullable|required_if:requested_role,student|exists:classes,id',
            'nip' => 'nullable|required_if:requested_role,teacher|string|max:50|unique:users,registration_nip|unique:teachers,nip',
            'phone' => 'nullable|required_if:requested_role,teacher|string|max:20',
            'password' => 'required|confirmed|min:8',
        ]);
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            // Kolom password memakai cast `hashed` pada model User. Password
            // asli hanya ada sesaat di request dan langsung di-hash sebelum disimpan.
            'password' => $data['password'],
            'role' => 'pending',
            'status' => 'pending',
            'requested_role' => $data['requested_role'],
            'registration_nis' => $data['requested_role'] === 'student' ? $data['nis'] : null,
            'registration_class_id' => $data['requested_role'] === 'student' ? $data['class_id'] : null,
            'registration_nip' => $data['requested_role'] === 'teacher' ? $data['nip'] : null,
            'registration_phone' => $data['requested_role'] === 'teacher' ? $data['phone'] : null,
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil. Akun kamu akan aktif setelah disetujui admin.');
    })->name('register.store');

    // ===== Forgot / Reset Password =====
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])
        ->name('password.request');

    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])
        ->middleware('throttle:3,1')
        ->name('password.email');

    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])
        ->name('password.reset');

    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])
        ->name('password.store');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware(['auth', 'student'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::get('/portfolio/export/pdf', [PortfolioExportController::class, 'exportPdf'])->name('portfolio.export.pdf');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');

    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');

Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/appearance', [SettingsController::class, 'updateAppearance'])->name('settings.appearance');
    Route::get('/settings/export-json', [SettingsController::class, 'exportJson'])->name('settings.export-json');

    Route::get('/qr-code', [QrCodeController::class, 'index'])->name('qr-code.index');

Route::resource('achievements', AchievementController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('certificates', CertificateController::class);
    Route::resource('organizations', OrganizationController::class);
    Route::resource('gallery', GalleryController::class);
    Route::resource('skills', SkillController::class)->except(['show']);
    Route::resource('internships', InternshipController::class)->except(['show']);

    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('landing');
    })->name('logout');
});

/*
|--------------------------------------------------------------------------
| Teacher Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')
    ->prefix('teacher')
    ->name('teacher.')
    ->group(function () {
        Route::get('/dashboard', [TeacherController::class, 'dashboard'])->name('dashboard');
        Route::get('/verifications', [TeacherController::class, 'verifications'])->name('verifications');
        Route::patch('/verifications/{type}/{id}', [TeacherController::class, 'verify'])->name('verify');
Route::get('/projects', [TeacherController::class, 'projects'])->name('projects');
        Route::post('/projects/{project}/comments', [TeacherController::class, 'comment'])->name('projects.comment');
        Route::get('/statistics', [TeacherController::class, 'statistics'])->name('statistics');
    });

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/activities', [AdminController::class, 'activities'])->name('activities');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('users.show');
        Route::post('/users/{user}/approve', [AdminController::class, 'approveUser'])->name('users.approve');
        Route::post('/users/{user}/reject', [AdminController::class, 'rejectUser'])->name('users.reject');
        Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
        Route::get('/classes', [AdminController::class, 'classes'])->name('classes');
        Route::post('/classes', [AdminController::class, 'storeClass'])->name('classes.store');
        Route::put('/classes/{schoolClass}', [AdminController::class, 'updateClass'])->name('classes.update');
        Route::delete('/classes/{schoolClass}', [AdminController::class, 'destroyClass'])->name('classes.destroy');
        Route::get('/departments', [AdminController::class, 'departments'])->name('departments');
        Route::post('/departments', [AdminController::class, 'storeDepartment'])->name('departments.store');
        Route::put('/departments/{department}', [AdminController::class, 'updateDepartment'])->name('departments.update');
        Route::delete('/departments/{department}', [AdminController::class, 'destroyDepartment'])->name('departments.destroy');
    });
