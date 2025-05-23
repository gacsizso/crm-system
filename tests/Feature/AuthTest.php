<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        
        // Létrehozzuk a szükséges szerepköröket és jogosultságokat
        $this->adminRole = Role::create(['name' => 'admin']);
        $this->userRole = Role::create(['name' => 'user']);
        
        $this->createClientPermission = Permission::create(['name' => 'create client']);
        $this->editClientPermission = Permission::create(['name' => 'edit client']);
        
        $this->adminRole->givePermissionTo([$this->createClientPermission, $this->editClientPermission]);
        $this->userRole->givePermissionTo([$this->createClientPermission]);
    }

    public function test_user_can_login_with_correct_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123')
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123'
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();
    }

    public function test_user_cannot_login_with_incorrect_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123')
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword'
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_user_can_register_with_valid_data()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com'
        ]);
    }

    public function test_user_cannot_access_protected_route_without_permission()
    {
        $user = User::factory()->create();
        $user->assignRole($this->userRole);

        $response = $this->actingAs($user)->get('/clients/create');
        $response->assertStatus(200); // Mivel csak create jogosultsága van

        $response = $this->actingAs($user)->get('/clients/1/edit');
        $response->assertStatus(403); // Nincs edit jogosultsága
    }

    public function test_admin_can_access_all_routes()
    {
        $admin = User::factory()->create();
        $admin->assignRole($this->adminRole);

        $response = $this->actingAs($admin)->get('/clients/create');
        $response->assertStatus(200);

        $response = $this->actingAs($admin)->get('/clients/1/edit');
        $response->assertStatus(200);
    }

    public function test_user_can_logout()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->post('/logout');
        
        $response->assertRedirect('/');
        $this->assertGuest();
    }
} 