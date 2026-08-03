<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Achievement;
use App\Models\Project;
use App\Models\Certificate;
use App\Models\Organization;
use App\Models\Skill;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Traits\LogsActivity;

class PortfolioExportController extends Controller
{
    use LogsActivity;

    public function exportPdf()
    {
        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
            return back()->with('error', 'Lengkapi profil siswa terlebih dahulu.');
        }

        $achievements = $student->achievements()->where('status', 'verified')->latest()->get();
        $projects = $student->projects()->latest()->get();
        $certificates = $student->certificates()->where('status', 'verified')->latest()->get();
        $organizations = $student->organizations()->latest()->get();
        $skills = $student->skills()->latest()->get();

        $pdf = Pdf::loadView('portofolio.pdf', compact(
            'user',
            'student',
            'achievements',
            'projects',
            'certificates',
            'organizations',
            'skills'
        ));

        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions([
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
        ]);

        $this->logActivity('Mengekspor portofolio PDF');

        return $pdf->download('portofolio-' . $user->name . '.pdf');
    }

    public function exportStudentPdf(Student $student)
    {
        $user = $student->user;

        $achievements = $student->achievements()->where('status', 'verified')->latest()->get();
        $projects = $student->projects()->latest()->get();
        $certificates = $student->certificates()->where('status', 'verified')->latest()->get();
        $organizations = $student->organizations()->latest()->get();
        $skills = $student->skills()->latest()->get();

        $pdf = Pdf::loadView('portofolio.pdf', compact(
            'user',
            'student',
            'achievements',
            'projects',
            'certificates',
            'organizations',
            'skills'
        ));

        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions([
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
        ]);

        return $pdf->download('portofolio-' . $user->name . '.pdf');
    }
}
