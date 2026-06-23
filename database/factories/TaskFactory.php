<?php

namespace Database\Factories;

use App\Enums\Tasks\TaskPriority;
use App\Enums\Tasks\TaskStatus;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'due_date' => $this->faker->dateTimeBetween('+1 day', '+30 days'),
            'created_date' => now(),
            'status' => $this->faker->randomElement(TaskStatus::values()),
            'priority' => $this->faker->randomElement(TaskPriority::values()),
            'category' => $this->faker->randomElement(['Work', 'Home', 'Personal']),
        ];
    }
}
