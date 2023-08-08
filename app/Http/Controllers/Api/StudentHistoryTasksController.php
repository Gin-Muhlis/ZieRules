<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\HistoryTaskResource;
use App\Http\Resources\HistoryTaskCollection;

class StudentHistoryTasksController extends Controller
{
    public function index(
        Request $request,
        Student $student
    ): HistoryTaskCollection {
        $this->authorize('view', $student);

        $search = $request->get('search', '');

        $historyTasks = $student
            ->historyTasks()
            ->search($search)
            ->latest()
            ->paginate();

        return new HistoryTaskCollection($historyTasks);
    }

    public function store(
        Request $request,
        Student $student
    ): HistoryTaskResource {
        $this->authorize('create', HistoryTask::class);

        $validated = $request->validate([
            'teacher_id' => ['required', 'exists:teachers,id'],
            'task_id' => ['required', 'exists:tasks,id'],
            'date' => ['required', 'date'],
        ]);

        $historyTask = $student->historyTasks()->create($validated);

        return new HistoryTaskResource($historyTask);
    }
}
