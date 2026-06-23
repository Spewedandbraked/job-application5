<?php

use App\Http\Controllers\TaskController;
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
Route::get('/', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
