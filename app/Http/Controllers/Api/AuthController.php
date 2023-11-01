<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;
use Exception;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('loginStudent', 'loginTeacher');
    }

    /**
     * login for student
     * @param Request $request
     *
     * @return [type]
     */
    public function loginStudent(Request $request)
    {
        try {
            $credentials = $request->validate([
                'nis' => 'required',
                'password' => 'required'
            ]);

            if (!Auth::guard('student_api')->attempt($credentials)) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Nis atau Password Salah'
                ], 404);
            }

            $student = Student::with('class')->whereNis($request->nis)->firstOrFail();
            $token = $student->createToken('student-token');

            return response()->json([
                'status' => 200,
                'message' => 'Login Berhasil',
                'token' => $token->plainTextToken
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
     * logout student
     * @param Request $request
     *
     * @return [type]
     */
    public function logout(Request $request)
    {
        try {
            $user = $request->user();
            $user->tokens()->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Logout Berhasil'
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
     * login for teacher
     * @param Request $request
     *
     * @return [type]
     */
    public function loginTeacher(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if (!Auth::guard('teacher_api')->attempt($credentials)) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Email atau Password salah'
                ], 404);
            }

            $teacher = Teacher::whereEmail($request->email)->firstOrFail();
            $token = $teacher->createTOken('teacher-token');

            return response()->json([
                'status' => 200,
                'message' => 'Login Berhasil',
                'role' => $teacher->getRoleNames()->first(),
                'token' => $token->plainTextToken
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
