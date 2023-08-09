<?php

namespace App\Http\Controllers\Api;

use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataTaskResource;
use App\Http\Resources\DataTaskCollection;
use App\Models\HistoryTask;
use Illuminate\Support\Facades\Validator;

class TeacherDataTasksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function addTask(Request $request,)
    {
        $this->authorize('teacher-create', DataTask::class);

        $teacher = $request->user();

        $validate = Validator::make($request->all(), [
            'task_id' => ['required', 'exists:tasks,id'],
            'student_id' => ['required', 'exists:students,id'],
            'date' => ['required', 'date'],
            'description' => ['required', 'string'],
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Terjadi kesalahan dengan data yang dikirim',
                'errors' => $validate->errors()
            ]);
        }

        $validated = $validate->validate();

        $teacher->dataTasks()->create($validated);

        HistoryTask::create([
            'student_id' => $validated['student_id'],
            'teacher_id' => $teacher->id,
            'task_id' => $validated['task_id'],
            'date' => $validated['date']
        ]);

        return response()->json(['message' => 'Pencapaian tugas berhasil ditambahkan']);
    }

    public function addTasks(Request $request,)
    {
        $this->authorize('teacher-create', DataTask::class);

        $teacher = $request->user();

        $validate = Validator::make($request->all(), [
            'task_id' => ['required', 'exists:tasks,id'],
            'student_id' => ['required', 'exists:students,id'],
            'date' => ['required', 'date'],
            'description' => ['required', 'string'],
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Terjadi kesalahan dengan data yang dikirim',
                'errors' => $validate->errors()
            ]);
        }

        $validated = $validate->validate();

        foreach ($validated['student_id'] as $student) {
            $validated['student_id'] = $student;
            $teacher->dataTasks()->create($validated);

            HistoryTask::create([
                'student_id' => $validated['student_id'],
                'teacher_id' => $teacher->id,
                'task_id' => $validated['task_id'],
                'date' => $validated['date']
            ]);
        }

        return response()->json(['message' => 'Pencapaian tugas berhasil ditambahkan']);
    }
}
