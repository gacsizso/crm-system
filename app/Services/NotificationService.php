<?php

namespace App\Services;

use App\Models\User;
use App\Models\Notification;

class NotificationService
{
    public function create(User $user, string $type, string $title, string $message, ?string $link = null): Notification
    {
        return Notification::create([
            'user_id' => $user->id,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'link' => $link
        ]);
    }

    public function notifyClientCreated(User $user, $client): Notification
    {
        return $this->create(
            $user,
            'client_created',
            'Új ügyfél létrehozva',
            "A(z) {$client->name} ügyfél sikeresen létrejött.",
            route('clients.show', $client)
        );
    }

    public function notifyTaskAssigned(User $user, $task): Notification
    {
        return $this->create(
            $user,
            'task_assigned',
            'Új feladat hozzárendelve',
            "A(z) {$task->title} feladatot hozzárendelték hozzád.",
            route('tasks.show', $task)
        );
    }

    public function notifyProjectUpdated(User $user, $project): Notification
    {
        return $this->create(
            $user,
            'project_updated',
            'Projekt frissítve',
            "A(z) {$project->name} projekt frissítve lett.",
            route('projects.show', $project)
        );
    }

    public function notifyDeadlineApproaching(User $user, $task): Notification
    {
        return $this->create(
            $user,
            'deadline_approaching',
            'Közelgő határidő',
            "A(z) {$task->title} feladat határideje közeledik.",
            route('tasks.show', $task)
        );
    }

    public function getUnreadCount(User $user): int
    {
        return $user->notifications()->where('is_read', false)->count();
    }

    public function markAllAsRead(User $user): void
    {
        $user->notifications()
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);
    }
} 