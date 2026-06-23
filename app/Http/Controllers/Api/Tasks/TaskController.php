<?php

namespace App\Http\Controllers\Api\Tasks;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class TaskController extends Controller
{
    public function index(Request $request): TaskCollection
    {
        $perPage = $request->input('per_page', 15);

        $tasks = QueryBuilder::for(Task::class)
            ->allowedFilters(
                AllowedFilter::partial('search', 'title'),
                AllowedFilter::exact('status'),
                AllowedFilter::exact('priority'),
            )
            ->allowedSorts(
                'due_date',
                'created_at',
                'created_date',
                'title',
                'priority',
                'status',
            )
            ->defaultSort('due_date')
            ->paginate($perPage);

        return new TaskCollection($tasks);
    }

    public function store(TaskRequest $request): JsonResponse
    {
        $validated = $request->validated();

        if (!isset($validated['created_date'])) {
            $validated['created_date'] = now();
        }

        $task = Task::create($validated);

        return response()->json([
            'id' => $task->id,
            'message' => 'Task created successfully',
        ], 201);
    }

    public function show(Task $task): JsonResource
    {
        JsonResource::withoutWrapping();
        return new TaskResource($task);
    }

    public function update(TaskRequest $request, Task $task): JsonResponse
    {
        $validated = $request->validated();
        $task->update($validated);

        return response()->json([
            'message' => 'Task updated successfully',
        ]);
    }

    public function destroy(Task $task): JsonResponse
    {
        $task->delete();

        return response()->json([
            'message' => 'Task deleted successfully',
        ]);
    }
}
