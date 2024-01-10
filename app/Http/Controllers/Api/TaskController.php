<?php

namespace App\Http\Controllers\Api;

use App\Models\Task;
use App\Http\Resources\TaskResource;
use App\Http\Controllers\Controller;
use Exception;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function indexStudent()
    {
        try {
            $this->authorize('student-view-any', Task::class);

            $tasks = Task::latest()->get();

            $dataTasks = TaskResource::collection($tasks);
            return response()->json([
                'status' => 200,
                'dataTask' => $dataTasks
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
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
