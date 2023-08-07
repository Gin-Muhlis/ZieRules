<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataAchievmentResource;
use App\Http\Resources\DataAchievmentCollection;

class StudentDataAchievmentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    public function studentAchievments(Request $request)
    {
        $student = $request->user();

        $this->authorize('student-view', $student);

        $results = [];
        $total_point = 0;

        foreach ($student->dataAchievments as $achievment) {
            $total_point += $achievment->achievment->point;
            $results[] = [
                'id' => $achievment->id,
                'name' => $achievment->achievment->name,
                'point' => $achievment->achievment->point,
                'teacher' => $achievment->teacher->name,
                'description' => $achievment->description
            ];
        }

        return response()->json([
            'total_point' => $total_point,
            'data_achievments' => $results
        ]);
    }

    public function store(
        Request $request,
        Student $student
    ): DataAchievmentResource {
        $this->authorize('create', DataAchievment::class);

        $validated = $request->validate([
            'achievment_id' => ['required', 'exists:achievments,id'],
            'teacher_id' => ['required', 'exists:teachers,id'],
            'date' => ['required', 'date'],
            'description' => ['required', 'string'],
        ]);

        $dataAchievment = $student->dataAchievments()->create($validated);

        return new DataAchievmentResource($dataAchievment);
    }
}
