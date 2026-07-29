<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\{Achievement, Certificate, Project, Student, Teacher};

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::query()->firstOrCreate([
            'email' => 'test@example.com',
        ], [
            'name' => 'Test User',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        $teacherUser = User::query()->firstOrCreate(['email' => 'guru@dsp.test'], ['name' => 'Ibu Dini Pratiwi', 'email_verified_at' => now(), 'password' => Hash::make('password'), 'role' => 'teacher']);
        $teacherUser->update(['role' => 'teacher']);
        $teacher = Teacher::query()->firstOrCreate(['user_id' => $teacherUser->id], ['nip' => '198907152014012001', 'name' => 'Ibu Dini Pratiwi', 'subject' => 'Produktif RPL', 'phone' => '081234567890']);

        $studentUser = User::query()->firstOrCreate(['email' => 'siswa@dsp.test'], ['name' => 'Rafka Aleandra', 'email_verified_at' => now(), 'password' => Hash::make('password'), 'role' => 'student']);
        $studentUser->update(['role' => 'student']);
        $student = Student::query()->firstOrCreate(['user_id' => $studentUser->id], ['nis' => '2026001', 'nisn' => '0061234567', 'name' => 'Rafka Aleandra']);
        Achievement::query()->firstOrCreate(['student_id' => $student->id, 'title' => 'Juara 1 LKS Web Technology'], ['category' => 'Kompetisi', 'level' => 'Provinsi', 'organizer' => 'Dinas Pendidikan', 'date' => now()->subDays(7), 'status' => 'pending']);
        Certificate::query()->firstOrCreate(['student_id' => $student->id, 'title' => 'Sertifikasi UI/UX Design'], ['category' => 'Kompetensi', 'issuer' => 'Dicoding Indonesia', 'issued_at' => now()->subDays(14), 'status' => 'pending']);
        Project::query()->firstOrCreate(['student_id' => $student->id, 'slug' => 'school-library-app'], ['title' => 'Aplikasi Perpustakaan Sekolah', 'description' => 'Aplikasi web untuk membantu pengelolaan peminjaman buku dan data anggota perpustakaan sekolah.', 'status' => 'published']);

        DB::table('departments')->updateOrInsert(['code' => 'RPL'], ['name' => 'Rekayasa Perangkat Lunak', 'updated_at' => now(), 'created_at' => now()]);
        DB::table('departments')->updateOrInsert(['code' => 'DKV'], ['name' => 'Desain Komunikasi Visual', 'updated_at' => now(), 'created_at' => now()]);
        $rplId = DB::table('departments')->where('code', 'RPL')->value('id');
        $dkvId = DB::table('departments')->where('code', 'DKV')->value('id');
        DB::table('classes')->updateOrInsert(['name' => 'XII RPL 1'], ['department_id' => $rplId, 'level' => 'XII', 'updated_at' => now(), 'created_at' => now()]);
        DB::table('classes')->updateOrInsert(['name' => 'XII DKV 1'], ['department_id' => $dkvId, 'level' => 'XII', 'updated_at' => now(), 'created_at' => now()]);
        $rplClass = DB::table('classes')->where('name', 'XII RPL 1')->value('id');
        $dkvClass = DB::table('classes')->where('name', 'XII DKV 1')->value('id');

        $students = [
            ['Alya Putri', 'alya.putri@dsp.test', '2026002', 'UI/UX Aplikasi Kesehatan', 'Juara 2 UI/UX Competition', 'Sertifikat Fundamental UI/UX', 'DKV'],
            ['Bagas Pratama', 'bagas.pratama@dsp.test', '2026003', 'Sistem Absensi QR Code', 'Juara 1 Hackathon Sekolah', 'Sertifikat Web Developer', 'RPL'],
            ['Citra Lestari', 'citra.lestari@dsp.test', '2026004', 'Katalog Digital Produk UMKM', 'Finalis Lomba Inovasi Digital', 'Sertifikat Digital Marketing', 'DKV'],
            ['Dimas Saputra', 'dimas.saputra@dsp.test', '2026005', 'Aplikasi Kasir Sederhana', 'Juara 3 LKS Web Technology', 'Sertifikat Laravel Dasar', 'RPL'],
            ['Eka Wulandari', 'eka.wulandari@dsp.test', '2026006', 'Website Informasi Wisata', 'Juara 1 Poster Digital', 'Sertifikat Graphic Design', 'DKV'],
            ['Fajar Ramadhan', 'fajar.ramadhan@dsp.test', '2026007', 'Portal Pengaduan Sekolah', 'Peserta Olimpiade Informatika', 'Sertifikat JavaScript', 'RPL'],
            ['Gita Ananda', 'gita.ananda@dsp.test', '2026008', 'Branding Kedai Kopi Lokal', 'Juara 2 Desain Logo', 'Sertifikat Adobe Illustrator', 'DKV'],
            ['Hadi Kurniawan', 'hadi.kurniawan@dsp.test', '2026009', 'Aplikasi Inventaris Lab', 'Juara Harapan Coding', 'Sertifikat Database MySQL', 'RPL'],
            ['Intan Permata', 'intan.permata@dsp.test', '2026010', 'Majalah Digital Sekolah', 'Finalis Content Creator', 'Sertifikat Content Writing', 'DKV'],
            ['Joko Firmansyah', 'joko.firmansyah@dsp.test', '2026011', 'Sistem Peminjaman Alat', 'Juara 2 Kompetisi Web', 'Sertifikat Git dan GitHub', 'RPL'],
        ];
        foreach ($students as $index => [$name, $email, $nis, $projectTitle, $achievementTitle, $certificateTitle, $major]) {
            $user = User::query()->updateOrCreate(['email' => $email], ['name' => $name, 'email_verified_at' => now(), 'password' => Hash::make('password'), 'role' => 'student']);
            $profile = Student::query()->updateOrCreate(['user_id' => $user->id], ['class_id' => $major === 'RPL' ? $rplClass : $dkvClass, 'nis' => $nis, 'nisn' => '00612345'.str_pad((string) $index, 2, '0', STR_PAD_LEFT), 'name' => $name, 'gender' => $index % 2 ? 'L' : 'P', 'phone' => '0812345678', 'bio' => 'Siswa aktif yang terus mengembangkan karya dan prestasi.']);
            Achievement::query()->updateOrCreate(['student_id' => $profile->id, 'title' => $achievementTitle], ['category' => 'Kompetisi', 'level' => $index % 3 === 0 ? 'Nasional' : 'Kota', 'organizer' => 'Komite Kompetisi Pelajar', 'date' => now()->subDays(10 + $index), 'status' => $index < 5 ? 'pending' : 'verified', 'verified_by' => $index >= 5 ? $teacher->id : null, 'verified_at' => $index >= 5 ? now()->subDays($index) : null]);
            Certificate::query()->updateOrCreate(['student_id' => $profile->id, 'title' => $certificateTitle], ['category' => 'Kompetensi', 'issuer' => 'Digital Talent School', 'issued_at' => now()->subDays(25 + $index), 'status' => $index % 2 ? 'pending' : 'verified', 'verified_by' => $index % 2 ? null : $teacher->id, 'verified_at' => $index % 2 ? null : now()->subDays($index)]);
            Project::query()->updateOrCreate(['student_id' => $profile->id, 'slug' => 'project-'.str($name)->slug()], ['title' => $projectTitle, 'description' => 'Project portofolio siswa untuk mengasah kemampuan analisis, desain, dan pengembangan solusi digital.', 'status' => 'published']);
            DB::table('organizations')->updateOrInsert(['student_id' => $profile->id, 'name' => $index % 2 ? 'OSIS' : 'Ekstrakurikuler '.($major === 'RPL' ? 'Programming' : 'Desain Grafis')], ['position' => $index % 2 ? 'Anggota' : 'Koordinator', 'started_at' => now()->subYear(), 'ended_at' => null, 'updated_at' => now(), 'created_at' => now()]);
            DB::table('skills')->updateOrInsert(['student_id' => $profile->id, 'name' => $major === 'RPL' ? 'Laravel' : 'Figma'], ['level' => $index % 2 ? 'Menengah' : 'Mahir', 'updated_at' => now(), 'created_at' => now()]);
        }
    }
}
