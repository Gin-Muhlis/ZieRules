<?php

namespace App\Http\Controllers\Api;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\HistoryTaskResource;
use App\Http\Resources\HistoryTaskCollection;

class TaskHistoryTasksController extends Controller
{
    public function index(Request $request, Task $task): HistoryTaskCollection
    {
        $this->authorize('view', $task);

        $search = $request->get('search', '');

        $historyTasks = $task
            ->historyTasks()
            ->search($search)
            ->latest()
            ->paginate();

        return new HistoryTaskCollection($historyTasks);
    }

    public function store(Request $request, Task $task): HistoryTaskResource
    {
        $this->authorize('create', HistoryTask::class);

        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'teacher_id' => ['required', 'exists:teachers,id'],
            'date' => ['required', 'date'],
        ]);

        $historyTask = $task->historyTasks()->create($validated);

        return new HistoryTaskResource($historyTask);
    }
}
