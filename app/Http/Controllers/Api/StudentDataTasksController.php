<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataTaskResource;
use App\Http\Resources\DataTaskCollection;

class StudentDataTasksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function studentTasks(Request $request)
    {
        $student = $request->user();

        $this->authorize('student-view', $student);

        $results = [];

        foreach ($student->dataTasks as $task) {
            $results = [
                'id' => $task->id,
                'name' => $task->task->name
            ];
        }

        return response()->json($results);
    }

    public function store(Request $request, Student $student): DataTaskResource
    {
        $this->authorize('create', DataTask::class);

        $validated = $request->validate([
            'task_id' => ['required', 'exists:tasks,id'],
            'teacher_id' => ['required', 'exists:teachers,id'],
            'date' => ['required', 'date'],
            'description' => ['required', 'string'],
        ]);

        $dataTask = $student->dataTasks()->create($validated);

        return new DataTaskResource($dataTask);
    }
}
