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

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->isTeacher()) {
            return redirect()->route('teacher.dashboard');
        }

        abort_unless($user->isStudent(), 403, 'Peran akun tidak valid.');

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

        // Badge & Level (Gamification)
        $score = $achievementCount * 3 + $certificateCount * 2 + $projectCount;

        $badges = [
            ['min' => 0,  'level' => 'Pemula',      'icon' => '🌱', 'color' => 'secondary'],
            ['min' => 10, 'level' => 'Bronze',      'icon' => '🥉', 'color' => 'brown'],
            ['min' => 25, 'level' => 'Silver',      'icon' => '🥈', 'color' => 'silver'],
            ['min' => 50, 'level' => 'Gold',        'icon' => '🥇', 'color' => 'gold'],
            ['min' => 80, 'level' => 'Platinum',    'icon' => '💎', 'color' => 'platinum'],
            ['min' => 120,'level' => 'Master',      'icon' => '🏆', 'color' => 'master'],
        ];

        $currentBadge = $badges[0];
        foreach ($badges as $b) {
            if ($score >= $b['min']) {
                $currentBadge = $b;
            }
        }

        // Badge berikutnya
        $nextBadge = null;
        foreach ($badges as $i => $b) {
            if ($currentBadge === $b) {
                $nextBadge = $badges[$i + 1] ?? null;
                break;
            }
        }
        $nextProgress = 100;
        if ($nextBadge) {
            $span = $nextBadge['min'] - $currentBadge['min'];
            $nextProgress = $span > 0 ? min(100, round((($score - $currentBadge['min']) / $span) * 100)) : 100;
        }

        // Monthly chart data (achievements + projects + certificates per month)
        $monthlyData = [];
        for ($i = 1; $i <= 12; $i++) {
            $count = 0;
            if ($student) {
                $count += Achievement::where('student_id', $student->id)
                    ->whereYear('created_at', now()->year)->whereMonth('created_at', $i)->count();
                $count += Project::where('student_id', $student->id)
                    ->whereYear('created_at', now()->year)->whereMonth('created_at', $i)->count();
                $count += Certificate::where('student_id', $student->id)
                    ->whereYear('created_at', now()->year)->whereMonth('created_at', $i)->count();
            }
            $monthlyData[] = $count;
        }
        $monthlyDataStr = implode(',', $monthlyData);

return view('dashboard.index', compact(
            'achievementCount',
            'projectCount',
            'certificateCount',
            'organizationCount',
            'recentAchievements',
            'greeting',
            'progress',
            'monthlyDataStr',
            'score',
            'currentBadge',
            'nextBadge',
            'nextProgress'
        ));
    }
}
