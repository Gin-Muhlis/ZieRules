<?php

namespace App\Http\Controllers\Api;

use App\Models\Achievment;
use App\Http\Controllers\Controller;
use App\Http\Resources\AchievmentResource;
use Exception;

class AchievmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function indexStudent()
    {
        
        try {
            $this->authorize('student-view-any', Achievment::class);

            $achievments = Achievment::latest()->get();

            $dataAchievments = AchievmentResource::collection($achievments);
            return response()->json([
                'status' => 200,
                'achievments' => $dataAchievments
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function indexTeacher()
    {
        try {
            $this->authorize('teacher-view-any', Achievment::class);

            $achievments = Achievment::latest()->get();

            $dataAchievments = AchievmentResource::collection($achievments);
            return response()->json([
                'status' => 200,
                'achievments' => $dataAchievments
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
