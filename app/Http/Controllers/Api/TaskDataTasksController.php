<?php

namespace App\Http\Controllers\Api;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataTaskResource;
use App\Http\Resources\DataTaskCollection;

class TaskDataTasksController extends Controller
{
    public function index(Request $request, Task $task): DataTaskCollection
    {
        $this->authorize('view', $task);

        $search = $request->get('search', '');

        $dataTasks = $task
            ->dataTasks()
            ->search($search)
            ->latest()
            ->paginate();

        return new DataTaskCollection($dataTasks);
    }

    public function store(Request $request, Task $task): DataTaskResource
    {
        $this->authorize('create', DataTask::class);

        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'teacher_id' => ['required', 'exists:teachers,id'],
            'date' => ['required', 'date'],
            'description' => ['required', 'string'],
        ]);

        $dataTask = $task->dataTasks()->create($validated);

        return new DataTaskResource($dataTask);
    }
}
