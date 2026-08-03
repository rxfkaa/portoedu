<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Traits\LogsActivity;

class CertificateController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $student = Auth::user()->student;

        if (!$student) {
            return redirect()->route('profile')->with('error', 'Lengkapi profil siswa terlebih dahulu.');
        }

        $certificates = Certificate::where('student_id', $student->id)
            ->latest()
            ->paginate(10);

        return view('certificates.index', compact('certificates'));
    }

    public function create()
    {
        return view('certificates.create');
    }

    public function store(Request $request)
    {
        $student = Auth::user()->student;
        if (!$student) {
            return redirect()->route('profile')->with('error', 'Lengkapi profil siswa terlebih dahulu.');
        }

        $data = $request->validate([
            'title' => 'required|max:255',
            'category' => 'nullable',
            'issuer' => 'required|max:255',
            'issued_at' => 'required|date',
            'certificate_number' => 'nullable|max:255',
            'image' => 'nullable|image|max:2048'
        ]);

        $data['student_id'] = $student->id;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('certificates', 'public');
        }

        Certificate::create($data);

        $this->logWithNotification(
            'Menambahkan sertifikat: ' . $data['title'],
            'Sertifikat Baru',
            'Sertifikat "' . $data['title'] . '" berhasil ditambahkan.'
        );

        return redirect()
            ->route('certificates.index')
            ->with('success', 'Sertifikat berhasil ditambahkan.');
    }

    public function show(Certificate $certificate)
    {
        $student = Auth::user()->student;
        abort_if($certificate->student_id !== $student?->id, 403);

        return view('certificates.show', compact('certificate'));
    }

    public function edit(Certificate $certificate)
    {
        $student = Auth::user()->student;
        abort_if($certificate->student_id !== $student?->id, 403);

        return view('certificates.edit', compact('certificate'));
    }

    public function update(Request $request, Certificate $certificate)
    {
        $student = Auth::user()->student;
        abort_if($certificate->student_id !== $student?->id, 403);

        $data = $request->validate([
            'title' => 'required',
            'category' => 'nullable',
            'issuer' => 'required',
            'issued_at' => 'required|date',
            'certificate_number' => 'nullable',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            if ($certificate->image) {
                Storage::disk('public')->delete($certificate->image);
            }
            $data['image'] = $request->file('image')->store('certificates', 'public');
        }

        $certificate->update($data);

        $this->logActivity('Memperbarui sertifikat: ' . $data['title']);

        return redirect()
            ->route('certificates.index')
            ->with('success', 'Sertifikat berhasil diperbarui.');
    }

    public function destroy(Certificate $certificate)
    {
        $student = Auth::user()->student;
        abort_if($certificate->student_id !== $student?->id, 403);

        $title = $certificate->title;

        if ($certificate->image) {
            Storage::disk('public')->delete($certificate->image);
        }

        $certificate->delete();

        $this->logActivity('Menghapus sertifikat: ' . $title);

        return back()
            ->with('success', 'Sertifikat berhasil dihapus.');
    }
}
