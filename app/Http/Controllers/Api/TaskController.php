<?php

namespace App\Http\Controllers\Api;

use App\Models\Task;
use App\Http\Resources\TaskResource;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function indexStudent()
    {
        $this->authorize('student-view-any', Task::class);

        $tasks = Task::latest()->get();

        $dataTasks = TaskResource::collection($tasks);
        return response()->json([
            'status' => 200,
            'dataTask' => $dataTasks
        ]);
    }

    public function indexTeacher()
    {
        $this->authorize('teacher-view-any', Task::class);

        $tasks = Task::latest()->get();

        $dataTasks = TaskResource::collection($tasks);
        return response()->json([
            'status' => 200,
            'dataTask' => $dataTasks
        ]);
    }
}
