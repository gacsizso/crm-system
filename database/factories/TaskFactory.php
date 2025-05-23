<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'status' => 'open',
            'project_id' => Project::factory(),
            'assigned_to' => User::factory(),
            'due_date' => $this->faker->dateTimeBetween('+1 days', '+1 month'),
            'created_by' => User::factory(),
        ];
    }
} 