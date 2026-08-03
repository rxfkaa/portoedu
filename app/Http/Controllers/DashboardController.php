<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Project;
use App\Models\Certificate;
use App\Models\Organization;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $student = $user->student;

        $achievementCount = 0;
        $projectCount = 0;
        $certificateCount = 0;
        $organizationCount = 0;
        $recentAchievements = collect();

        if ($student) {
            $achievementCount = Achievement::where('student_id', $student->id)->count();
            $projectCount = Project::where('student_id', $student->id)->count();
            $certificateCount = Certificate::where('student_id', $student->id)->count();
            $organizationCount = Organization::where('student_id', $student->id)->count();

            $recentAchievements = Achievement::where('student_id', $student->id)
                ->latest()
                ->take(5)
                ->get();
        }

        // Greeting
        $hour = now()->hour;

        if ($hour < 11) {
            $greeting = "☀️ Selamat Pagi";
        } elseif ($hour < 15) {
            $greeting = "🌤 Selamat Siang";
        } elseif ($hour < 18) {
            $greeting = "🌇 Selamat Sore";
        } else {
            $greeting = "🌙 Selamat Malam";
        }

        // Progress
        $totalPortfolio = $achievementCount + $projectCount + $certificateCount + $organizationCount;
        $progress = min(($totalPortfolio / 40) * 100, 100);

        return view('dashboard.index', compact(
            'achievementCount',
            'projectCount',
            'certificateCount',
            'organizationCount',
            'recentAchievements',
            'greeting',
            'progress'
        ));
    }
}
