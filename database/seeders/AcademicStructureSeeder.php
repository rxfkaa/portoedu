<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\SchoolClass;
use Illuminate\Database\Seeder;

class AcademicStructureSeeder extends Seeder
{
    /** Seed the school majors and their standard X–XII classes. */
    public function run(): void
    {
        $departments = [
            'RPL' => 'Rekayasa Perangkat Lunak',
            'DKV' => 'Desain Komunikasi Visual',
            'TAV' => 'Teknik Audio Video',
            'TITL' => 'Teknik Instalasi Tenaga Listrik',
            'TKJ' => 'Teknik Komputer dan Jaringan',
            'TOI' => 'Teknik Otomasi Industri',
        ];

        foreach ($departments as $code => $name) {
            $department = Department::updateOrCreate(['code' => $code], ['name' => $name]);

            foreach (['X', 'XI', 'XII'] as $level) {
                SchoolClass::firstOrCreate([
                    'department_id' => $department->id,
                    'level' => $level,
                    'name' => $code . ' 1',
                ]);
            }
        }
    }
}
