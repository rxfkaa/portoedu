<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Traits\LogsActivity;

class AchievementController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
            return redirect()->route('profile')->with('error', 'Lengkapi profil siswa terlebih dahulu.');
        }

        $achievements = Achievement::where('student_id', $student->id)
            ->latest()
            ->paginate(10);

        return view('achievements.index', compact('achievements'));
    }

    public function create()
    {
        return view('achievements.create');
    }

    public function store(Request $request)
    {
        $student = Auth::user()->student;
        if (!$student) {
            return redirect()->route('profile')->with('error', 'Lengkapi profil siswa terlebih dahulu.');
        }

        $data = $request->validate([
            'title' => 'required|max:255',
            'level' => 'required',
            'category' => 'nullable',
            'organizer' => 'required',
            'date' => 'required|date',
            'description' => 'nullable',
            'image' => 'nullable|image|max:2048'
        ]);

        $data['student_id'] = $student->id;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('achievements', 'public');
        }

        Achievement::create($data);

        $this->logWithNotification(
            'Menambahkan prestasi: ' . $data['title'],
            'Prestasi Baru',
            'Prestasi "' . $data['title'] . '" berhasil ditambahkan ke portfolio.'
        );

        return redirect()
            ->route('achievements.index')
            ->with('success', 'Prestasi berhasil ditambahkan.');
    }

    public function show(Achievement $achievement)
    {
        $student = Auth::user()->student;
        abort_if($achievement->student_id !== $student?->id, 403);

        return view('achievements.show', compact('achievement'));
    }

    public function edit(Achievement $achievement)
    {
        $student = Auth::user()->student;
        abort_if($achievement->student_id !== $student?->id, 403);

        return view('achievements.edit', compact('achievement'));
    }

    public function update(Request $request, Achievement $achievement)
    {
        $student = Auth::user()->student;
        abort_if($achievement->student_id !== $student?->id, 403);

        $data = $request->validate([
            'title' => 'required',
            'level' => 'required',
            'category' => 'nullable',
            'organizer' => 'required',
            'date' => 'required|date',
            'description' => 'nullable',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            if ($achievement->image) {
                Storage::disk('public')->delete($achievement->image);
            }
            $data['image'] = $request->file('image')->store('achievements', 'public');
        }

        $achievement->update($data);

        $this->logActivity('Memperbarui prestasi: ' . $data['title']);

        return redirect()
            ->route('achievements.index')
            ->with('success', 'Prestasi berhasil diperbarui.');
    }

    public function destroy(Achievement $achievement)
    {
        $student = Auth::user()->student;
        abort_if($achievement->student_id !== $student?->id, 403);

        $title = $achievement->title;

        if ($achievement->image) {
            Storage::disk('public')->delete($achievement->image);
        }

        $achievement->delete();

        $this->logActivity('Menghapus prestasi: ' . $title);

        return back()
            ->with('success', 'Prestasi berhasil dihapus.');
    }
}
