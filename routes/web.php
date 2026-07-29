<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\TeacherController;

/*
|--------------------------------------------------------------------------
| Landing Page
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('landing.index');
})->name('landing');

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    if (Auth::user()?->isTeacher() || Auth::user()?->isAdmin()) return redirect()->route('teacher.dashboard');
    return view('dashboard.index');
})->middleware('auth')->name('dashboard');

/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/

Route::get('/profile', function () {
    return view('profile.index');
})->middleware('auth')->name('profile');

/*
|--------------------------------------------------------------------------
| Achievement
|--------------------------------------------------------------------------
*/

Route::get('/achievements', function () {
    return view('achievements.index');
})->middleware('auth')->name('achievements.index');

Route::get('/achievements/create', function () {
    return view('achievements.create');
})->middleware('auth')->name('achievements.create');

Route::middleware('auth')->group(function () {
    Route::view('/projects', 'projects.index')->name('projects.index');
    Route::view('/organizations', 'organizations.index')->name('organizations.index');
    Route::view('/gallery', 'gallery.index')->name('gallery.index');
    Route::view('/statistics', 'statistics.index')->name('statistics.index');
    Route::view('/qr-code', 'qr-code.index')->name('qr-code.index');
    Route::view('/settings', 'settings.index')->name('settings.index');
    Route::view('/certificates', 'certificates.index')->name('certificates.index');

    Route::prefix('teacher')->name('teacher.')->group(function () {
        Route::get('/dashboard', [TeacherController::class, 'dashboard'])->name('dashboard');
        Route::get('/verifications', [TeacherController::class, 'verifications'])->name('verifications');
        Route::patch('/verifications/{type}/{id}', [TeacherController::class, 'verify'])->name('verify');
        Route::get('/projects', [TeacherController::class, 'projects'])->name('projects');
        Route::post('/projects/{project}/comments', [TeacherController::class, 'comment'])->name('projects.comment');
    });
});

/*
|--------------------------------------------------------------------------
| Login (sementara)
|--------------------------------------------------------------------------
*/

Route::get('/login', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (! Auth::attempt($credentials, $request->boolean('remember'))) {
        return back()
            ->withErrors(['email' => 'Email atau password tidak sesuai.'])
            ->onlyInput('email');
    }

    $request->session()->regenerate();

    return redirect()->intended(route('dashboard'));
})->name('login.store');

Route::get('/register', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return view('auth.register');
})->name('register');

Route::post('/register', function (Request $request) {
    $data = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255', 'unique:users,email'],
        'password' => ['required', 'confirmed', 'min:8'],
    ]);

    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
    ]);

    Auth::login($user);
    $request->session()->regenerate();

    return redirect()->route('dashboard');
})->name('register.store');

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

Route::post('/logout', function (Request $request) {

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect()->route('landing');

})->name('logout');
