<?php

namespace App\Http\Controllers\Api\Tasks\Documentation;

use OpenApi\Attributes as OA;

#[OA\Put(
    path: "/api/tasks/{id}",
    operationId: "updateTask",
    summary: "Обновить задачу",
    description: "Обновляет информацию о задаче (все поля опциональны)",
    tags: ["Tasks"],
    parameters: [
        new OA\Parameter(
            name: "id",
            in: "path",
            description: "ID задачи",
            required: true,
            schema: new OA\Schema(type: "integer")
        ),
    ],
    requestBody: new OA\RequestBody(
        required: false,
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "title", type: "string", maxLength: 255, example: "Задача2"),
                new OA\Property(property: "description", type: "string", nullable: true, example: "Задача2 описание обновленное"),
                new OA\Property(property: "due_date", type: "string", format: "date-time", example: "2025-01-25T18:00:00"),
                new OA\Property(property: "created_date", type: "string", format: "date-time", example: "2025-01-20T15:00:00"),
                new OA\Property(property: "status", type: "string", enum: ["pending", "completed"], example: "completed"),
                new OA\Property(property: "priority", type: "string", enum: ["low", "medium", "high"], example: "low"),
                new OA\Property(property: "category", type: "string", maxLength: 100, example: "Личное"),
            ]
        )
    ),
    responses: [
        new OA\Response(
            response: 200,
            description: "Задача успешно обновлена",
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "message", type: "string", example: "Task updated successfully"),
                ]
            )
        ),
        new OA\Response(
            response: 404,
            description: "Задача не найдена"
        ),
        new OA\Response(
            response: 422,
            description: "Ошибка валидации"
        ),
    ]
)]
class TaskUpdateDocs
{
    //
}
