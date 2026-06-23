<?php

namespace App\Http\Controllers\Api\Tasks\Documentation;

use OpenApi\Attributes as OA;

#[OA\Get(
    path: "/api/tasks",
    operationId: "listTasks",
    summary: "Получить список задач",
    description: "Возвращает список задач с пагинацией, фильтрацией и сортировкой (Spatie Query Builder)",
    tags: ["Tasks"],
    parameters: [
        new OA\Parameter(
            name: "filter[search]",
            in: "query",
            description: "Поиск по названию задачи (частичное совпадение)",
            required: false,
            schema: new OA\Schema(type: "string")
        ),
        new OA\Parameter(
            name: "filter[status]",
            in: "query",
            description: "Фильтрация по статусу задачи",
            required: false,
            schema: new OA\Schema(type: "string", enum: ["pending", "completed"])
        ),
        new OA\Parameter(
            name: "filter[priority]",
            in: "query",
            description: "Фильтрация по приоритету задачи",
            required: false,
            schema: new OA\Schema(type: "string", enum: ["low", "medium", "high"])
        ),
        new OA\Parameter(
            name: "sort",
            in: "query",
            description: "Поле для сортировки. Префикс '-' для сортировки по убыванию",
            required: false,
            schema: new OA\Schema(
                type: "string",
                enum: ["due_date", "-due_date", "created_at", "-created_at", "created_date", "-created_date", "title", "-title", "priority", "-priority", "status", "-status"],
                default: "due_date"
            )
        ),
        new OA\Parameter(
            name: "per_page",
            in: "query",
            description: "Количество задач на странице",
            required: false,
            schema: new OA\Schema(type: "integer", default: 15, minimum: 1, maximum: 100)
        ),
        new OA\Parameter(
            name: "page",
            in: "query",
            description: "Номер страницы",
            required: false,
            schema: new OA\Schema(type: "integer", default: 1, minimum: 1)
        ),
    ],
    responses: [
        new OA\Response(
            response: 200,
            description: "Успешный ответ с пагинированным списком задач",
            content: new OA\JsonContent(
                type: "object",
                properties: [
                    new OA\Property(property: "current_page", type: "integer", example: 1),
                    new OA\Property(
                        property: "data",
                        type: "array",
                        items: new OA\Items(
                            type: "object",
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
                    new OA\Property(property: "first_page_url", type: "string", example: "http://localhost:8000/api/tasks?page=1"),
                    new OA\Property(property: "from", type: "integer", example: 1),
                    new OA\Property(property: "last_page", type: "integer", example: 3),
                    new OA\Property(property: "last_page_url", type: "string", example: "http://localhost:8000/api/tasks?page=3"),
                    new OA\Property(property: "next_page_url", type: "string", nullable: true, example: "http://localhost:8000/api/tasks?page=2"),
                    new OA\Property(property: "path", type: "string", example: "http://localhost:8000/api/tasks"),
                    new OA\Property(property: "per_page", type: "integer", example: 15),
                    new OA\Property(property: "prev_page_url", type: "string", nullable: true, example: null),
                    new OA\Property(property: "to", type: "integer", example: 15),
                    new OA\Property(property: "total", type: "integer", example: 42),
                ]
            )
        )
    ]
)]
class TaskIndexDocs
{
    //
}
