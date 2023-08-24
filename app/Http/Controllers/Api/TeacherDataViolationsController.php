<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HistoryViolation;
use Exception;
use Illuminate\Support\Facades\DB;
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
        try {
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

            $validated = $validator->validate();
            $teacher = $request->user();

            DB::beginTransaction();

            $teacher->dataViolations()->create($validated);

            HistoryViolation::create([
                'teacher_id' => $teacher->id,
                'student_id' => $request->student_id,
                'violation_id' => $request->violation_id,
                'date' => $request->date
            ]);

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Pelanggaran berhasil ditambahkan'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => 'Terjadi kesalahan dengan data yang dikirim',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function addViolations(request $request)
    {
        $this->authorize('teacher-create', DataViolation::class);

        $validator = Validator::make($request->all(), [
            'violation_id' => ['required', 'exists:violations,id'],
            'student_id' => ['required', 'array'],
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

        foreach ($validated['student_id'] as $student) {
            $validated['student_id'] = $student;
            $teacher->dataViolations()->create($validated);

            HistoryViolation::create([
                'teacher_id' => $teacher->id,
                'student_id' => $validated['student_id'],
                'violation_id' => $validated['violation_id'],
                'date' => $validated['date']
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Pelanggaran berhasil ditambahkan'
        ]);
    }
}
