<?php

namespace App\Models;

use App\Enums\Tasks\TaskPriority;
use App\Enums\Tasks\TaskSortFields;
use App\Enums\Tasks\TaskStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'due_date',
        'created_date',
        'status',
        'priority',
        'category',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'created_date' => 'datetime',
        'status' => TaskStatus::class,
        'priority' => TaskPriority::class,
    ];

    public static function getStatuses(): array
    {
        return TaskStatus::values();
    }

    public static function getPriorities(): array
    {
        return TaskPriority::values();
    }

    public function scopeFilterByTitle($query, ?string $search): void
    {
        if ($search) {
            $query->where('title', 'LIKE', "%{$search}%");
        }
    }

    public function scopeSortBy($query, TaskSortFields|string|null $sortField = null): void
    {
        $sortField = match (true) {
            is_string($sortField) => TaskSortFields::tryFrom($sortField) ?? TaskSortFields::default(),
            $sortField instanceof TaskSortFields => $sortField,
            default => TaskSortFields::default(),
        };

        $query->orderBy($sortField->value);
    }
}
