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

    public function historyScans(Request $request)
    {
        $teacher = $request->user();

        $this->authorize('teacher-view', $teacher);

        $historyScansViolation = $teacher->historyViolations;
        $historyScansAchievment = $teacher->historyAchievments;
        $historyScansTasks = $teacher->historytasks;


        $historyScans = $this->generateHistory($historyScansViolation, $historyScansAchievment, $historyScansTasks);

        return response()->json($historyScans);
    }

    private function generateHistory($violations, $achievments, $tasks)
    {
        $dataViolations = [];
        foreach ($violations as  $violation) {
            $dataViolations[] = [
                'teacher' => $violation->teacher->name,
                'student' => $violation->student->name,
                'violation' => $violation->violation->name,
                'date' => $violation->date->toDateString()
            ];
        }

        $dataAchievments = [];
        foreach ($achievments as  $achievment) {
            $dataAchievments[] = [
                'teacher' => $achievment->teacher->name,
                'student' => $achievment->student->name,
                'aachievment' => $achievment->achievment->name,
                'date' => $achievment->date->toDateString()
            ];
        }

        $dataTasks = [];
        foreach ($tasks as  $task) {
            $dataTasks[] = [
                'teacher' => $task->teacher->name,
                'student' => $task->student->name,
                'task' => $task->task->name,
                'date' => $task->date->toDateString()
            ];
        }

        $result = array_merge($dataViolations, $dataAchievments, $dataTasks);

        usort($result, function ($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });

        return $result;
    }
}
