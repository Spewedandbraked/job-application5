<?php

namespace App\Http\Requests;

use App\Enums\Tasks\TaskPriority;
use App\Enums\Tasks\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'title' => [$isUpdate ? 'sometimes' : 'required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'due_date' => [$isUpdate ? 'sometimes' : 'required', 'date', 'after:now'],
            'created_date' => ['nullable', 'date'],
            'status' => ['nullable', 'string', Rule::in(TaskStatus::values())],
            'priority' => ['nullable', 'string', Rule::in(TaskPriority::values())],
            'category' => [$isUpdate ? 'sometimes' : 'required', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Название задачи обязательно',
            'title.max' => 'Название не может быть длиннее 255 символов',
            'due_date.required' => 'Срок выполнения обязателен',
            'due_date.date' => 'Неверный формат даты',
            'due_date.after' => 'Срок выполнения должен быть в будущем',
            'category.required' => 'Категория обязательна',
            'status.in' => 'Статус должен быть: ' . implode(', ', TaskStatus::values()),
            'priority.in' => 'Приоритет должен быть: ' . implode(', ', TaskPriority::values()),
        ];
    }
}
