<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition()
    {
        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'status' => 'nyitott',
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'deadline' => $this->faker->date(),
            'hourly_rate' => $this->faker->randomFloat(2, 5000, 20000),
            'hours' => $this->faker->numberBetween(1, 100),
            'currency' => 'HUF',
            'note' => $this->faker->sentence(6),
            'created_by' => null,
            'contact_id' => null,
            'group_id' => null,
            'manager_id' => null,
        ];
    }
} 