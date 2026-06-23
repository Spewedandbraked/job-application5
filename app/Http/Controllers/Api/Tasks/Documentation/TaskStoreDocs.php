<?php

namespace App\Http\Controllers\Api\Tasks\Documentation;

use OpenApi\Attributes as OA;

#[OA\Post(
    path: "/api/tasks",
    operationId: "createTask",
    summary: "Создать новую задачу",
    description: "Создает новую задачу. По умолчанию: status='pending', priority='medium', created_date=now()",
    tags: ["Tasks"],
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["title", "due_date", "category"],
            properties: [
                new OA\Property(property: "title", type: "string", maxLength: 255, example: "Задача1"),
                new OA\Property(property: "description", type: "string", nullable: true, example: "Описание задачи"),
                new OA\Property(property: "due_date", type: "string", format: "date-time", example: "2025-01-20T15:00:00"),
                new OA\Property(property: "created_date", type: "string", format: "date-time", nullable: true, example: "2025-01-20T15:00:00", description: "Если не указано, устанавливается текущее время"),
                new OA\Property(property: "status", type: "string", enum: ["pending", "completed"], example: "pending", default: "pending"),
                new OA\Property(property: "priority", type: "string", enum: ["low", "medium", "high"], example: "high", default: "medium"),
                new OA\Property(property: "category", type: "string", maxLength: 100, example: "Работа"),
            ]
        )
    ),
    responses: [
        new OA\Response(
            response: 201,
            description: "Задача успешно создана",
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "id", type: "integer", example: 1),
                    new OA\Property(property: "message", type: "string", example: "Task created successfully"),
                ]
            )
        ),
        new OA\Response(
            response: 422,
            description: "Ошибка валидации",
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "message", type: "string", example: "The given data was invalid."),
                    new OA\Property(
                        property: "errors",
                        type: "object",
                        properties: [
                            new OA\Property(property: "title", type: "array", items: new OA\Items(type: "string", example: "Поле Название обязательно для заполнения.")),
                            new OA\Property(property: "due_date", type: "array", items: new OA\Items(type: "string", example: "Поле Срок выполнения обязательно для заполнения.")),
                            new OA\Property(property: "category", type: "array", items: new OA\Items(type: "string", example: "Поле Категория обязательно для заполнения.")),
                        ]
                    ),
                ]
            )
        ),
    ]
)]
class TaskStoreDocs
{
    //
}
