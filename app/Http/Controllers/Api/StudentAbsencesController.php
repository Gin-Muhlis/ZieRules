<?php

namespace App\Http\Controllers\Api;

require_once app_path() . '/helpers/helpers.php';

use Exception;
use Carbon\Carbon;
use App\Models\Student;
use App\Models\Presence;
use Illuminate\Http\Request;
use App\Models\StudentAbsence;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class StudentAbsencesController extends Controller
{
    public function __construct() {
        $this->middleware('auth:sanctum')->except('absenceStudent');
    }
    public function absenceStudent(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'code' => ['required']
            ]);

            if ($validate->fails()) {
                return response()->json([
                    'status' => 422,
                    'message' => 'Terjadi kesalahan dengan data yang dikirim'
                ], 422);
            }

            $validated = $validate->validate();

            $student = Student::where('code', $validated['code'])->first();

            if (is_null($student)) {
                return response()->json([
                    'status' => 422,
                    'message' => 'Siswa tidak valid/tidak ditemukan'
                ], 422);
            }

            $now = Carbon::now()->format('Y-m-d');
            $time = Carbon::now()->format('H:i:s');

            $isAbsence = StudentAbsence::whereStudentId($student->id)->whereDate('date',$now)->first();

            if (!is_null($isAbsence)) {
                return response()->json([
                    'status' => 422,
                    'message' => 'Kamu telah melakukan absensi'
                ], 422);
            }

            $presence = Presence::whereName('hadir')->first();

            $validated['student_id'] = $student->id;
            $validated['date'] = $now;
            $validated['time'] = $time;
            $validated['presence_id'] = $presence->id;

            DB::beginTransaction();

            $student->studentAbsences()->create($validated);

            DB::commit();

            $dataStudent = [
                'name' => $student->name,
                'class' => $student->class->code
            ];

            return response()->json([
                'status' => 200,
                'student' => $dataStudent,
                'date' => generateDate($validated['date']),
                'time' => $validated['time'],
                'message' => 'Absen berhasil ditambahkan'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function TeacherAbsenceStudent(Request $request)
    {
        try {
            $this->authorize('teacher-create', StudentAbsence::class);

            $validate = $this->validateInput($request->all());

            if ($validate->fails()) {
                return response()->json([
                    'status' => 422,
                    'message' => 'Terjadi kesalahan dengan data yang dikirim',
                    'errors' => $validate->errors()
                ], 422);
            }
            
            $validated = $validate->validate();

            $student = Student::findOrFail($validated['student_id']);
            
            $now = Carbon::now()->format('Y-m-d');
            $time = Carbon::now()->format('H:i:s');

            $isAbsence = StudentAbsence::whereStudentId($student->id)->whereDate('date',$now)->first();

            if (!is_null($isAbsence)) {
                return response()->json([
                    'status' => 422,
                    'message' => 'Siswa telah melakukan absensi'
                ], 422);
            }

            $validated['date'] = $now;
            $validated['time'] = $time;

            DB::beginTransaction();

            $student->studentAbsences()->create($validated);

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Absen berhasil ditambahkan'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function validateInput($data) {
        return Validator::make($data,  [
            'student_id' => ['required', 'exists:students,id'],
            'presence_id' => ['required', 'exists:presences,id'],
        ], [
            'student_id.required' => 'Siswa tidak boleh kosong',
            'student_id.exists' => 'Siswa tidak ditemukan',
            'presence_id.required' => 'Kehadiran tidak boleh kosong',
            'presence_id.exists' => 'Kehadiran tidak valid'
        ]);
    }


    
}
