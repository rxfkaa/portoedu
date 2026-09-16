<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login_when_opening_the_dashboard(): void
    {
        $response = $this->get(route('dashboard'));

        $response->assertRedirect(route('login'));
    }

    public function test_user_can_log_in_and_is_redirected_to_the_dashboard(): void
    {
        $user = User::factory()->create([
            'email' => 'student@example.com',
        ]);

        $response = $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_portfolio_pages_are_available_to_authenticated_users(): void
    {
        $user = User::factory()->create(['role' => 'student', 'status' => 'active']);
        Student::create([
            'user_id' => $user->id,
            'nis' => 'TEST-' . $user->id,
            'name' => $user->name,
        ]);

        foreach ([
            'dashboard', 'profile', 'achievements.index', 'achievements.create',
            'certificates.index', 'projects.index', 'organizations.index',
            'gallery.index', 'statistics.index', 'qr-code.index', 'settings.index',
        ] as $route) {
            $this->actingAs($user)->get(route($route))->assertOk();
        }
    }
}
