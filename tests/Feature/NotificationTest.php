<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Notification;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Event::fake();
    }

    public function test_user_can_see_notifications()
    {
        $user = User::factory()->create();
        
        // Létrehozunk néhány értesítést
        Notification::factory()->count(3)->create([
            'user_id' => $user->id,
            'is_read' => false
        ]);

        $response = $this->actingAs($user)->get('/notifications');
        
        $response->assertStatus(200);
        $response->assertViewHas('notifications');
    }

    public function test_user_can_mark_notification_as_read()
    {
        $user = User::factory()->create();
        $notification = Notification::factory()->create([
            'user_id' => $user->id,
            'is_read' => false
        ]);

        $response = $this->actingAs($user)->post("/notifications/{$notification->id}/mark-as-read");
        
        $response->assertStatus(200);
        $this->assertDatabaseHas('notifications', [
            'id' => $notification->id,
            'is_read' => true
        ]);
    }

    public function test_user_cannot_mark_others_notification_as_read()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        
        $notification = Notification::factory()->create([
            'user_id' => $user1->id,
            'is_read' => false
        ]);

        $response = $this->actingAs($user2)->post("/notifications/{$notification->id}/mark-as-read");
        
        $response->assertStatus(403);
        $this->assertDatabaseHas('notifications', [
            'id' => $notification->id,
            'is_read' => false
        ]);
    }

    public function test_user_can_see_unread_notification_count()
    {
        $user = User::factory()->create();
        
        // Létrehozunk 3 olvasatlan értesítést
        Notification::factory()->count(3)->create([
            'user_id' => $user->id,
            'is_read' => false
        ]);

        $response = $this->actingAs($user)->get('/notifications/unread-count');
        
        $response->assertStatus(200);
        $response->assertJson(['count' => 3]);
    }

    public function test_notifications_are_ordered_by_created_at_desc()
    {
        $user = User::factory()->create();
        
        // Létrehozunk értesítéseket különböző időpontokban
        $oldNotification = Notification::factory()->create([
            'user_id' => $user->id,
            'created_at' => now()->subHours(2)
        ]);
        
        $newNotification = Notification::factory()->create([
            'user_id' => $user->id,
            'created_at' => now()
        ]);

        $response = $this->actingAs($user)->get('/notifications');
        
        $response->assertStatus(200);
        $notifications = $response->viewData('notifications');
        
        // Ellenőrizzük, hogy az újabb értesítés van előbb
        $this->assertEquals($newNotification->id, $notifications->first()->id);
    }

    public function test_notification_is_created_when_client_is_created()
    {
        $user = User::factory()->create();
        
        $clientData = [
            'name' => 'Test Client',
            'email' => 'client@example.com',
            'phone' => '+36123456789',
            'type' => 'cég',
        ];

        $response = $this->actingAs($user)->post('/clients', $clientData);
        
        $this->assertDatabaseHas('notifications', [
            'user_id' => $user->id,
            'title' => 'Új ügyfél létrehozva',
            'message' => 'A Test Client ügyfél sikeresen létrejött.'
        ]);
    }

    public function test_notification_is_created_when_task_is_assigned()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();
        
        $response = $this->actingAs($user)->post("/tasks/{$task->id}/assign", [
            'user_id' => $user->id
        ]);
        
        $this->assertDatabaseHas('notifications', [
            'user_id' => $user->id,
            'title' => 'Új feladat hozzárendelve',
            'message' => "A {$task->title} feladat hozzád lett rendelve."
        ]);
    }
} 