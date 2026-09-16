<?php

namespace App\Http\Controllers;

use App\Models\Student;

class StudentDirectoryController extends Controller
{
    /**
     * Direktori publik semua siswa.
     */
    public function index()
    {
        $query = Student::with(['user', 'classRoom.department']);

        // Filter pencarian
        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($u) use ($search) {
                      $u->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter jurusan
        if ($department = request('department')) {
            $query->whereHas('classRoom.department', function ($d) use ($department) {
                $d->where('code', $department);
            });
        }

        $students = $query->withCount('achievements')
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        $departments = \App\Models\Department::orderBy('name')->get();

        return view('students.index', compact('students', 'departments'));
    }
}
