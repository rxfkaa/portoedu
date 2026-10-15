<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ApiAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_api_is_protected_and_only_returns_safe_fields(): void
    {
        $user = User::factory()->create([
            'role' => 'student',
            'status' => 'active',
            'registration_nipd' => 'SENSITIVE-NIPD',
        ]);

        $this->getJson('/api/users')->assertUnauthorized();
        $this->getJson('/api/users/'.$user->id)->assertUnauthorized();
        $this->postJson('/api/users', [])->assertUnauthorized();
        $this->putJson('/api/users/'.$user->id, ['role' => 'admin'])->assertUnauthorized();
        $this->deleteJson('/api/users/'.$user->id)->assertUnauthorized();

        $token = $user->createToken('test')->plainTextToken;
        $this->withToken($token)
            ->getJson('/api/auth/me')
            ->assertOk()
            ->assertJsonPath('data.id', $user->id)
            ->assertJsonMissingPath('data.password')
            ->assertJsonMissingPath('data.registration_nipd');

        $this->withToken($token)->getJson('/api/users')->assertForbidden();
    }

    public function test_api_login_issues_token_only_for_active_accounts_and_logout_revokes_it(): void
    {
        $user = User::factory()->create([
            'email' => 'api-user@example.com',
            'password' => Hash::make('PasswordAman123'),
            'role' => 'student',
            'status' => 'active',
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => $user->email,
            'password' => 'PasswordAman123',
            'device_name' => 'test-client',
        ])->assertOk()->assertJsonPath('data.token_type', 'Bearer');

        $token = $response->json('data.token');
        $this->assertNotEmpty($token);
        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_id' => $user->id,
            'name' => 'test-client',
        ]);

        $this->withToken($token)->postJson('/api/auth/logout')->assertOk();
        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_id' => $user->id,
            'name' => 'test-client',
        ]);
        Auth::forgetGuards();
        $this->withToken($token)->getJson('/api/auth/me')->assertUnauthorized();

        $pending = User::factory()->create([
            'email' => 'pending-api-user@example.com',
            'password' => Hash::make('PasswordAman123'),
            'status' => 'pending',
        ]);

        $this->postJson('/api/auth/login', [
            'email' => $pending->email,
            'password' => 'PasswordAman123',
        ])->assertUnprocessable();
    }

    public function test_admin_can_manage_users_without_exposing_passwords(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'active',
        ]);
        $token = $admin->createToken('admin-api')->plainTextToken;

        $created = $this->withToken($token)->postJson('/api/users', [
            'name' => 'API Student',
            'email' => 'api-student@example.com',
            'password' => 'PasswordAman123',
            'role' => 'student',
        ])->assertCreated()
            ->assertJsonPath('data.email', 'api-student@example.com')
            ->assertJsonMissingPath('data.password');

        $id = $created->json('data.id');
        $this->assertTrue(Hash::check('PasswordAman123', User::findOrFail($id)->getRawOriginal('password')));

        $this->withToken($token)->putJson('/api/users/'.$id, [
            'role' => 'role-from-request-is-invalid',
        ])->assertUnprocessable();

        $this->withToken($token)->putJson('/api/users/'.$id, [
            'name' => 'Updated API Student',
        ])->assertOk()->assertJsonPath('data.name', 'Updated API Student');

        $this->withToken($token)->deleteJson('/api/users/'.$id)->assertOk();
        $this->assertDatabaseMissing('users', ['id' => $id]);
    }
}
