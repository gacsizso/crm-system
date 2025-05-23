<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class ContactAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);
    }

    public function test_admin_can_edit_any_contact()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');
        $contact = Contact::factory()->create();
        $this->actingAs($admin)
            ->get(route('contacts.edit', $contact))
            ->assertStatus(200);
    }

    public function test_user_can_edit_own_contact()
    {
        $user = User::factory()->create();
        $user->assignRole('user');
        $contact = Contact::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user)
            ->get(route('contacts.edit', $contact))
            ->assertStatus(200);
    }

    public function test_user_cannot_edit_others_contact()
    {
        $user = User::factory()->create();
        $user->assignRole('user');
        $other = User::factory()->create();
        $other->assignRole('user');
        $contact = Contact::factory()->create(['user_id' => $other->id]);
        $this->actingAs($user)
            ->get(route('contacts.edit', $contact))
            ->assertStatus(403);
    }
} 