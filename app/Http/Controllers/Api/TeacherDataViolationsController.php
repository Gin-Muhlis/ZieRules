<?php

namespace App\Http\Controllers\Api;

use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataViolationResource;
use App\Http\Resources\DataViolationCollection;
use App\Models\HistoryScan;
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

        HistoryScan::create([
            'teacher_id' => $teacher->id,
            'student_id' => $request->student_id
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

        foreach ($request->students as $student) {
            $data = [
                'violation_id' => $request->violation_id,
                'student_id' => $student,
                'date' => $request->date,
                'description' => $request->description,
            ];


            $teacher->dataViolations()->create($data);

            HistoryScan::create([
                'teacher_id' => $teacher->id,
                'student_id' => $student
            ]);
        }

        return response()->json(['message' => 'Pelanggaran berhasil ditambahkan']);
    }
}
