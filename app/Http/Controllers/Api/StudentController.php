<?php

namespace App\Http\Controllers\Api;

require_once app_path() . '/helpers/helpers.php';

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DataAchievment;
use App\Models\DataTask;
use App\Models\DataViolation;
use App\Models\Presence;
use App\Models\StudentAbsence;
use Exception;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function profile(Request $request)
    {
        try {
            $this->authorize('student-view', Student::class);

            $student = $request->user();

            $dataViolations = DataViolation::with('teacher')->where('student_id', $student->id)->get();
            $dataAchievments = DataAchievment::with('teacher')->where('student_id', $student->id)->get();
            $dataTasks = DataTask::with('teacher')->where('student_id', $student->id)->get();

            $result = [
                'id' => $student->id,
                'code' => $student->code,
                'name' => $student->name,
                'nis' => $student->nis,
                'gender' => $student->gender,
                'image' => $student->image,
                'class' => $student->class->code,
                'role' => $student->getRoleNames()->first(),
                'dataViolations' => $dataViolations->count(),
                'dataAchievements' => $dataAchievments->count(),
                'dataTasks' => $dataTasks->count()
            ];

            return response()->json([
                'status' => 200,
                'student' => $result
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function detailSiswa($code)
    {
        try {
            $this->authorize('teacher-student-view', Student::class);
            $student = Student::whereCode($code)->first();
            return response()->json([
                'status' => 200,
                'id' => $student->id,
                'code' => $student->code,
                'nis' => $student->nis,
                'name' => $student->name,
                'image' => $student->image ?? 'public/default.jpg',
                'gender' => $student->gender,
                'class' => $student->class->name
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getAbsence(Request $request) {
        try {
            $this->authorize('student-view-any', StudentAbsence::class);

            $student = $request->user();

            $historyAbsence = [];

            $absenceStudent = StudentAbsence::with('presence')->whereStudentId($student->id)->orderBy('date', 'desc')->get();

            $presences = 0;
            $permissions = 0;
            $sicks = 0;
            $withoutExplanations = 0;

            foreach ($absenceStudent as $absence) {
                $presences = strtolower($absence->presence->name) == 'hadir' ? $presences + 1 : $presences;
                $permissions = strtolower($absence->presence->name) == 'izin' ? $permissions + 1 : $permissions;
                $sicks = strtolower($absence->presence->name) == 'sakit' ? $sicks + 1 : $sicks;
                $withoutExplanations = strtolower($absence->presence->name) == 'tanpa keterangan' ? $withoutExplanations + 1 : $withoutExplanations;
                $historyAbsence[] = [
                    'id' => $absence->id,
                    'date' => generateDate($absence->date->toDateString()),
                    'time' => $absence->time,
                    'presence' => $absence->presence->name
                ];
            }

            

            return response()->json([
                'status' => 200,
                'presences' => $presences,
                'permissions' => $permissions,
                'sicks' => $sicks,
                'withoutExplanations' => $withoutExplanations,
                'historyAbsence' => $historyAbsence
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 5000);
        }
    }
}
