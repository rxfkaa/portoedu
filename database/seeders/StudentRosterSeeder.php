<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentRosterSeeder extends Seeder
{
    /** Replace student accounts and profiles with XII RPL 2 attendance roster. */
    public function run(): void
    {
        $roster = [
            ['ALFINUS PRASETYA', '2425120636', 'L'],
            ['AMELIA CAHYA ANGGRAENI', '2425120637', 'P'],
            ['ANDIKA RASYA PUTRA', '2425120638', 'L'],
            ['ASEP SULAEMAN', '2425120639', 'L'],
            ['AZRIL HADI ALPIANSYAH', '2425120640', 'L'],
            ['BAYU INDRA PRATAMA', '2425120641', 'L'],
            ['DAYRA AVRILLAZAHRA', '2425120642', 'P'],
            ['DERIEN ADELIO RHAIVAN', '2425120643', 'L'],
            ['DIAZ ARQILA', '2425120644', 'L'],
            ['FAKHRI RIZKI', '2425120645', 'L'],
            ['FARIS FAIZULHAQ AL-AKIYAS', '2425120646', 'L'],
            ['HADRIAN RANGGA ARDIANTARA', '2425120647', 'L'],
            ['HASBY WIRAAL MUFLIH', '2425120648', 'L'],
            ['HAZFI FEBRIANTO', '2425120649', 'L'],
            ['KHAFEA DARU HASTRI', '2425120650', 'L'],
            ['KHAIRA NAURAKHALISHAH', '2425120651', 'P'],
            ['M. ARIF VARIAN ALMER', '2425120652', 'L'],
            ['MOHAMMAD EZRA PUTRA ARKANA', '2425120653', 'L'],
            ['MUHAMAD FIQRI RAMADHAN KURNIAWAN', '2425120654', 'L'],
            ['SHAFA MUTIARA SALSABILLA', '2425120655', 'P'],
            ['MUHAMMAD ARDIKA SUHARDIMAN', '2425120656', 'L'],
            ['MUHAMMAD AZIZ ZAKARIA', '2425120657', 'L'],
            ['MUHAMMAD KHALIFA AISY HAFIY', '2425120658', 'L'],
            ['MUHAMMAD NUR RAFIE DIRGAHAYU', '2425120659', 'L'],
            ['MUHAMMAD RAFI PUTRA HARLIANA', '2425120660', 'L'],
            ['NOUYAL RASHYAASHARI', '2425120661', 'L'],
            ["QORI'AH PUTRI MUMPUNI", '2425120662', 'P'],
            ['RAFKA ALEANDRA PUTRA', '2425120663', 'L'],
            ['RAKAN SHAKA RAUFA', '2425120664', 'L'],
            ['REINDY ALFRIZA SUHENDI', '2425120665', 'L'],
            ['SANDINA AYALEDWENI NURADJI', '2425120666', 'P'],
            ['SATRIA HILABI', '2425120667', 'L'],
            ['TAUFIK HAIKAL', '2425120668', 'L'],
            ['VIKRY ALFAHRI', '2425120669', 'L'],
            ['ZAKY CAIRO AZWAR', '2425120670', 'L'],
            ['ZANETA AULIA PUTRI', '2425120671', 'P'],
        ];

        $classId = SchoolClass::query()
            ->where('level', 'XII')
            ->where('name', 'RPL 2')
            ->whereHas('department', fn ($query) => $query->where('code', 'RPL'))
            ->value('id');

        if (!$classId) {
            throw new \RuntimeException('Kelas XII RPL 2 belum tersedia.');
        }

        DB::transaction(function () use ($roster, $classId) {
            User::query()->where('role', 'student')->delete();

            foreach ($roster as [$name, $nipd, $gender]) {
                $slug = Str::slug($name) ?: 'siswa';
                $user = User::query()->create([
                    'name' => $name,
                    'username' => $slug.'-'.$nipd,
                    'email' => $this->loginEmailFor($name),
                    'email_verified_at' => now(),
                    'password' => 'password',
                    'role' => 'student',
                    'status' => 'active',
                ]);

                Student::query()->create([
                    'user_id' => $user->id,
                    'class_id' => $classId,
                    'nipd' => $nipd,
                    'name' => $name,
                    'gender' => $gender,
                ]);
            }
        });
    }

    private function loginEmailFor(string $name): string
    {
        $parts = preg_split('/\s+/', trim($name));
        $firstName = Str::lower(rtrim($parts[0] ?? '', '.'));

        if (in_array($firstName, ['m', 'muhammad', 'muhamad', 'mohammad'], true)) {
            $firstName = $parts[1] ?? $firstName;
        }

        return Str::slug($firstName).'@gmail.com';
    }
}
