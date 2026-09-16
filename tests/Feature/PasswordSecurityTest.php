<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\PortfolioSetting;
use App\Models\Department;
use App\Models\SchoolClass;
use App\Models\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class PasswordSecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_hashes_password_and_waits_for_admin_approval(): void
    {
        $department = Department::create(['name' => 'Rekayasa Perangkat Lunak', 'code' => 'RPL']);
        $class = SchoolClass::create(['name' => 'A', 'level' => 'XI', 'department_id' => $department->id]);

        $this->post(route('register.store'), [
            'name' => 'Siswa PortoEdu',
            'email' => 'siswa@example.com',
            'requested_role' => 'student',
            'nis' => '12345678',
            'class_id' => $class->id,
            'password' => 'PasswordAman123',
            'password_confirmation' => 'PasswordAman123',
        ])->assertRedirect(route('login'));

        $user = User::where('email', 'siswa@example.com')->firstOrFail();

        $this->assertNotSame('PasswordAman123', $user->getRawOriginal('password'));
        $this->assertTrue(Hash::check('PasswordAman123', $user->getRawOriginal('password')));
        $this->assertSame('pending', $user->status);
        $this->assertSame('student', $user->requested_role);
        $this->assertSame('12345678', $user->registration_nis);
        $this->assertSame($class->id, $user->registration_class_id);
        $this->assertDatabaseMissing('students', ['user_id' => $user->id]);

        $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'PasswordAman123',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_admin_can_approve_teacher_registration_and_create_teacher_profile(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $applicant = User::factory()->create([
            'role' => 'pending',
            'status' => 'pending',
            'requested_role' => 'teacher',
        ]);

        $this->actingAs($admin)
            ->post(route('admin.users.approve', $applicant), ['role' => 'teacher'])
            ->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id' => $applicant->id,
            'role' => 'teacher',
            'status' => 'active',
        ]);
        $this->assertDatabaseHas('teachers', [
            'user_id' => $applicant->id,
            'name' => $applicant->name,
        ]);
        $this->assertDatabaseHas('notifications', [
            'user_id' => $applicant->id,
            'title' => 'Pendaftaran disetujui',
        ]);
    }

    public function test_admin_can_open_user_management_page(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get(route('admin.users'))
            ->assertOk()
            ->assertSee('Kelola Pengguna');
    }

    public function test_teacher_can_open_project_review_page(): void
    {
        $teacherUser = User::factory()->create(['role' => 'teacher']);
        Teacher::create([
            'user_id' => $teacherUser->id,
            'name' => $teacherUser->name,
        ]);

        $this->actingAs($teacherUser)
            ->get(route('teacher.projects'))
            ->assertOk()
            ->assertSee('Review Project Siswa');
    }

    public function test_admin_can_reject_registration_with_a_reason(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $applicant = User::factory()->create([
            'role' => 'pending',
            'status' => 'pending',
            'requested_role' => 'student',
        ]);

        $this->actingAs($admin)
            ->post(route('admin.users.reject', $applicant), [
                'rejection_reason' => 'Data identitas belum lengkap.',
            ])
            ->assertRedirect(route('admin.users'));

        $this->assertDatabaseHas('users', [
            'id' => $applicant->id,
            'status' => 'rejected',
            'rejection_reason' => 'Data identitas belum lengkap.',
        ]);
        $this->assertDatabaseHas('notifications', [
            'user_id' => $applicant->id,
            'title' => 'Pendaftaran ditolak',
        ]);
    }

    public function test_public_portfolio_is_available_without_login_and_roles_are_restricted(): void
    {
        $studentUser = User::factory()->create(['name' => 'Portfolio Public']);
        Student::create([
            'user_id' => $studentUser->id,
            'nis' => 'PUBLIC-' . $studentUser->id,
            'name' => $studentUser->name,
        ]);
        $teacher = User::factory()->create(['role' => 'teacher']);

        PortfolioSetting::create([
            'student_id' => $studentUser->student->id,
            'theme' => 'emerald',
            'is_public' => true,
        ]);

        $this->get(route('portfolio.show', $studentUser->name))
            ->assertOk()
            ->assertSee('--portfolio-primary: #059669', false);
        $this->actingAs($studentUser)->get(route('admin.dashboard'))->assertForbidden();
        $this->actingAs($teacher)->get(route('admin.dashboard'))->assertForbidden();
        $this->actingAs($studentUser)->get(route('teacher.dashboard'))->assertForbidden();
    }

    public function test_dashboard_redirects_teacher_and_admin_to_their_own_dashboard(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);
        $teacher = User::factory()->create(['role' => 'teacher', 'status' => 'active']);
        Teacher::create(['user_id' => $teacher->id, 'name' => $teacher->name]);

        $this->actingAs($admin)->get(route('dashboard'))->assertRedirect(route('admin.dashboard'));
        $this->actingAs($teacher)->get(route('dashboard'))->assertRedirect(route('teacher.dashboard'));
    }

    public function test_student_can_save_a_valid_public_portfolio_theme(): void
    {
        $user = User::factory()->create(['role' => 'student', 'status' => 'active']);
        Student::create([
            'user_id' => $user->id,
            'nis' => 'THEME-' . $user->id,
            'name' => $user->name,
        ]);

        $this->actingAs($user)
            ->post(route('settings.appearance'), [
                'theme' => 'rose',
                'is_public' => '1',
                'social_links' => [
                    ['platform' => 'github', 'url' => 'https://github.com/portoedu'],
                ],
            ])
            ->assertSessionHas('success');

        $this->assertDatabaseHas('portfolio_settings', [
            'student_id' => $user->student->id,
            'theme' => 'rose',
            'is_public' => 1,
        ]);
    }

    public function test_expired_reset_token_cannot_change_a_password(): void
    {
        $user = User::factory()->create(['password' => 'PasswordLama123']);
        $token = Str::random(60);

        DB::table('password_reset_tokens')->insert([
            'email' => $user->email,
            'token' => Hash::make($token),
            'created_at' => now()->subMinutes(61),
        ]);

        $this->post(route('password.store'), [
            'email' => $user->email,
            'token' => $token,
            'password' => 'PasswordBaru123',
            'password_confirmation' => 'PasswordBaru123',
        ])->assertSessionHasErrors('email');

        $this->assertTrue(Hash::check('PasswordLama123', $user->fresh()->getRawOriginal('password')));
        $this->assertDatabaseMissing('password_reset_tokens', ['email' => $user->email]);
    }
}
