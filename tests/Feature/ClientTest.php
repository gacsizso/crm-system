<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ClientTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        
        $this->adminRole = Role::create(['name' => 'admin']);
        $this->userRole = Role::create(['name' => 'user']);
        
        $this->createClientPermission = Permission::create(['name' => 'create client']);
        $this->editClientPermission = Permission::create(['name' => 'edit client']);
        $this->deleteClientPermission = Permission::create(['name' => 'delete client']);
        
        $this->adminRole->givePermissionTo([
            $this->createClientPermission,
            $this->editClientPermission,
            $this->deleteClientPermission
        ]);
        
        $this->userRole->givePermissionTo([$this->createClientPermission]);
    }

    public function test_user_can_view_clients_list()
    {
        $user = User::factory()->create();
        $user->assignRole($this->userRole);

        $response = $this->actingAs($user)->get('/clients');
        $response->assertStatus(200);
    }

    public function test_user_can_create_client()
    {
        $user = User::factory()->create();
        $user->assignRole($this->userRole);

        $clientData = [
            'name' => 'Test Client',
            'email' => 'client@example.com',
            'phone' => '+36123456789',
            'address' => 'Test Address 123',
            'type' => 'Magánszemély',
            'tax_number' => '12345678-1-23'
        ];

        $response = $this->actingAs($user)->post('/clients', $clientData);
        $response->assertRedirect();
        $this->assertDatabaseHas('clients', [
            'name' => 'Test Client',
            'email' => 'client@example.com'
        ]);
    }

    public function test_user_cannot_create_client_with_invalid_data()
    {
        $user = User::factory()->create();
        $user->assignRole($this->userRole);

        $clientData = [
            'name' => '', // Üres név
            'email' => 'invalid-email', // Érvénytelen email
            'type' => '', // Hiányzó típus
        ];

        $response = $this->actingAs($user)->post('/clients', $clientData);
        $response->assertSessionHasErrors(['name', 'email', 'type']);
        $this->assertDatabaseMissing('clients', [
            'email' => 'invalid-email'
        ]);
    }

    public function test_admin_can_edit_client()
    {
        $admin = User::factory()->create();
        $admin->assignRole($this->adminRole);

        $client = Client::factory()->create();

        $updatedData = [
            'name' => 'Updated Client Name',
            'email' => 'updated@example.com',
            'phone' => '+36987654321',
            'address' => 'Updated Address 456',
            'tax_number' => '87654321-9-87'
        ];

        $response = $this->actingAs($admin)->put("/clients/{$client->id}", $updatedData);
        
        $response->assertRedirect('/clients');
        $this->assertDatabaseHas('clients', [
            'id' => $client->id,
            'name' => 'Updated Client Name',
            'email' => 'updated@example.com'
        ]);
    }

    public function test_regular_user_cannot_edit_client()
    {
        $user = User::factory()->create();
        $user->assignRole($this->userRole);

        $client = Client::factory()->create();

        $updatedData = [
            'name' => 'Updated Client Name',
            'email' => 'updated@example.com'
        ];

        $response = $this->actingAs($user)->put("/clients/{$client->id}", $updatedData);
        
        $response->assertStatus(403);
        $this->assertDatabaseMissing('clients', [
            'id' => $client->id,
            'name' => 'Updated Client Name'
        ]);
    }

    public function test_admin_can_delete_client()
    {
        $admin = User::factory()->create();
        $admin->assignRole($this->adminRole);

        $client = Client::factory()->create();

        $response = $this->actingAs($admin)->delete("/clients/{$client->id}");
        
        $response->assertRedirect('/clients');
        $this->assertDatabaseMissing('clients', [
            'id' => $client->id
        ]);
    }

    public function test_regular_user_cannot_delete_client()
    {
        $user = User::factory()->create();
        $user->assignRole($this->userRole);

        $client = Client::factory()->create();

        $response = $this->actingAs($user)->delete("/clients/{$client->id}");
        
        $response->assertStatus(403);
        $this->assertDatabaseHas('clients', [
            'id' => $client->id
        ]);
    }
} 