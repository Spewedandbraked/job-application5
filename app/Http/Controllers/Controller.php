<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: "Task Management API",
    version: "1.0.0",
    description: "REST API для управления списком задач"
)]
#[OA\Server(
    url: "http://localhost:8000",
    description: "Local server"
)]
#[OA\Tag(
    name: "Tasks",
    description: "Управление задачами"
)]
abstract class Controller
{
    //
}
