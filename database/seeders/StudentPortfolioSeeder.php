<?php

namespace Database\Seeders;

use App\Models\Achievement;
use App\Models\Certificate;
use App\Models\Internship;
use App\Models\Organization;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class StudentPortfolioSeeder extends Seeder
{
    public function run(): void
    {
        $teacherId = Teacher::query()
            ->whereHas('user', fn ($query) => $query->where('role', 'teacher'))
            ->value('id');

        if (!$teacherId) {
            throw new \RuntimeException('Akun guru diperlukan untuk status verifikasi portofolio.');
        }

        $students = Student::query()->whereHas('classRoom', function ($query) {
            $query->where('level', 'XII')->where('name', 'RPL 2')
                ->whereHas('department', fn ($department) => $department->where('code', 'RPL'));
        })->orderBy('nipd')->get();

        DB::transaction(function () use ($students, $teacherId) {
            foreach ($students as $index => $student) {
                $this->seedAchievements($student, $index, $teacherId);
                $this->seedCertificates($student, $index, $teacherId);
                $this->seedProjects($student, $index);
                $this->seedSkills($student, $index);
                $this->seedInternships($student, $index);
                $this->seedOrganizations($student, $index);
            }
        });
    }

    private function seedAchievements(Student $student, int $index, int $teacherId): void
    {
        foreach ([
            ['Juara 1 Lomba Web Sekolah', 'Kompetisi Web Pelajar', 'pending'],
            ['Finalis Tantangan UI/UX', 'Kompetisi Desain Digital', 'verified'],
        ] as $slot => [$title, $organizer, $status]) {
            $eventDate = $this->sampleDate($index, $slot, 0);
            $item = Achievement::query()->updateOrCreate(
                ['student_id' => $student->id, 'title' => $title],
                [
                    'category' => 'Kompetisi',
                    'level' => $slot === 0 ? 'Sekolah' : 'Kota',
                    'organizer' => $organizer,
                    'date' => $eventDate,
                    'description' => 'Kegiatan pengembangan kemampuan dan portofolio siswa.',
                    'status' => $status,
                    'verified_by' => $status === 'verified' ? $teacherId : null,
                    'verified_at' => $status === 'verified' ? $eventDate->copy()->addDays(3) : null,
                ]
            );
            $this->backdate($item, $eventDate);
        }
    }

    private function seedCertificates(Student $student, int $index, int $teacherId): void
    {
        foreach ([
            ['Sertifikat Dasar HTML dan CSS', 'Akademi Digital'],
            ['Sertifikat Dasar UI/UX', 'Lembaga Pelatihan Digital'],
        ] as $slot => [$title, $issuer]) {
            $issuedAt = $this->sampleDate($index, $slot, 1);
            $status = $slot === 0 ? 'pending' : 'verified';
            $item = Certificate::query()->updateOrCreate(
                ['student_id' => $student->id, 'title' => $title],
                [
                    'category' => 'Kompetensi',
                    'issuer' => $issuer,
                    'issued_at' => $issuedAt,
                    'certificate_number' => 'CERT-'.$student->nipd.'-'.($slot + 1),
                    'status' => $status,
                    'verified_by' => $status === 'verified' ? $teacherId : null,
                    'verified_at' => $status === 'verified' ? $issuedAt->copy()->addDays(3) : null,
                ]
            );
            $this->backdate($item, $issuedAt);
        }
    }

    private function seedProjects(Student $student, int $index): void
    {
        foreach ([
            ['website-profil-sekolah', 'Website Profil Sekolah', 'Website', 'HTML, CSS, JavaScript'],
            ['aplikasi-inventaris-sederhana', 'Aplikasi Inventaris Sederhana', 'Aplikasi Web', 'Laravel, MySQL'],
        ] as $slot => [$slug, $title, $category, $technology]) {
            $date = $this->sampleDate($index, $slot, 2);
            $item = Project::query()->updateOrCreate(
                ['student_id' => $student->id, 'slug' => $slug],
                [
                    'title' => $title,
                    'category' => $category,
                    'description' => 'Proyek pengembangan aplikasi dan teknologi digital.',
                    'technology' => $technology,
                    'status' => 'published',
                ]
            );
            $this->backdate($item, $date);
        }
    }

    private function seedSkills(Student $student, int $index): void
    {
        $sets = [
            [['HTML', 'Menengah'], ['CSS', 'Menengah']],
            [['Laravel', 'Pemula'], ['MySQL', 'Pemula']],
            [['Figma', 'Menengah'], ['JavaScript', 'Pemula']],
        ];

        foreach ($sets[$index % count($sets)] as $slot => [$name, $level]) {
            $date = $this->sampleDate($index, $slot, 3);
            $item = Skill::query()->updateOrCreate(
                ['student_id' => $student->id, 'name' => $name],
                ['level' => $level]
            );
            $this->backdate($item, $date);
        }
    }

    private function seedInternships(Student $student, int $index): void
    {
        foreach ([
            ['Studio Digital', 'Peserta PKL Web', 'Membantu pembuatan halaman web.'],
            ['Mitra Teknologi', 'Peserta PKL Aplikasi', 'Mengerjakan aplikasi sederhana.'],
        ] as $slot => [$company, $position, $description]) {
            $startDate = $this->sampleDate($index, $slot, 4, 8);
            $item = Internship::query()->updateOrCreate(
                ['student_id' => $student->id, 'company' => $company],
                [
                    'position' => $position,
                    'address' => 'Bandung',
                    'started_at' => $startDate,
                    'ended_at' => $startDate->copy()->addMonths(2)->endOfMonth(),
                    'description' => $description,
                ]
            );
            $this->backdate($item, $startDate);
        }
    }

    private function seedOrganizations(Student $student, int $index): void
    {
        $activities = [
            'Paskibra (Blue Prince)', 'Pramuka', 'PMR (Palang Merah Remaja)', 'Basket', 'Futsal',
            'Bola voli', 'Pencak silat', 'Karate (Opat Karate Club / OKC)', 'Bulu tangkis',
            'HARPA 4 (Harmoni Paduan Angklung)', 'Seni karawitan / gamelan', 'Seni musik',
            'Seni tari', 'ORBIT (ekskul bidang TKJ, RPL, dan DKV)', 'Robotika',
            'English Club (EC)', 'Jurnalistik', 'Icon',
        ];
        $count = match ($index % 6) {
            1, 3 => 1,
            2, 4 => 2,
            default => 0,
        };
        $participantIndex = 0;
        for ($prior = 0; $prior < $index; $prior++) {
            if (in_array($prior % 6, [1, 2, 3, 4], true)) $participantIndex++;
        }
        $firstIndex = $participantIndex % count($activities);

        for ($slot = 0; $slot < $count; $slot++) {
            $activityIndex = ($firstIndex + ($slot === 0 ? 0 : 1 + ($index % 5))) % count($activities);
            $name = $activities[$activityIndex];
            $date = $this->sampleDate($index, $slot, 5, 7);
            $item = Organization::query()->updateOrCreate(
                ['student_id' => $student->id, 'name' => $name],
                [
                    'organization_name' => $name,
                    'position' => 'Anggota',
                    'started_at' => $date,
                    'ended_at' => null,
                    'description' => 'Kegiatan ekstrakurikuler sekolah.',
                ]
            );
            $this->backdate($item, $date);
        }
    }

    private function sampleDate(int $index, int $slot, int $offset, int $monthCount = 10): Carbon
    {
        $month = (($index + ($slot * 3) + $offset) % $monthCount) + 1;
        $day = 1 + (intdiv($index, $monthCount) * 2) + $slot;

        return Carbon::create(2026, $month, $day)->startOfDay();
    }

    private function backdate(Model $model, Carbon $date): void
    {
        DB::table($model->getTable())->where('id', $model->getKey())->update([
            'created_at' => $date,
            'updated_at' => $date->copy()->addDays(1),
        ]);
    }
}
