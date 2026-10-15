<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AcademicStructureSeeder::class,
            StudentRosterSeeder::class,
        ]);

        $adminUser = User::query()->firstOrCreate(['email' => 'admin@dsp.test'], [
            'name' => 'Administrator',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
        ]);
        $adminUser->update(['role' => 'admin', 'status' => 'active']);

        $teacherUser = User::query()->firstOrCreate(['email' => 'guru@dsp.test'], [
            'name' => 'Arne Herdiana',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'status' => 'active',
        ]);
        $teacherUser->update(['name' => 'Arne Herdiana', 'role' => 'teacher', 'status' => 'active']);
        Teacher::query()->updateOrCreate(['user_id' => $teacherUser->id], [
            'nip' => '198907152014012001',
            'name' => 'Arne Herdiana',
            'subject' => 'Produktif RPL',
            'phone' => '081234567890',
        ]);

        $this->call(StudentPortfolioSeeder::class);

    }
}
