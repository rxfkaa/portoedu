<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;

class PortfolioController extends Controller
{
    public function show($username)
    {
        $user = User::where('name', $username)->firstOrFail();
        $student = $user->student;

        if (!$student) {
            abort(404, 'Portfolio belum tersedia.');
        }

        $achievements = $student->achievements()->latest()->get();
        $projects = $student->projects()->latest()->get();
        $certificates = $student->certificates()->latest()->get();
        $organizations = $student->organizations()->latest()->get();

        return view('portofolio.show', compact(
            'user',
            'student',
            'achievements',
            'projects',
            'certificates',
            'organizations'
        ));
    }

    public function showByStudent(Student $student)
    {
        $user = $student->user;
        $achievements = $student->achievements()->latest()->get();
        $projects = $student->projects()->latest()->get();
        $certificates = $student->certificates()->latest()->get();
        $organizations = $student->organizations()->latest()->get();

        return view('portofolio.show', compact(
            'user',
            'student',
            'achievements',
            'projects',
            'certificates',
            'organizations'
        ));
    }
}
