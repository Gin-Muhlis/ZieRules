<?php

namespace App\Http\Controllers\Api;

use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataTaskResource;
use App\Http\Resources\DataTaskCollection;

class TeacherDataTasksController extends Controller
{
    public function index(
        Request $request,
        Teacher $teacher
    ): DataTaskCollection {
        $this->authorize('view', $teacher);

        $search = $request->get('search', '');

        $dataTasks = $teacher
            ->dataTasks()
            ->search($search)
            ->latest()
            ->paginate();

        return new DataTaskCollection($dataTasks);
    }

    public function store(Request $request, Teacher $teacher): DataTaskResource
    {
        $this->authorize('create', DataTask::class);

        $validated = $request->validate([
            'task_id' => ['required', 'exists:tasks,id'],
            'student_id' => ['required', 'exists:students,id'],
            'date' => ['required', 'date'],
            'description' => ['required', 'string'],
        ]);

        $dataTask = $teacher->dataTasks()->create($validated);

        return new DataTaskResource($dataTask);
    }
}
