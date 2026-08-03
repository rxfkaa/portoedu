<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\SchoolClass;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
        return view('admin.dashboard', [
            'totalUsers' => User::count(),
            'totalStudents' => Student::count(),
            'totalTeachers' => Teacher::count(),
            'totalClasses' => SchoolClass::count(),
            'totalDepartments' => Department::count(),
            'recentUsers' => User::latest()->take(5)->get(),
        ]);
    }

    public function users()
    {
        $users = User::with(['student', 'teacher'])->latest()->paginate(15);
        return view('admin.users', compact('users'));
    }

    public function updateUser(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,teacher,student',
        ]);

        $user->update($data);

        $this->logActivity('Memperbarui user: ' . $user->name . ' (role: ' . $data['role'] . ')');

        return back()->with('success', 'User berhasil diperbarui.');
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
