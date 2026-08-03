<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\LogsActivity;

class SkillController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $student = Auth::user()->student;
        if (!$student) return redirect()->route('profile')->with('error', 'Lengkapi profil dulu.');

        $skills = Skill::where('student_id', $student->id)->latest()->paginate(10);
        return view('skills.index', compact('skills'));
    }

    public function create()
    {
        return view('skills.create');
    }

    public function store(Request $request)
    {
        $student = Auth::user()->student;
        if (!$student) return redirect()->route('profile')->with('error', 'Lengkapi profil dulu.');

        $data = $request->validate([
            'name' => 'required|max:255',
            'level' => 'required|in:Pemula,Menengah,Mahir,Expert',
        ]);

        $data['student_id'] = $student->id;
        Skill::create($data);

        $this->logWithNotification(
            'Menambahkan skill: ' . $data['name'],
            'Skill Baru',
            'Skill "' . $data['name'] . '" berhasil ditambahkan.'
        );

        return redirect()->route('skills.index')->with('success', 'Skill berhasil ditambahkan.');
    }

    public function edit(Skill $skill)
    {
        $student = Auth::user()->student;
        abort_if($skill->student_id !== $student?->id, 403);
        return view('skills.edit', compact('skill'));
    }

    public function update(Request $request, Skill $skill)
    {
        $student = Auth::user()->student;
        abort_if($skill->student_id !== $student?->id, 403);

        $data = $request->validate([
            'name' => 'required|max:255',
            'level' => 'required|in:Pemula,Menengah,Mahir,Expert',
        ]);

        $skill->update($data);

        $this->logActivity('Memperbarui skill: ' . $data['name']);

        return redirect()->route('skills.index')->with('success', 'Skill berhasil diperbarui.');
    }

    public function destroy(Skill $skill)
    {
        $student = Auth::user()->student;
        abort_if($skill->student_id !== $student?->id, 403);

        $name = $skill->name;
        $skill->delete();

        $this->logActivity('Menghapus skill: ' . $name);

        return back()->with('success', 'Skill berhasil dihapus.');
    }
}
