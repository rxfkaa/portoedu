<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class PortfolioController extends Controller
{
    public function show($username)
    {
        // New accounts use a unique username. The name fallback keeps links
        // created before the username column was introduced working.
        $user = User::where('username', $username)
            ->orWhere(function ($query) use ($username) {
                $query->whereNull('username')->where('name', $username);
            })
            ->firstOrFail();
        $student = $user->student;

        if (!$student) {
            abort(404, 'Portfolio belum tersedia.');
        }

        // Visibility: hanya tampil jika public ATAU pemilik yang mengakses
        $setting = $student->portfolioSetting;
        $isPrivate = $setting && $setting->is_public === false;
        if ($isPrivate && (!Auth::check() || Auth::id() !== $user->id)) {
            abort(403, 'Portfolio ini tidak dapat diakses publik.');
        }

        // Portfolio publik hanya boleh memuat item yang sudah layak tampil.
        $achievements = $student->achievements()->where('status', 'verified')->latest()->get();
        $projects = $student->projects()->where('status', 'published')->latest()->get();
        $certificates = $student->certificates()->where('status', 'verified')->latest()->get();
        $organizations = $student->organizations()->latest()->get();
        $skills = $student->skills()->get();
        $internships = $student->internships()->latest()->get();
        $galleries = $student->galleries()->latest()->get();
        $portfolioSetting = $student->portfolioSetting;
        $socialLinks = $student->socialLinks()->get();

        return view('portofolio.show', compact(
            'user',
            'student',
            'achievements',
            'projects',
            'certificates',
            'organizations',
            'skills',
            'internships',
            'galleries',
            'portfolioSetting',
            'socialLinks'
        ));
    }

    public function showByStudent(Student $student)
    {
        $user = $student->user;
        $achievements = $student->achievements()->where('status', 'verified')->latest()->get();
        $projects = $student->projects()->where('status', 'published')->latest()->get();
        $certificates = $student->certificates()->where('status', 'verified')->latest()->get();
        $organizations = $student->organizations()->latest()->get();
        $skills = $student->skills()->get();
        $internships = $student->internships()->latest()->get();
        $galleries = $student->galleries()->latest()->get();
        $portfolioSetting = $student->portfolioSetting;
        $socialLinks = $student->socialLinks()->get();

        return view('portofolio.show', compact(
            'user',
            'student',
            'achievements',
            'projects',
            'certificates',
            'organizations',
            'skills',
            'internships',
            'galleries',
            'portfolioSetting',
            'socialLinks'
        ));
    }
}
