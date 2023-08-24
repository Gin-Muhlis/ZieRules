<?php

namespace App\Http\Controllers\Api;

use App\Models\Violation;
use App\Http\Controllers\Controller;
use App\Http\Resources\ViolationResource;
use App\Http\Resources\ViolationCollection;
use Exception;

class ViolationController extends Controller
{
    /**
     * inisialisasi middleware
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function indexStudent()
    {
        try {
            $this->authorize('student-view-any', Violation::class);

            $violations = Violation::latest()->get();

            $dataViolations = ViolationResource::collection($violations);

            return response()->json([
                'status' => 200,
                'dataViolation' => $dataViolations
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Terjadi kesalahan dengan data yang dikirim',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function indexTeacher()
    {
        try {
            $this->authorize('teacher-view-any', Violation::class);

            $violations = Violation::latest()->get();
            $dataViolations = ViolationResource::collection($violations);

            return response()->json([
                'status' => 200,
                'dataViolation' => $dataViolations
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Terjadi kesalahan dengan data yang dikirim',
                'error' => $e->getMessage()
            ]);
        }
    }
}
