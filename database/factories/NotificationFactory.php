<?php

namespace Database\Factories;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    protected $model = Notification::class;

    public function definition()
    {
        return [
            'user_id' => null,
            'type' => 'info',
            'title' => $this->faker->sentence(3),
            'message' => $this->faker->sentence(8),
            'is_read' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
} 