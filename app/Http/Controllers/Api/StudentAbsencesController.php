<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\StudentAbsence;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentAbsencesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function absenceStudent(Request $request)
    {
        try {
            $this->authorize('student-create', StudentAbsence::class);

            $student = $request->user();
            $now = Carbon::now()->format('Y-m-d');
            $time = Carbon::now()->format('H:i:s');

            $isAbsence = StudentAbsence::whereStudentId($student->id)->whereDate('date',$now)->first();

            if (!is_null($isAbsence)) {
                return response()->json([
                    'status' => 422,
                    'message' => 'Kamu telah melakukan absensi'
                ], 422);
            }

            $validated['student_id'] = $student->id;
            $validated['date'] = $now;
            $validated['time'] = $time;
            $validated['presence_id'] = 1;

            $student->studentAbsences()->create($validated);

            return response()->json([
                'status' => 200,
                'message' => 'Absen berhasil ditambahkan'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ]);
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
                ]);
            }
            
            $validated = $validate->validate();

            $student = Student::findOrFail($validated['student_id']);
            
            $now = Carbon::now()->format('Y-m-d');
            $time = Carbon::now()->format('H:i:s');

            $isAbsence = StudentAbsence::whereStudentId($student->id)->whereDate('date',$now)->first();

            if (!is_null($isAbsence)) {
                return response()->json([
                    'status' => 422,
                    'message' => 'Kamu telah melakukan absensi'
                ], 422);
            }

            $validated['date'] = $now;
            $validated['time'] = $time;

            $student->studentAbsences()->create($validated);

            return response()->json([
                'status' => 200,
                'message' => 'Absen berhasil ditambahkan'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ]);
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
