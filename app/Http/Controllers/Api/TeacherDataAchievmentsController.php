<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HistoryAchievment;
use Illuminate\Support\Facades\Validator;

class TeacherDataAchievmentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function addAchievment(Request $request)
    {
        $this->authorize('teacher-create', DataAchievment::class);



        $validate = Validator::make($request->all(), [
            'achievment_id' => ['required', 'exists:achievments,id'],
            'student_id' => ['required', 'exists:students,id'],
            'date' => ['required', 'date'],
            'description' => ['required', 'string'],
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Terjadi kesalahan dengan data yang dikirim',
                'errors' => $validate->errors()
            ], 422);
        }

        $validated = $validate->validate();

        $teacher = $request->user();

        $teacher->dataAchievments()->create($validated);

        HistoryAchievment::create([
            'student_id' => $validated['student_id'],
            'teacher_id' => $teacher->id,
            'achievment_id' => $validated['achievment_id'],
            'date' => $validated['date']
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Prestasi berhasil ditambahkan'
        ]);
    }

    public function addAchievments(Request $request)
    {
        $this->authorize('teacher-create', DataAchievment::class);

        $validate = Validator::make($request->all(), [
            'achievment_id' => ['required', 'exists:achievments,id'],
            'student_id' => ['required', 'exists:students,id'],
            'date' => ['required', 'date'],
            'description' => ['required', 'string'],
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Terjadi kesalahan dengan data yang dikirim',
                'errors' => $validate->errors()
            ], 422);
        }

        $validated = $validate->validate();

        $teacher = $request->user();

        foreach ($validated['student_id'] as $student) {
            $validated['student_id'] = $student;
            $teacher->dataAchievments()->create($validated);

            HistoryAchievment::create([
                'student_id' => $validated['student_id'],
                'teacher_id' => $teacher->id,
                'achievment_id' => $validated['achievment_id'],
                'date' => $validated['date']
            ]);
        }


        return response()->json([
            'status' => 200,
            'message' => 'Prestasi berhasil ditambahkan'
        ]);
    }
}
