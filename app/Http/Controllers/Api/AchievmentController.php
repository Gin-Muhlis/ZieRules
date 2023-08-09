<?php

namespace App\Http\Controllers\Api;

use App\Models\Achievment;
use App\Http\Controllers\Controller;
use App\Http\Resources\AchievmentResource;

class AchievmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function indexStudent()
    {
        $this->authorize('student-view-any', Achievment::class);

        $achievments = Achievment::latest()->get();

        return AchievmentResource::collection($achievments);
    }

    public function indexTeacher()
    {
        $this->authorize('teacher-view-any', Achievment::class);

        $achievments = Achievment::latest()->get();

        return AchievmentResource::collection($achievments);
    }
}
