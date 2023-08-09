<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HistoryViolation;
use Illuminate\Support\Facades\Validator;

class TeacherDataViolationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    // add 1 student data violation
    public function addViolation(
        Request $request
    ) {
        $this->authorize('teacher-create', DataViolation::class);

        $validator = Validator::make($request->all(), [
            'violation_id' => ['required', 'exists:violations,id'],
            'student_id' => ['required', 'exists:students,id'],
            'date' => ['required', 'date'],
            'description' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Terjadi kesalahan dengan data yang dikirim',
                'error' => $validator->errors()
            ]);
        }

        $teacher = $request->user();

        $teacher->dataViolations()->create($request->all());

        HistoryViolation::create([
            'teacher_id' => $teacher->id,
            'student_id' => $request->student_id,
            'violation_id' => $request->violation_id,
            'date' => $request->date
        ]);

        return response()->json(['message' => 'Pelanggaran berhasil ditambahkan']);
    }

    public function addViolations(request $request)
    {
        $this->authorize('teacher-create', DataViolation::class);

        $validator = Validator::make($request->all(), [
            'violation_id' => ['required', 'exists:violations,id'],
            'students' => ['required', 'array'],
            'date' => ['required', 'date'],
            'description' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Terjadi kesalahan dengan data yang dikirim',
                'error' => $validator->errors()
            ]);
        }

        $teacher = $request->user();
        $validated = $validator->validate();

        foreach ($validated['students'] as $student) {
            $data = [
                'violation_id' => $validated['iolation_id'],
                'student_id' => $student,
                'date' => $validated['date'],
                'description' => $validated['description'],
            ];

            $teacher->dataViolations()->create($data);

            HistoryViolation::create([
                'teacher_id' => $teacher->id,
                'student_id' => $student,
                'violation_id' => $request->violation_id,
                'date' => $request->date
            ]);
        }

        return response()->json(['message' => 'Pelanggaran berhasil ditambahkan']);
    }
}
