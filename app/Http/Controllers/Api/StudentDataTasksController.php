<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
}
