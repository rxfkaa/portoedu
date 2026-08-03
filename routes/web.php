<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

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
        $request->session()->regenerate();
        return redirect()->route('dashboard');
    })->name('login.store');

    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

Route::post('/register', function (Request $request) {
        $data = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8'
        ]);
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
        // Auto-create student profile
        \App\Models\Student::create([
            'user_id' => $user->id,
            'nis' => 'NIS-' . $user->id,
            'name' => $data['name'],
        ]);
        Auth::login($user);
        return redirect()->route('dashboard');
    })->name('register.store');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

Route::get('/portfolio/{username}', [PortfolioController::class, 'show'])->name('portfolio.show');
    Route::get('/portfolio/export/pdf', [PortfolioExportController::class, 'exportPdf'])->name('portfolio.export.pdf');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');

    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');

    Route::get('/settings', function () {
        return view('settings.index');
    })->name('settings.index');

    Route::get('/qr-code', [QrCodeController::class, 'index'])->name('qr-code.index');

    Route::resource('achievements', AchievementController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('certificates', CertificateController::class);
    Route::resource('organizations', OrganizationController::class);
    Route::resource('gallery', GalleryController::class);
    Route::resource('skills', SkillController::class);
    Route::resource('internships', InternshipController::class);

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
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
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
