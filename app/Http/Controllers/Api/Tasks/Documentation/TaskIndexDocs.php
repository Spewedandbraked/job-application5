<?php

namespace App\Http\Controllers\Api\Tasks\Documentation;

use OpenApi\Attributes as OA;

#[OA\Get(
    path: "/api/tasks",
    operationId: "listTasks",
    summary: "Получить список задач",
    description: "Возвращает список задач с пагинацией, поиском и сортировкой",
    tags: ["Tasks"],
    parameters: [
        new OA\Parameter(
            name: "search",
            in: "query",
            description: "Поиск по названию",
            required: false,
            schema: new OA\Schema(type: "string")
        ),
        new OA\Parameter(
            name: "sort",
            in: "query",
            description: "Поле для сортировки",
            required: false,
            schema: new OA\Schema(type: "string", enum: ["due_date", "created_at", "created_date", "title", "priority", "status"])
        ),
        new OA\Parameter(
            name: "per_page",
            in: "query",
            description: "Количество задач на странице",
            required: false,
            schema: new OA\Schema(type: "integer", default: 15)
        ),
    ],
    responses: [
        new OA\Response(
            response: 200,
            description: "Успешный ответ",
            content: new OA\JsonContent(
                type: "object",
                properties: [
                    new OA\Property(property: "current_page", type: "integer"),
                    new OA\Property(
                        property: "data",
                        type: "array",
                        items: new OA\Items(
                            type: "object",
                            properties: [
                                new OA\Property(property: "id", type: "integer"),
                                new OA\Property(property: "title", type: "string"),
                                new OA\Property(property: "description", type: "string", nullable: true),
                                new OA\Property(property: "due_date", type: "string", format: "date-time"),
                                new OA\Property(property: "created_date", type: "string", format: "date-time"),
                                new OA\Property(property: "status", type: "string", enum: ["pending", "completed"]),
                                new OA\Property(property: "priority", type: "string", enum: ["low", "medium", "high"]),
                                new OA\Property(property: "category", type: "string"),
                            ]
                        )
                    ),
                    new OA\Property(property: "first_page_url", type: "string"),
                    new OA\Property(property: "from", type: "integer"),
                    new OA\Property(property: "last_page", type: "integer"),
                    new OA\Property(property: "last_page_url", type: "string"),
                    new OA\Property(property: "next_page_url", type: "string", nullable: true),
                    new OA\Property(property: "path", type: "string"),
                    new OA\Property(property: "per_page", type: "integer"),
                    new OA\Property(property: "prev_page_url", type: "string", nullable: true),
                    new OA\Property(property: "to", type: "integer"),
                    new OA\Property(property: "total", type: "integer"),
                ]
            )
        )
    ]
)]
class TaskIndexDocs
{
    //
}
