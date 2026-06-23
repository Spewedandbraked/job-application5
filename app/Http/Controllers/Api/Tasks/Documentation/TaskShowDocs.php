<?php

namespace App\Http\Controllers\Api\Tasks\Documentation;

use OpenApi\Attributes as OA;

#[OA\Get(
    path: "/api/tasks/{id}",
    operationId: "getTaskById",
    summary: "Получить задачу по ID",
    description: "Возвращает информацию о конкретной задаче",
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
    responses: [
        new OA\Response(
            response: 200,
            description: "Успешный ответ",
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "id", type: "integer", example: 1),
                    new OA\Property(property: "title", type: "string", example: "Задача1"),
                    new OA\Property(property: "description", type: "string", nullable: true, example: "Описание задачи"),
                    new OA\Property(property: "due_date", type: "string", format: "date-time", example: "2025-01-20T15:00:00"),
                    new OA\Property(property: "created_date", type: "string", format: "date-time", example: "2025-01-20T15:00:00"),
                    new OA\Property(property: "status", type: "string", enum: ["pending", "completed"], example: "pending"),
                    new OA\Property(property: "priority", type: "string", enum: ["low", "medium", "high"], example: "high"),
                    new OA\Property(property: "category", type: "string", example: "Работа"),
                    new OA\Property(property: "created_at", type: "string", format: "date-time", example: "2025-01-20T15:00:00"),
                    new OA\Property(property: "updated_at", type: "string", format: "date-time", example: "2025-01-20T15:00:00"),
                ]
            )
        ),
        new OA\Response(
            response: 404,
            description: "Задача не найдена"
        ),
    ]
)]
class TaskShowDocs
{
    //
}
