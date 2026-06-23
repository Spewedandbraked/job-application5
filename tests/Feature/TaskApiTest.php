<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_can_get_all_tasks(): void
    {
        Task::factory()->count(3)->create();

        $response = $this->getJson('/api/tasks');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'description',
                        'due_date',
                        'created_date',
                        'status',
                        'priority',
                        'category',
                    ],
                ],
                'current_page',
                'total',
                'per_page',
                'last_page',
            ]);
    }

    public function test_can_search_tasks_by_title(): void
    {
        Task::factory()->create(['title' => 'Test Search Task']);
        Task::factory()->create(['title' => 'Another Task']);

        $response = $this->getJson('/api/tasks?search=Test');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.title', 'Test Search Task');
    }

    public function test_can_sort_tasks_by_due_date(): void
    {
        $task1 = Task::factory()->create(['due_date' => now()->addDays(3)]);
        $task2 = Task::factory()->create(['due_date' => now()->addDays(1)]);
        $task3 = Task::factory()->create(['due_date' => now()->addDays(2)]);

        $response = $this->getJson('/api/tasks?sort=due_date');

        $response->assertStatus(200);
        $this->assertEquals($task2->id, $response->json('data.0.id'));
        $this->assertEquals($task3->id, $response->json('data.1.id'));
        $this->assertEquals($task1->id, $response->json('data.2.id'));
    }

    public function test_can_create_task(): void
    {
        $payload = [
            'title' => 'New Task',
            'description' => 'Task description',
            'due_date' => now()->addDays(5)->toDateTimeString(),
            'priority' => 'high',
            'category' => 'Work',
            'status' => 'pending',
        ];

        $response = $this->postJson('/api/tasks', $payload);

        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'message']);

        $this->assertDatabaseHas('tasks', [
            'title' => 'New Task',
            'description' => 'Task description',
            'priority' => 'high',
            'category' => 'Work',
            'status' => 'pending',
        ]);
    }

    public function test_cannot_create_task_without_required_fields(): void
    {
        $response = $this->postJson('/api/tasks', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'due_date', 'category']);
    }

    public function test_can_get_single_task(): void
    {
        $task = Task::factory()->create();

        $response = $this->getJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [ // <-- добавить обертку data
                    'id' => $task->id,
                    'title' => $task->title,
                    'description' => $task->description,
                    'status' => $task->status->value,
                    'priority' => $task->priority->value,
                    'category' => $task->category,
                ],
            ]);
    }

    public function test_returns_404_for_nonexistent_task(): void
    {
        $response = $this->getJson('/api/tasks/99999');

        $response->assertStatus(404);
    }

    public function test_can_update_task(): void
    {
        $task = Task::factory()->create([
            'title' => 'Old Title',
            'status' => 'pending',
        ]);

        $payload = [
            'title' => 'Updated Title',
            'status' => 'completed',
        ];

        $response = $this->putJson("/api/tasks/{$task->id}", $payload);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Task updated successfully']);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Updated Title',
            'status' => 'completed',
        ]);
    }

    public function test_can_partially_update_task(): void
    {
        $task = Task::factory()->create([
            'title' => 'Original Title',
            'description' => 'Original Description',
        ]);

        $response = $this->putJson("/api/tasks/{$task->id}", [
            'title' => 'Only Title Updated',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Only Title Updated',
            'description' => 'Original Description',
        ]);
    }

    public function test_can_delete_task(): void
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Task deleted successfully']);

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_returns_404_when_deleting_nonexistent_task(): void
    {
        $response = $this->deleteJson('/api/tasks/99999');

        $response->assertStatus(404);
    }

    public function test_returns_paginated_results(): void
    {
        Task::factory()->count(25)->create();

        $response = $this->getJson('/api/tasks?per_page=10');

        $response->assertStatus(200)
            ->assertJson([
                'per_page' => 10,
                'current_page' => 1,
                'data' => [],
            ])
            ->assertJsonCount(10, 'data');
    }

    public function test_validation_prevents_invalid_status(): void
    {
        $task = Task::factory()->create();

        $response = $this->putJson("/api/tasks/{$task->id}", [
            'status' => 'invalid_status',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['status']);
    }

    public function test_validation_prevents_invalid_priority(): void
    {
        $task = Task::factory()->create();

        $response = $this->putJson("/api/tasks/{$task->id}", [
            'priority' => 'invalid_priority',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['priority']);
    }

    public function test_title_validation_prevents_long_title(): void
    {
        $response = $this->postJson('/api/tasks', [
            'title' => str_repeat('a', 256),
            'due_date' => now()->addDays(1)->toDateTimeString(),
            'category' => 'Work',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title']);
    }

    public function test_due_date_must_be_in_future(): void
    {
        $response = $this->postJson('/api/tasks', [
            'title' => 'Test Task',
            'due_date' => now()->subDay()->toDateTimeString(),
            'category' => 'Work',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['due_date']);
    }
}
