<?php
namespace App\Http\Controllers;

use App\Models\{Achievement, Certificate, Comment, Project};
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    private function teacher(Request $request)
    {
        abort_unless($request->user()?->isTeacher() || $request->user()?->isAdmin(), 403, 'Halaman ini khusus guru dan admin.');
        return $request->user()->teacher;
    }

    public function dashboard(Request $request)
    {
        $this->teacher($request);
        return view('teacher.dashboard', [
            'pendingAchievements' => Achievement::where('status', 'pending')->with('student.user')->latest()->take(5)->get(),
            'pendingCertificates' => Certificate::where('status', 'pending')->with('student.user')->latest()->take(5)->get(),
            'totalStudents' => \App\Models\Student::count(),
            'verifiedThisMonth' => Achievement::where('status', 'verified')->whereMonth('verified_at', now()->month)->count() + Certificate::where('status', 'verified')->whereMonth('verified_at', now()->month)->count(),
        ]);
    }
    public function verifications(Request $request)
    {
        $this->teacher($request);
        return view('teacher.verifications', [
            'achievements' => Achievement::with('student.user')->latest()->paginate(10, ['*'], 'prestasi'),
            'certificates' => Certificate::with('student.user')->latest()->paginate(10, ['*'], 'sertifikat'),
        ]);
    }
    public function verify(Request $request, string $type, int $id)
    {
        $teacher = $this->teacher($request);
        $model = $type === 'achievement' ? Achievement::findOrFail($id) : Certificate::findOrFail($id);
        $data = $request->validate(['status' => 'required|in:verified,rejected']);
        $model->update(['status' => $data['status'], 'verified_by' => $teacher?->id, 'verified_at' => now()]);
        return back()->with('success', $data['status'] === 'verified' ? 'Data berhasil diverifikasi.' : 'Data ditolak dan status telah diperbarui.');
    }
    public function projects(Request $request)
    {
        $this->teacher($request);
        return view('teacher.projects', ['projects' => Project::with(['student.user', 'comments.teacher.user'])->latest()->paginate(12)]);
    }
    public function comment(Request $request, Project $project)
    {
        $teacher = $this->teacher($request);
        $data = $request->validate(['comment' => 'required|string|max:2000']);
        Comment::create(['teacher_id' => $teacher->id, 'project_id' => $project->id, 'comment' => $data['comment']]);
        return back()->with('success', 'Masukan berhasil dikirim ke siswa.');
    }
}
