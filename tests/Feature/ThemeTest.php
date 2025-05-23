<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThemeTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_change_theme()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/profile/theme', [
            'theme' => 'dark'
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'theme' => 'dark'
        ]);
    }

    public function test_theme_is_persisted_in_database()
    {
        $user = User::factory()->create([
            'theme' => 'dark'
        ]);

        $response = $this->actingAs($user)->get('/dashboard');
        
        $response->assertStatus(200);
        $response->assertSee('theme-dark');
    }

    public function test_theme_is_persisted_in_local_storage()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');
        
        $response->assertStatus(200);
        $this->assertStringContainsString('localStorage.setItem(\'theme\',', $response->getContent());
    }

    public function test_theme_toggle_button_exists()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');
        
        $response->assertStatus(200);
        $this->assertStringContainsString('id="themeToggle"', $response->getContent());
        $this->assertStringContainsString('bi-moon', $response->getContent());
    }

    public function test_theme_affects_all_components()
    {
        $user = User::factory()->create([
            'theme' => 'dark'
        ]);

        $response = $this->actingAs($user)->get('/dashboard');
        
        $response->assertStatus(200);
        $response->assertSee('theme-dark');
        
        // Ellenőrizzük a főbb komponensek stílusait
        $response->assertSee('.theme-dark .card');
        $response->assertSee('.theme-dark .sidebar');
        $response->assertSee('.theme-dark .topbar');
        $response->assertSee('.theme-dark .form-control');
        $response->assertSee('.theme-dark .table');
        $response->assertSee('.theme-dark .btn');
    }

    public function test_theme_switch_affects_all_pages()
    {
        $user = User::factory()->create();

        // Dashboard oldal
        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('theme-light');

        // Téma váltás
        $response = $this->actingAs($user)->post('/profile/theme', [
            'theme' => 'dark'
        ]);
        $response->assertStatus(200);

        // Ügyfelek oldal
        $response = $this->actingAs($user)->get('/clients');
        $response->assertStatus(200);
        $response->assertSee('theme-dark');

        // Projektek oldal
        $response = $this->actingAs($user)->get('/projects');
        $response->assertStatus(200);
        $response->assertSee('theme-dark');
    }

    public function test_theme_switch_affects_notifications()
    {
        $user = User::factory()->create([
            'theme' => 'dark'
        ]);

        $response = $this->actingAs($user)->get('/notifications');
        
        $response->assertStatus(200);
        $response->assertSee('.theme-dark .notification-item');
        $response->assertSee('.theme-dark .notification-dropdown-menu');
    }

    public function test_theme_switch_affects_forms()
    {
        $user = User::factory()->create([
            'theme' => 'dark'
        ]);

        $response = $this->actingAs($user)->get('/clients/create');
        
        $response->assertStatus(200);
        $response->assertSee('.theme-dark .form-control');
        $response->assertSee('.theme-dark .form-label');
        $response->assertSee('.theme-dark .btn');
    }

    public function test_theme_switch_affects_tables()
    {
        $user = User::factory()->create([
            'theme' => 'dark'
        ]);

        $response = $this->actingAs($user)->get('/clients');
        
        $response->assertStatus(200);
        $response->assertSee('.theme-dark .table');
        $response->assertSee('.theme-dark .table-striped');
        $response->assertSee('.theme-dark .table-hover');
    }
} 