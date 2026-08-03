<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Traits\LogsActivity;

class ProjectController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $student = Auth::user()->student;

        if (!$student) {
            return redirect()->route('profile')->with('error', 'Lengkapi profil siswa terlebih dahulu.');
        }

        $projects = Project::where('student_id', $student->id)
            ->latest()
            ->paginate(10);

        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $student = Auth::user()->student;
        if (!$student) {
            return redirect()->route('profile')->with('error', 'Lengkapi profil siswa terlebih dahulu.');
        }

        $data = $request->validate([
            'title' => 'required|max:255',
            'category' => 'nullable|max:255',
            'description' => 'required',
            'technology' => 'nullable',
            'github' => 'nullable|url',
            'demo' => 'nullable|url',
            'image' => 'nullable|image|max:2048'
        ]);

        $data['student_id'] = $student->id;
        $data['status'] = 'published';
        $data['slug'] = \Illuminate\Support\Str::slug($data['title']).'-'.uniqid();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('projects', 'public');
        }

        Project::create($data);

        $this->logWithNotification(
            'Menambahkan project: ' . $data['title'],
            'Project Baru',
            'Project "' . $data['title'] . '" berhasil dipublikasikan.'
        );

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project berhasil ditambahkan.');
    }

    public function show(Project $project)
    {
        $student = Auth::user()->student;
        abort_if($project->student_id !== $student?->id, 403);

        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $student = Auth::user()->student;
        abort_if($project->student_id !== $student?->id, 403);

        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $student = Auth::user()->student;
        abort_if($project->student_id !== $student?->id, 403);

        $data = $request->validate([
            'title' => 'required',
            'category' => 'nullable|max:255',
            'description' => 'required',
            'technology' => 'nullable',
            'github' => 'nullable|url',
            'demo' => 'nullable|url',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }
            $data['image'] = $request->file('image')->store('projects', 'public');
        }

        if ($request->filled('title') && $request->title !== $project->title) {
            $data['slug'] = \Illuminate\Support\Str::slug($data['title']).'-'.uniqid();
        }

        $project->update($data);

        $this->logActivity('Memperbarui project: ' . $data['title']);

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project berhasil diperbarui.');
    }

    public function destroy(Project $project)
    {
        $student = Auth::user()->student;
        abort_if($project->student_id !== $student?->id, 403);

        $title = $project->title;

        if ($project->image) {
            Storage::disk('public')->delete($project->image);
        }

        $project->delete();

        $this->logActivity('Menghapus project: ' . $title);

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project berhasil dihapus.');
    }
}

