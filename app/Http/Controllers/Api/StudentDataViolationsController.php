<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataViolationResource;
use App\Http\Resources\DataViolationCollection;
use App\Models\DataViolation;

class StudentDataViolationsController extends Controller
{

    /**
     * inisialisasi middleware
     */
    public function __construct()
    {
        return $this->middleware('auth:sanctum');
    }

    public function studentViolations(Request $request)
    {
        $student = $request->user();
        $this->authorize('student-view', $student);

        $results = [];
        $total_point = 0;

        foreach ($student->dataViolations as $violation) {
            $total_point += $violation->violation->point;
            $results[] = [
                'id' => $violation->id,
                'name' => $violation->violation->name,
                'point' => $violation->violation->point,
                'teacher' => $violation->teacher->name,
                'description' => $violation->description
            ];
        }

        return response()->json([
            'total_point' => $total_point,
            'data_violations' => $results
        ]);
    }

    public function store(
        Request $request
    ) {
        $this->authorize('create', DataViolation::class);

        $validated = $request->validate([
            'violation_id' => ['required', 'exists:violations,id'],
            'teacher_id' => ['required', 'exists:teachers,id'],
            'date' => ['required', 'date'],
            'description' => ['required', 'string'],
        ]);

        $student = $request->user();

        $student->dataViolations()->create($validated);

        return response()->json(['message' => 'Pelanggaran berhasil ditambahkan']);
    }
}
