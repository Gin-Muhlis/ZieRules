<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\DataTask;
use Illuminate\Http\Request;
use App\Models\DataViolation;
use App\Models\DataAchievment;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $violation_count = DataViolation::count();
        $achievment_count = DataAchievment::count();
        $task_count = DataTask::count();
        $student_count = Student::count();
        $teacher_count = Teacher::count();
        return view('home', compact('violation_count', 'achievment_count', 'task_count', 'student_count', 'teacher_count'));
    }
}
