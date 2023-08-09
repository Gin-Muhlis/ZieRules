<?php

namespace App\Http\Controllers\Api;

use App\Models\Violation;
use App\Http\Controllers\Controller;
use App\Http\Resources\ViolationResource;
use App\Http\Resources\ViolationCollection;

class ViolationController extends Controller
{
    /**
     * inisialisasi middleware
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * get all violation
     * @return ViolationCollection
     */
    public function indexStudent()
    {
        $this->authorize('student-view-any', Violation::class);

        $violations = Violation::latest()->get();

        return ViolationResource::collection($violations);
    }

    public function indexTeacher()
    {
        $this->authorize('teacher-view-any', Violation::class);

        $violations = Violation::latest()->get();

        return ViolationResource::collection($violations);
    }
}
