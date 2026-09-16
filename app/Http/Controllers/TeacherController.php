<?php
namespace App\Http\Controllers;

use App\Models\{Achievement, Certificate, Comment, Project, Notification};
use App\Traits\LogsActivity;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    use LogsActivity;

    private function teacher(Request $request)
    {
        abort_unless($request->user()?->isTeacher(), 403, 'Halaman ini khusus guru.');
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

    public function projects(Request $request)
    {
        $this->teacher($request);

        $projects = Project::with([
            'student.user',
            'comments.teacher',
        ])->latest()->paginate(12);

        return view('teacher.projects', compact('projects'));
    }

    public function verify(Request $request, string $type, int $id)
    {
        $teacher = $this->teacher($request);
        abort_unless(in_array($type, ['achievement', 'certificate'], true), 404);
        $model = $type === 'achievement' ? Achievement::findOrFail($id) : Certificate::findOrFail($id);
        $data = $request->validate(['status' => 'required|in:verified,rejected']);

        $model->update(['status' => $data['status'], 'verified_by' => $teacher->id ?? null, 'verified_at' => now()]);

        $statusLabel = $data['status'] === 'verified' ? 'diverifikasi' : 'ditolak';

        // Notify student
        if ($model->student && $model->student->user) {
            $title = $type === 'achievement' ? 'Prestasi' : 'Sertifikat';
            Notification::create([
                'user_id' => $model->student->user->id,
                'title' => $title . ' ' . $statusLabel,
                'message' => $title . ' "' . $model->title . '" telah ' . $statusLabel . ' oleh guru.',
            ]);
        }

        $this->logActivity($type === 'achievement' ? 'Memverifikasi prestasi: ' . $model->title : 'Memverifikasi sertifikat: ' . $model->title);

        return back()->with('success', 'Data berhasil ' . $statusLabel . '.');
    }

public function statistics(Request $request)
    {
        $this->teacher($request);

        // Validasi dan filter jurusan
        $departmentId = $request->department_id;
        $classId = $request->class_id;

        // Data per kelas (jumlah prestasi + sertifikat)
        $classData = \App\Models\SchoolClass::query()
            ->with('department')
            ->withCount([
                'students as achievement_count' => function ($q) {
                    $q->whereHas('achievements');
                },
                'students as certificate_count' => function ($q) {
                    $q->whereHas('certificates');
                },
            ])
            ->when($departmentId, fn ($q) => $q->where('department_id', $departmentId))
            ->orderByDesc('achievement_count')
            ->get();

        $departments = \App\Models\Department::orderBy('name')->get();

        // Ranking siswa berdasarkan jumlah prestasi
        $ranking = \App\Models\Student::query()
            ->with('user')
            ->withCount('achievements')
            ->withCount('projects')
            ->withCount('certificates')
            ->when($classId, fn ($q) => $q->where('class_id', $classId))
            ->orderByDesc('achievements_count')
            ->take(20)
            ->get();

        return view('teacher.statistics', compact('classData', 'departments', 'ranking', 'departmentId', 'classId'));
    }

    public function comment(Request $request, Project $project)
    {
        $teacher = $this->teacher($request);
        $data = $request->validate(['comment' => 'required|string|max:2000']);

        Comment::create(['teacher_id' => $teacher->id, 'project_id' => $project->id, 'comment' => $data['comment']]);

        // Notify student
        if ($project->student && $project->student->user) {
            Notification::create([
                'user_id' => $project->student->user->id,
                'title' => 'Komentar Baru pada Project',
                'message' => 'Guru memberikan masukan pada project "' . $project->title . '": ' . $data['comment'],
            ]);
        }

        $this->logActivity('Memberikan komentar pada project: ' . $project->title);

        return back()->with('success', 'Masukan berhasil dikirim ke siswa.');
    }
}
