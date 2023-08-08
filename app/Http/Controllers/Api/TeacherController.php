<?php

namespace App\Http\Controllers\Api;

use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\HistoryScanResource;
use App\Http\Resources\StudentResource;
use App\Http\Resources\TeacherResource;
use App\Models\Student;

class TeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function profile(Request $request)
    {
        $this->authorize('teacher-view', Teacher::class);

        $teacher = $request->user();

        return new TeacherResource($teacher);
    }

    public function listStudent(Request $request)
    {
        $this->authorize('student-view-any', Student::class);

        $teacher = $request->user();


        $listStudent = Student::where('class_id', $teacher->homerooms[0]->class_id)->get();

        return StudentResource::collection($listStudent);
    }

    public function historyScan(Request $request)
    {
        $teacher = $request->user();

        $this->authorize('teacher-view', $teacher);

        $historyScans = $teacher->historyScans;

        return HistoryScanResource::collection($historyScans);
    }
}
