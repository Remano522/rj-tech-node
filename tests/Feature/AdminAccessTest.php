<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_when_opening_admin_dashboard(): void
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertRedirect(route('login'));
    }

    public function test_non_admin_user_cannot_access_admin_dashboard(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.dashboard'));

        $response->assertForbidden();
    }

    public function test_admin_user_can_access_admin_dashboard(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertSee('Dashboard Admin');
    }

    public function test_admin_can_update_profile_name(): void
    {
        $admin = User::factory()->admin()->create([
            'name' => 'Admin Lama',
        ]);

        $this->actingAs($admin)->put(route('admin.profile.update'), [
            'name' => 'Admin Baru',
        ])->assertRedirect();

        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
            'name' => 'Admin Baru',
        ]);
    }

    public function test_admin_can_update_password_with_correct_current_password(): void
    {
        $admin = User::factory()->admin()->create([
            'password' => 'passwordlama',
        ]);

        $this->actingAs($admin)->put(route('admin.password.update'), [
            'current_password' => 'passwordlama',
            'password' => 'passwordbaru123',
            'password_confirmation' => 'passwordbaru123',
        ])->assertRedirect();

        $admin->refresh();

        $this->assertTrue(Hash::check('passwordbaru123', $admin->password));
    }
}
