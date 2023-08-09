<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataAchievmentResource;

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
}
