<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('loginStudent');
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
            'student' => [
                'nis' => $student->nis,
                'name' => $student->name,
                'image' => $student->image,
                'gender' => $student->gender,
                'class' => [
                    'name' => $student->class->name,
                    'code' => $student->class->code
                ],
                'role' => $student->getRoleNames()->first()
            ],
            'token' => $token->plainTextToken
        ]);
    }

    /**
     * logout student
     * @param Request $request
     * 
     * @return [type]
     */
    public function logoutStudent(Request $request)
    {
        $student = $request->user();
        $student->tokens()->delete();

        return response()->json(['message' => 'Logout Berhasil']);
    }
}
