<?php

namespace App\Http\Controllers\Api\Tasks\Documentation;

use OpenApi\Attributes as OA;

#[OA\Post(
    path: "/api/tasks",
    operationId: "createTask",
    summary: "Создать новую задачу",
    description: "Создает новую задачу с переданными данными",
    tags: ["Tasks"],
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["title", "due_date", "category"],
            properties: [
                new OA\Property(property: "title", type: "string", maxLength: 255, example: "Задача1"),
                new OA\Property(property: "description", type: "string", nullable: true, example: "Задача1 описание"),
                new OA\Property(property: "due_date", type: "string", format: "date-time", example: "2025-01-20T15:00:00"),
                new OA\Property(property: "created_date", type: "string", format: "date-time", nullable: true, example: "2025-01-20T15:00:00"),
                new OA\Property(property: "status", type: "string", enum: ["pending", "completed"], example: "pending"),
                new OA\Property(property: "priority", type: "string", enum: ["low", "medium", "high"], example: "high"),
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
                    new OA\Property(property: "message", type: "string"),
                    new OA\Property(property: "errors", type: "object"),
                ]
            )
        ),
    ]
)]
class TaskStoreDocs
{
    //
}
