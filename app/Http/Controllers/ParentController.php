<?php

namespace App\Http\Controllers;

use App\Models\DataTask;
use App\Models\Homeroom;
use Illuminate\Http\Request;
use App\Models\DataViolation;
use App\Models\DataAchievment;
use App\Models\StudentAbsence;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ParentController extends Controller
{
    public function login()
    {

        return view('auth.parent-login');
    }

    public function auth(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nis' => ['required', 'numeric'],
            'password' => ['required']
        ], [
            'nis.required' => 'NIS diperlukan',
            'nis.numeric' => 'NIS tidak valid',
            'password.required' => 'Password diperlukan'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        $credentials = $validator->validated();

        if (!Auth::guard('parent')->attempt($credentials)) {
            return redirect()->back()->withErrors(['unathenticated', 'NIS atau Password salah']);
        }

        return redirect()->route('parent.home');
    }

    public function home()
    {
        $student = Auth::guard('parent')->user();
        $homeroom = Homeroom::where('class_id', $student->class->id)->first();

        $data_violation = DataViolation::where('student_id', $student->id)->get();
        $violations = [
            'violation_count' => count($data_violation),
            'data' => $data_violation,
        ];

        $data_achievement = DataAchievment::where('student_id', $student->id)->get();
        $achievements = [
            'achievement_count' => count($data_achievement),
            'data' => $data_achievement,
        ];

        $data_task = DataTask::where('student_id', $student->id)->get();
        $tasks = [
            'task_count' => count($data_task),
            'data' => $data_task,
        ];

        $presence = $this->generateReport($student);

        return view('parent-home', compact('violations', 'achievements', 'tasks', 'presence', 'student', 'homeroom'));
    }

    private function generateReport($student)
    {
        $result = [];

        $presences = 0;
        $permissions = 0;
        $sicks = 0;
        $withoutExplanations = 0;

        $absences = StudentAbsence::whereStudentId($student->id)->get();
        foreach ($absences as $absence) {
            $presences = strtolower($absence->presence->name) == 'hadir' ? $presences + 1 : $presences;
            $permissions = strtolower($absence->presence->name) == 'izin' ? $permissions + 1 : $permissions;
            $sicks = strtolower($absence->presence->name) == 'sakit' ? $sicks + 1 : $sicks;
            $withoutExplanations = strtolower($absence->presence->name) == 'tanpa keterangan' ? $withoutExplanations + 1 : $withoutExplanations;
        }

        $result = [
            'presences' => $presences,
            'permissions' => $permissions,
            'sicks' => $sicks,
            'without_explanations' => $withoutExplanations
        ];
        return $result;
    }
}
