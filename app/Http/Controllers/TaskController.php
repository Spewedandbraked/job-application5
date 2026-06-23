<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(): View
    {
        return view('pages.tasks.index');
    }

    public function create(): View
    {
        return view('pages.tasks.create');
    }

    public function edit(int $id): View
    {
        return view('pages.tasks.edit', ['taskId' => $id]);
    }
}
