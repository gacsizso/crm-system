<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeadlineApproachingNotification extends Notification
{
    use Queueable;

    protected $task;

    /**
     * Create a new notification instance.
     */
    public function __construct($task)
    {
        $this->task = $task;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Közelgő határidő')
            ->greeting('Kedves ' . $notifiable->name . '!')
            ->line('Egy feladat határideje hamarosan lejár:')
            ->line('Feladat: ' . $this->task->title)
            ->line('Határidő: ' . ($this->task->due_date ? $this->task->due_date->format('Y.m.d') : 'N/A'))
            ->action('Feladat megtekintése', route('tasks.show', $this->task))
            ->line('Köszönjük, hogy a rendszert használod!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
