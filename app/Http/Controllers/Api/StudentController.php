<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\StudentResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\StudentCollection;
use App\Http\Requests\StudentStoreRequest;
use App\Http\Requests\StudentUpdateRequest;
use App\Models\DataAchievment;
use App\Models\DataTask;
use App\Models\DataViolation;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function profile(Request $request)
    {
        $this->authorize('student-view', Student::class);

        $student = $request->user();

        $dataViolations = DataViolation::with('teacher')->where('student_id', $student->id)->get();
        $dataAchievments = DataAchievment::with('teacher')->where('student_id', $student->id)->get();
        $dataTasks = DataTask::with('teacher')->where('student_id', $student->id)->get();

        $result = [
            'status' => 200,
            'student' => [
                'name' => $student->name,
                'nis' => $student->nis,
                'gender' => $student->gender,
                'image' => $student->image,
                'class' => $student->class->code,
                'role' => $student->getRoleNames()->first()
            ],
            'dataViolations' => $dataViolations->count(),
            'dataAchievements' => $dataAchievments->count(),
            'dataTasks' => $dataTasks->count()
        ];

        return response()->json($result);
    }

    public function detailSiswa($nis)
    {
        $this->authorize('teacher-student-view', Student::class);
        $student = Student::whereNis($nis)->first();

        return response()->json($student);
    }
}
