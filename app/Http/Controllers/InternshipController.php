<?php

namespace App\Http\Controllers;

use App\Models\Internship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\LogsActivity;

class InternshipController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $student = Auth::user()->student;
        if (!$student) return redirect()->route('profile')->with('error', 'Lengkapi profil dulu.');

        $internships = Internship::where('student_id', $student->id)->latest()->paginate(10);
        return view('internships.index', compact('internships'));
    }

    public function create()
    {
        return view('internships.create');
    }

    public function store(Request $request)
    {
        $student = Auth::user()->student;
        if (!$student) return redirect()->route('profile')->with('error', 'Lengkapi profil dulu.');

        $data = $request->validate([
            'company' => 'required|max:255',
            'position' => 'required|max:255',
            'address' => 'nullable',
            'started_at' => 'required|date',
            'ended_at' => 'nullable|date|after_or_equal:started_at',
            'description' => 'nullable',
        ]);

        $data['student_id'] = $student->id;
        Internship::create($data);

        $this->logWithNotification(
            'Menambahkan pengalaman PKL: ' . $data['company'] . ' - ' . $data['position'],
            'PKL/Internship Baru',
            'Pengalaman PKL di "' . $data['company'] . '" sebagai ' . $data['position'] . ' berhasil ditambahkan.'
        );

        return redirect()->route('internships.index')->with('success', 'Pengalaman PKL/Internship berhasil ditambahkan.');
    }

    public function edit(Internship $internship)
    {
        $student = Auth::user()->student;
        abort_if($internship->student_id !== $student?->id, 403);
        return view('internships.edit', compact('internship'));
    }

    public function update(Request $request, Internship $internship)
    {
        $student = Auth::user()->student;
        abort_if($internship->student_id !== $student?->id, 403);

        $data = $request->validate([
            'company' => 'required|max:255',
            'position' => 'required|max:255',
            'address' => 'nullable',
            'started_at' => 'required|date',
            'ended_at' => 'nullable|date|after_or_equal:started_at',
            'description' => 'nullable',
        ]);

        $internship->update($data);

        $this->logActivity('Memperbarui data PKL: ' . $data['company']);

        return redirect()->route('internships.index')->with('success', 'Data PKL berhasil diperbarui.');
    }

    public function destroy(Internship $internship)
    {
        $student = Auth::user()->student;
        abort_if($internship->student_id !== $student?->id, 403);

        $company = $internship->company;
        $internship->delete();

        $this->logActivity('Menghapus data PKL: ' . $company);

        return back()->with('success', 'Data PKL berhasil dihapus.');
    }
}
