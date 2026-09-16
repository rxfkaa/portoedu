<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\SchoolClass;
use App\Models\Department;
use App\Models\ActivityLog;
use App\Models\Achievement;
use App\Models\Certificate;
use App\Models\Project;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\LogsActivity;

class AdminController extends Controller
{
    use LogsActivity;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            abort_unless($request->user()?->isAdmin(), 403, 'Halaman ini khusus admin.');
            return $next($request);
        });
    }

    public function dashboard()
    {
        $totalStudents = Student::count();
        $totalTeachers = Teacher::count();

        // Statistik portfolio (total data dari siswa)
        $totalAchievements = Achievement::count();
        $totalCertificates = Certificate::count();
        $totalProjects = Project::count();

        // Aktivitas terbaru (tracking siswa & guru)
        $recentActivities = ActivityLog::with('user')
            ->latest()
            ->take(10)
            ->get();

        // Statistik aktivitas per role (7 hari terakhir)
        $studentActivity = ActivityLog::whereHas('user', fn($q) => $q->where('role', 'student'))
            ->whereDate('created_at', '>=', now()->subDays(7))->count();
        $teacherActivity = ActivityLog::whereHas('user', fn($q) => $q->where('role', 'teacher'))
            ->whereDate('created_at', '>=', now()->subDays(7))->count();

        return view('admin.dashboard', [
            'totalUsers' => User::count(),
            'totalStudents' => $totalStudents,
            'totalTeachers' => $totalTeachers,
            'totalClasses' => SchoolClass::count(),
            'totalDepartments' => Department::count(),
            'totalAchievements' => $totalAchievements,
            'totalCertificates' => $totalCertificates,
            'totalProjects' => $totalProjects,
            'recentUsers' => User::latest()->take(5)->get(),
            'recentActivities' => $recentActivities,
            'studentActivity' => $studentActivity,
            'teacherActivity' => $teacherActivity,
        ]);
    }

    public function activities()
    {
        $activities = ActivityLog::with('user')
            ->latest()
            ->paginate(20);

        return view('admin.activities', compact('activities'));
    }

    public function users(Request $request)
    {
        $filters = $request->validate([
            'search' => 'nullable|string|max:255',
            'status' => 'nullable|in:all,pending,active,rejected',
            'role' => 'nullable|in:all,student,teacher,admin',
        ]);

        $users = User::with(['student', 'teacher'])
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where(fn ($q) => $q->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%"));
            })
            ->when(($filters['status'] ?? 'all') !== 'all', fn ($query) => $query->where('status', $filters['status']))
            ->when(($filters['role'] ?? 'all') !== 'all', fn ($query, $role) => $query->where('role', $role))
            ->latest()->paginate(15)->withQueryString();
        $pendingCount = User::where('status', 'pending')->count();

        return view('admin.users', compact('users', 'pendingCount'));
    }

    public function showUser(User $user)
    {
        $user->load(['student.classRoom.department', 'teacher', 'registrationClass.department']);

        return view('admin.user-detail', compact('user'));
    }

    public function approveUser(Request $request, User $user)
    {
        $data = $request->validate([
            'role' => 'required|in:student,teacher',
        ]);

        if ($user->status !== 'pending') {
            return back()->with('error', 'Akun ini sudah diproses.');
        }

        DB::transaction(function () use ($user, $data) {
            $user->update([
                'role' => $data['role'],
                'status' => 'active',
                'requested_role' => null,
                'rejection_reason' => null,
            ]);

            if ($data['role'] === 'student') {
                Student::firstOrCreate(
                    ['user_id' => $user->id],
                    ['nis' => $user->registration_nis, 'class_id' => $user->registration_class_id, 'name' => $user->name]
                );
            } else {
                Teacher::firstOrCreate(
                    ['user_id' => $user->id],
                    ['nip' => $user->registration_nip, 'phone' => $user->registration_phone, 'name' => $user->name]
                );
            }

            Notification::create([
                'user_id' => $user->id,
                'title' => 'Pendaftaran disetujui',
                'message' => 'Akun kamu telah disetujui sebagai ' . ($data['role'] === 'teacher' ? 'Guru' : 'Siswa') . '. Selamat datang di PortoEdu!',
            ]);
        });

        $this->logActivity('Menyetujui akun ' . $user->name . ' sebagai ' . $data['role']);

        return back()->with('success', 'Akun berhasil disetujui sebagai ' . ($data['role'] === 'teacher' ? 'guru' : 'siswa') . '.');
    }

    public function rejectUser(Request $request, User $user)
    {
        $data = $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        if ($user->status !== 'pending') {
            return back()->with('error', 'Hanya pendaftaran yang menunggu yang dapat ditolak.');
        }

        $user->update([
            'status' => 'rejected',
            'rejection_reason' => $data['rejection_reason'],
        ]);

        Notification::create([
            'user_id' => $user->id,
            'title' => 'Pendaftaran ditolak',
            'message' => 'Pendaftaran kamu ditolak. Alasan: ' . $data['rejection_reason'],
        ]);

        $this->logActivity('Menolak pendaftaran ' . $user->name);

        return redirect()->route('admin.users')->with('success', 'Pendaftaran ditolak dan alasannya tersimpan.');
    }

    public function destroyUser(User $user)
    {
        if ($user->isAdmin()) {
            return back()->with('error', 'Tidak bisa menghapus admin.');
        }

        $name = $user->name;
        $user->delete();

        $this->logActivity('Menghapus user: ' . $name);

        return back()->with('success', 'User berhasil dihapus.');
    }

    public function classes()
    {
        $classes = SchoolClass::with('department')->withCount('students')->latest()->paginate(15);
        $departments = Department::all();
        return view('admin.classes', compact('classes', 'departments'));
    }

    public function storeClass(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'level' => 'required|in:X,XI,XII',
            'department_id' => 'required|exists:departments,id',
        ]);

        SchoolClass::create($data);

        $this->logActivity('Menambahkan kelas: ' . $data['level'] . ' ' . $data['name']);

        return back()->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function updateClass(Request $request, SchoolClass $schoolClass)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'level' => 'required|in:X,XI,XII',
            'department_id' => 'required|exists:departments,id',
        ]);

        $schoolClass->update($data);

        $this->logActivity('Memperbarui kelas: ' . $data['level'] . ' ' . $data['name']);

        return back()->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroyClass(SchoolClass $schoolClass)
    {
        if ($schoolClass->students()->count() > 0) {
            return back()->with('error', 'Kelas masih memiliki siswa. Tidak bisa dihapus.');
        }

        $name = $schoolClass->level . ' ' . $schoolClass->name;
        $schoolClass->delete();

        $this->logActivity('Menghapus kelas: ' . $name);

        return back()->with('success', 'Kelas berhasil dihapus.');
    }

    public function departments()
    {
        $departments = Department::withCount('classes')->latest()->paginate(15);
        return view('admin.departments', compact('departments'));
    }

    public function storeDepartment(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'code' => 'required|max:20|unique:departments,code',
        ]);

        Department::create($data);

        $this->logActivity('Menambahkan jurusan: ' . $data['name'] . ' (' . $data['code'] . ')');

        return back()->with('success', 'Jurusan berhasil ditambahkan.');
    }

    public function updateDepartment(Request $request, Department $department)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'code' => 'required|max:20|unique:departments,code,' . $department->id,
        ]);

        $department->update($data);

        $this->logActivity('Memperbarui jurusan: ' . $data['name']);

        return back()->with('success', 'Jurusan berhasil diperbarui.');
    }

    public function destroyDepartment(Department $department)
    {
        if ($department->classes()->count() > 0) {
            return back()->with('error', 'Jurusan masih memiliki kelas. Hapus kelas terlebih dahulu.');
        }

        $name = $department->name;
        $department->delete();

        $this->logActivity('Menghapus jurusan: ' . $name);

        return back()->with('success', 'Jurusan berhasil dihapus.');
    }
}
