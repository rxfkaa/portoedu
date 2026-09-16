<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\LogsActivity;

class OrganizationController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $student = Auth::user()->student;

        if (!$student) {
            return redirect()->route('profile')->with('error', 'Lengkapi profil siswa terlebih dahulu.');
        }

        $organizations = Organization::where('student_id', $student->id)
            ->latest()
            ->paginate(10);

        return view('organizations.index', compact('organizations'));
    }

    public function create()
    {
        return view('organizations.create');
    }

    public function store(Request $request)
    {
        $student = Auth::user()->student;
        if (!$student) {
            return redirect()->route('profile')->with('error', 'Lengkapi profil siswa terlebih dahulu.');
        }

        $data = $request->validate([
            'organization_name' => 'required|max:255',
            'position' => 'required|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable'
        ]);

        $data['student_id'] = $student->id;
        $data['name'] = $data['organization_name'];

        Organization::create($data);

        $this->logWithNotification(
            'Menambahkan organisasi: ' . $data['organization_name'],
            'Organisasi Baru',
            'Organisasi "' . $data['organization_name'] . '" berhasil ditambahkan.'
        );

        return redirect()
            ->route('organizations.index')
            ->with('success', 'Organisasi berhasil ditambahkan.');
    }

    public function show(Organization $organization)
    {
        $student = Auth::user()->student;
        abort_if($organization->student_id !== $student?->id, 403);

        return view('organizations.show', compact('organization'));
    }

    public function edit(Organization $organization)
    {
        $student = Auth::user()->student;
        abort_if($organization->student_id !== $student?->id, 403);

        return view('organizations.edit', compact('organization'));
    }

    public function update(Request $request, Organization $organization)
    {
        $student = Auth::user()->student;
        abort_if($organization->student_id !== $student?->id, 403);

        $data = $request->validate([
            'organization_name' => 'required|max:255',
            'position' => 'required|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable'
        ]);

        $data['name'] = $data['organization_name'];

        $organization->update($data);

        $this->logActivity('Memperbarui organisasi: ' . $data['organization_name']);

        return redirect()
            ->route('organizations.index')
            ->with('success', 'Organisasi berhasil diperbarui.');
    }

    public function destroy(Organization $organization)
    {
        $student = Auth::user()->student;
        abort_if($organization->student_id !== $student?->id, 403);

        $name = $organization->organization_name ?? $organization->name;
        $organization->delete();

        $this->logActivity('Menghapus organisasi: ' . $name);

        return redirect()
            ->route('organizations.index')
            ->with('success', 'Organisasi berhasil dihapus.');
    }
}
