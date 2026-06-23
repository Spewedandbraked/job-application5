<?php

namespace App\Http\Controllers\Api\Tasks\Documentation;

use OpenApi\Attributes as OA;

#[OA\Delete(
    path: "/api/tasks/{id}",
    operationId: "deleteTask",
    summary: "Удалить задачу",
    description: "Удаляет задачу по её ID",
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
            description: "Задача успешно удалена",
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "message", type: "string", example: "Task deleted successfully"),
                ]
            )
        ),
        new OA\Response(
            response: 404,
            description: "Задача не найдена"
        ),
    ]
)]
class TaskDestroyDocs
{
    //
}
