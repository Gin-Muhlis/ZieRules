<?php

namespace App\Http\Controllers\Api;

require_once app_path() . '/helpers/helpers.php';

use Exception;
use Carbon\Carbon;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Presence;
use Illuminate\Http\Request;
use App\Models\StudentAbsence;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use App\Http\Resources\TeacherResource;

class TeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function profile(Request $request)
    {
        try {
            $this->authorize('teacher-view', Teacher::class);

            $teacher = $request->user();

            $dataTeacher = new TeacherResource($teacher);
            return response()->json([
                'status' => 200,
                'dataTeacher' => $dataTeacher
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function allStudent()
    {
        try {
            $this->authorize('student-view-any', Student::class);
            $students = Student::all();

            return response()->json([
                'status' => 200,
                'students' => $students
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function listStudent(Request $request)
    {
        
        try {
            $this->authorize('student-view-any', Student::class);

            $teacher = $request->user();

            $listStudent = Student::where('class_id', $teacher->homeroom->class_id)->get();

            $dataListStudent = StudentResource::collection($listStudent);
            return response()->json([
                'status' => 200,
                'students' => $dataListStudent
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function historyScans(Request $request)
    {
        try {
            $teacher = $request->user();

            $this->authorize('teacher-view', $teacher);

            $historyScansViolation = $teacher->historyViolations;
            $historyScansAchievment = $teacher->historyAchievments;
            $historyScansTasks = $teacher->historytasks;


            $historyScans = $this->generateHistory($historyScansViolation, $historyScansAchievment, $historyScansTasks);

            return response()->json([
                'status' => 200,
                'dataHistoryScan' => $historyScans
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Summary of studentsPresence
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function presences(Request $request)
    {
        try {
            $this->authorize('teacher-view-any', StudentAbsence::class);
     
            $teacher = $request->user();

            $students = Student::with('studentAbsences')->whereClassId($teacher->homeroom->class_id)->get();

            $result = [];
            $date = Carbon::now()->format('Y-m-d');

            foreach ($students as $student) {
                $absence = StudentAbsence::with('presence')->where([
                    ['date', $date],
                    ['student_id', $student->id]
                ])->first();
                $result[] = [
                    'student' => $student->name,
                    'student_id' => $student->id,
                    'presence' => !is_null($absence) ? $absence->presence->name : 'tidak masuk',
                    'time' => !is_null($absence) ? $absence->time : null,
                ];
            }

            return response()->json([
                'status' => 200,
                'dataPresence' => $result
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function generateHistory($violations, $achievments, $tasks)
    {
        try {
                $dataViolations = [];
            foreach ($violations as  $violation) {
                $dataViolations[] = [
                    'type' => 'violation',
                    'teacher' => $violation->teacher->name,
                    'student' => $violation->student->name,
                    'name' => $violation->violation->name,
                    'date' => generateDate($violation->date->toDateString()),
                    'order' => $violation->date->toDateString()
                ];
            }

            $dataAchievments = [];
            foreach ($achievments as  $achievment) {
                $dataAchievments[] = [
                    'type' => 'achievment',
                    'teacher' => $achievment->teacher->name,
                    'student' => $achievment->student->name,
                    'name' => $achievment->achievment->name,
                    'date' => generateDate($achievment->date->toDateString()),
                    'order' => $achievment->date->toDateString()
                ];
            }

            $dataTasks = [];
            foreach ($tasks as  $task) {
                $dataTasks[] = [
                    'type' => 'task',
                    'teacher' => $task->teacher->name,
                    'student' => $task->student->name,
                    'name' => $task->task->name,
                    'date' => generateDate($task->date->toDateString()),
                    'order' => $task->date->toDateString()
                ];
            }

            $result = array_merge($dataAchievments, $dataViolations, $dataTasks);

            usort($result, function ($a, $b) {
                return strtotime($b['order']) - strtotime($a['order']);
            });

            return $result;
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function listPresence() {
        try {
            $this->authorize('teacher-view-any', Presence::class);

            $listPresence = Presence::all();

            $result = [];

            foreach($listPresence as $item) {
                $result[] = [
                    'id' => $item->id,
                    'prsence' => $item->name
                 ];
            }

            return response()->json([
                'status' => 200,
                'listPresence' => $result
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
