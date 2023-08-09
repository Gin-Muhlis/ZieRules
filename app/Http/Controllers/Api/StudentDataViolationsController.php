<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
}
