<?php

use Illuminate\Support\Facades\Route;
/**
 * @OA\Info(
 *     title="Task Management API",
 *     version="1.0.0",
 *     description="REST API для управления списком задач"
 * )
 *
 * @OA\Server(
 *     url="http://localhost:8000",
 *     description="Local server"
 * )
 *
 * @OA\Tag(
 *     name="Tasks",
 *     description="Управление задачами"
 * )
 */
Route::get('/', function () {
    return view('welcome');
});
