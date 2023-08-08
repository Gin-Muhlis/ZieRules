<?php

namespace App\Http\Controllers\Api;

use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\HistoryTaskResource;
use App\Http\Resources\HistoryTaskCollection;

class TeacherHistoryTasksController extends Controller
{
    public function index(
        Request $request,
        Teacher $teacher
    ): HistoryTaskCollection {
        $this->authorize('view', $teacher);

        $search = $request->get('search', '');

        $historyTasks = $teacher
            ->historyTasks()
            ->search($search)
            ->latest()
            ->paginate();

        return new HistoryTaskCollection($historyTasks);
    }

    public function store(
        Request $request,
        Teacher $teacher
    ): HistoryTaskResource {
        $this->authorize('create', HistoryTask::class);

        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'task_id' => ['required', 'exists:tasks,id'],
            'date' => ['required', 'date'],
        ]);

        $historyTask = $teacher->historyTasks()->create($validated);

        return new HistoryTaskResource($historyTask);
    }
}
