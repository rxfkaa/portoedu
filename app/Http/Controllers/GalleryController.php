<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Traits\LogsActivity;

class GalleryController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $student = Auth::user()->student;

        if (!$student) {
            return redirect()->route('profile')->with('error', 'Lengkapi profil siswa terlebih dahulu.');
        }

        $galleries = Gallery::where('student_id', $student->id)
            ->latest()
            ->paginate(12);

        return view('gallery.index', compact('galleries'));
    }

    public function create()
    {
        return view('gallery.create');
    }

    public function store(Request $request)
    {
        $student = Auth::user()->student;
        if (!$student) {
            return redirect()->route('profile')->with('error', 'Lengkapi profil siswa terlebih dahulu.');
        }

        $data = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'image' => 'required|image|max:2048'
        ]);

        $data['student_id'] = $student->id;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('gallery', 'public');
        }

        Gallery::create($data);

        $this->logWithNotification(
            'Mengunggah foto galeri: ' . $data['title'],
            'Galeri Baru',
            'Foto "' . $data['title'] . '" berhasil diunggah.'
        );

        return redirect()
            ->route('gallery.index')
            ->with('success', 'Foto berhasil diupload.');
    }

    public function show(Gallery $gallery)
    {
        $student = Auth::user()->student;
        abort_if($gallery->student_id !== $student?->id, 403);

        return view('gallery.show', compact('gallery'));
    }

    public function edit(Gallery $gallery)
    {
        $student = Auth::user()->student;
        abort_if($gallery->student_id !== $student?->id, 403);

        return view('gallery.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $student = Auth::user()->student;
        abort_if($gallery->student_id !== $student?->id, 403);

        $data = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            if ($gallery->image) {
                Storage::disk('public')->delete($gallery->image);
            }
            $data['image'] = $request->file('image')->store('gallery', 'public');
        }

        $gallery->update($data);

        $this->logActivity('Memperbarui galeri: ' . $data['title']);

        return redirect()->route('gallery.index')
            ->with('success', 'Gallery berhasil diupdate.');
    }

    public function destroy(Gallery $gallery)
    {
        $student = Auth::user()->student;
        abort_if($gallery->student_id !== $student?->id, 403);

        $title = $gallery->title;

        if ($gallery->image) {
            Storage::disk('public')->delete($gallery->image);
        }

$gallery->delete();

        $this->logActivity('Menghapus galeri: ' . $title);

        return redirect()->route('gallery.index')
            ->with('success', 'Gallery berhasil dihapus.');
    }
}


