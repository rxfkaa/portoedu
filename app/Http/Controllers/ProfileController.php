<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Certificate;
use App\Models\Project;
use App\Models\Organization;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Traits\LogsActivity;

class ProfileController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $user = Auth::user();
        $student = $user->student;

        $achievementCount = $student ? Achievement::where('student_id', $student->id)->count() : 0;
        $certificateCount = $student ? Certificate::where('student_id', $student->id)->count() : 0;
        $projectCount = $student ? Project::where('student_id', $student->id)->count() : 0;
        $organizationCount = $student ? Organization::where('student_id', $student->id)->count() : 0;

        // Calculate profile progress
        $fields = 0;
        $totalFields = 7;

        if ($student) {
            if ($student->name) $fields++;
            if ($student->phone) $fields++;
            if ($student->birth_place && $student->birth_date) $fields++;
            if ($student->address) $fields++;
            if ($student->photo) $fields++;
            if ($student->bio) $fields++;
            if ($student->class_id) $fields++;
        }

        $profileProgress = $totalFields > 0 ? round(($fields / $totalFields) * 100) : 0;

        return view('profile.index', compact(
            'user',
            'student',
            'achievementCount',
            'certificateCount',
            'projectCount',
            'organizationCount',
            'profileProgress'
        ));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|max:20',
            'birth_place' => 'nullable|max:255',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:L,P',
            'address' => 'nullable',
            'bio' => 'nullable',
            'github' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'website' => 'nullable|url',
            'photo' => 'nullable|image|max:2048'
        ]);

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        // Update or create student profile
        $student = $user->student;
        if (!$student) {
            $student = Student::create([
                'user_id' => $user->id,
                'nis' => 'NIS-' . $user->id,
                'name' => $data['name'],
            ]);
        }

        if ($request->hasFile('photo')) {
            if ($student->photo) {
                Storage::disk('public')->delete($student->photo);
            }
            $data['photo'] = $request->file('photo')->store('profiles', 'public');
        }

        $studentFields = ['phone', 'birth_place', 'birth_date', 'gender', 'address', 'bio', 'github', 'linkedin', 'website', 'photo'];
        $studentData = [];
        foreach ($studentFields as $field) {
            if (array_key_exists($field, $data)) {
                $studentData[$field] = $data[$field];
            }
        }
        $student->update($studentData);

        $this->logWithNotification(
            'Memperbarui profil',
            'Profil Diperbarui',
            'Profil kamu berhasil diperbarui.'
        );

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $data = $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|confirmed|min:8',
        ]);

        Auth::user()->update([
            // User::$casts memastikan password selalu disimpan sebagai hash.
            'password' => $data['password'],
        ]);

        $this->logWithNotification(
            'Mengganti password akun',
            'Password Diubah',
            'Password akun kamu berhasil diubah.'
        );

        return back()->with('success', 'Password berhasil diubah.');
    }
}
