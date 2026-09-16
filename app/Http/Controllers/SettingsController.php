<?php

namespace App\Http\Controllers;

use App\Models\PortfolioSetting;
use App\Models\SocialLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $student = $user->student;
        $portfolioSetting = $student?->portfolioSetting;
        $socialLinks = $student?->socialLinks()->get() ?? collect();

        return view('settings.index', compact('user', 'student', 'portfolioSetting', 'socialLinks'));
    }

    public function updateAppearance(Request $request)
    {
        $student = Auth::user()->student;

        if (!$student) {
            return back()->with('error', 'Data siswa tidak ditemukan.');
        }

        $data = $request->validate([
            'theme' => 'nullable|in:indigo,emerald,rose,amber,slate',
            'is_public' => 'nullable|boolean',
            'social_links' => 'nullable|array|max:10',
            'social_links.*.platform' => 'nullable|in:github,linkedin,instagram,twitter,youtube,website',
            'social_links.*.url' => 'nullable|url|max:2048',
        ]);

        $theme = $data['theme'] ?? 'indigo';
        $isPublic = $request->boolean('is_public');

        // Simpan / update settings portfolio
        PortfolioSetting::updateOrCreate(
            ['student_id' => $student->id],
            [
                'theme' => $theme,
                'is_public' => $isPublic,
            ]
        );

        // Simpan social links
        SocialLink::where('student_id', $student->id)->delete();
        $links = $data['social_links'] ?? [];
        foreach ($links as $link) {
            if (!empty($link['platform']) && !empty($link['url'])) {
                SocialLink::create([
                    'student_id' => $student->id,
                    'platform' => $link['platform'],
                    'url' => $link['url'],
                ]);
            }
        }

        return back()->with('success', 'Pengaturan tampilan berhasil disimpan.');
    }

    public function exportJson()
    {
        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
            return back()->with('error', 'Data siswa tidak ditemukan.');
        }

        $data = [
            'user' => $user->only(['name', 'email']),
            'student' => $student->toArray(),
            'achievements' => $student->achievements->toArray(),
            'certificates' => $student->certificates->toArray(),
            'projects' => $student->projects->toArray(),
            'organizations' => $student->organizations->toArray(),
            'skills' => $student->skills->toArray(),
            'internships' => $student->internships->toArray(),
            'galleries' => $student->galleries->toArray(),
            'social_links' => $student->socialLinks->toArray(),
        ];

        $filename = 'portfolio-' . str($user->name)->slug() . '.json';

        return response()->streamDownload(function () use ($data) {
            echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }, $filename, [
            'Content-Type' => 'application/json',
        ]);
    }
}
