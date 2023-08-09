<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;
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
        $credentials = $request->validate([
            'nis' => 'required',
            'password' => 'required'
        ]);

        if (!Auth::guard('student_api')->attempt($credentials)) {
            return response()->json([
                'status' => 404,
                'message' => 'Nis atau Password Salah'
            ]);
        }

        $student = Student::with('class')->whereNis($request->nis)->firstOrFail();
        $token = $student->createToken('student-token');

        return response()->json([
            'status' => 200,
            'message' => 'Login Berhasil',
            'token' => $token->plainTextToken
        ]);
    }

    /**
     * logout student
     * @param Request $request
     * 
     * @return [type]
     */
    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();

        return response()->json(['message' => 'Logout Berhasil']);
    }

    /**
     * login for teacher
     * @param Request $request
     * 
     * @return [type]
     */
    public function loginTeacher(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::guard('teacher_api')->attempt($credentials)) {
            return response()->json([
                'status' => 404,
                'message' => 'Email atau Password salah'
            ]);
        }

        $teacher = Teacher::whereEmail($request->email)->firstOrFail();
        $token = $teacher->createTOken('teacher-token');

        return response()->json([
            'status' => 200,
            'message' => 'Login Berhasil',
            'role' => $teacher->getRoleNames()->first(),
            'token' => $token->plainTextToken
        ]);
    }
}
