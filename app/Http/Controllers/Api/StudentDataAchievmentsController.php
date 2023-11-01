<?php

namespace App\Http\Controllers\Api;

require_once app_path() . '/helpers/helpers.php';

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class StudentDataAchievmentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    public function studentAchievments(Request $request)
    {
       try {
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
                'date' => generateDate($achievment->date->toDateString()),
                'description' => $achievment->description
            ];
        }

        return response()->json([
            'status' => 200,
            'totalPoint' => $total_point,
            'dataAchievments' => $results
        ]);
       } catch (Exception $e) {
        return response()->json([
          'status' => 500,
          'message' => 'Terjadi kesalahan',
          'error' => $e->getMessage()
        ], 500);
       }
    }
}
