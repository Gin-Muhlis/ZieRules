<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataTaskResource;
use App\Http\Resources\DataTaskCollection;

class StudentDataTasksController extends Controller
{
    public function index(
        Request $request,
        Student $student
    ): DataTaskCollection {
        $this->authorize('view', $student);

        $search = $request->get('search', '');

        $dataTasks = $student
            ->dataTasks()
            ->search($search)
            ->latest()
            ->paginate();

        return new DataTaskCollection($dataTasks);
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
