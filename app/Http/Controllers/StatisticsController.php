<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Certificate;
use App\Models\Organization;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class StatisticsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
            return view('statistics.index', [
                'achievementCount' => 0,
                'certificateCount' => 0,
                'projectCount' => 0,
                'organizationCount' => 0,
                'monthlyData' => '0,0,0,0,0,0,0,0,0,0,0,0',
            ]);
        }

        $achievementCount = Achievement::where('student_id', $student->id)->count();
        $certificateCount = Certificate::where('student_id', $student->id)->count();
        $projectCount = Project::where('student_id', $student->id)->count();
        $organizationCount = Organization::where('student_id', $student->id)->count();

        // Monthly activity data
        $monthlyData = [];
        for ($i = 1; $i <= 12; $i++) {
            $count = Achievement::where('student_id', $student->id)
                ->whereMonth('created_at', $i)
                ->whereYear('created_at', now()->year)
                ->count();
            $monthlyData[] = $count;
        }
        $monthlyDataStr = implode(',', $monthlyData);

        return view('statistics.index', compact(
            'achievementCount',
            'certificateCount',
            'projectCount',
            'organizationCount',
            'monthlyDataStr'
        ));
    }
}
