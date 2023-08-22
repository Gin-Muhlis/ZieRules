<?php

namespace App\Http\Controllers\Api;

require_once app_path() . '/helpers/helpers.php';

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentDataViolationsController extends Controller
{

    /**
     * inisialisasi middleware
     */
    public function __construct()
    {
       $this->middleware('auth:sanctum');
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
                'date' => generateDate($violation->date->toDateString()),
                'description' => $violation->description
            ];
        }

        return response()->json([
            'status' => 200,
            'totalPoint' => $total_point,
            'dataViolation' => $results
        ]);
    }
}
