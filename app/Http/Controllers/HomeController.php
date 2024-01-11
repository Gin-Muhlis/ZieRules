<?php

namespace App\Http\Controllers;

use App\Models\DataTask;
use Illuminate\Http\Request;
use App\Models\DataViolation;
use App\Models\DataAchievment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
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
        $achievement_count = DataAchievment::count();
        $task_count = DataTask::count();

        $months = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];

        $year_now = Carbon::now()->year;
        $one_year_ago = Carbon::now()->subYear()->year;
        $two_year_ago = Carbon::now()->subYears(2)->year;
        
        $all_violation = DataViolation::selectRaw('MONTH(date) as month, YEAR(date) as year')->get()->groupBy('year');

        $all_achievement = DataAchievment::selectRaw('MONTH(date) as month, YEAR(date) as year')->get()->groupBy('year');

        $all_task = DataTask::selectRaw('MONTH(date) as month, YEAR(date) as year')->get()->groupBy('year');

        $violations = [];
        $achievements = [];
        $tasks = [];
        
        foreach ($months as $month) {
            $violations[] = DataViolation::whereMonth('date', $month)->whereYear('date', $year_now)->count();
            $achievements[] = DataAchievment::whereMonth('date', $month)->whereYear('date', $year_now)->count();
            $tasks[] = DataTask::whereMonth('date', $month)->whereYear('date', $year_now)->count();
        }

        $data = [
            'violation_count' => $violation_count,
            'achievement_count' => $achievement_count,
            'task_count' => $task_count,
            'violations' => $violations,
            'achievements' => $achievements,
            'tasks' => $tasks,
            'year_now' => $year_now,
            'one_year_ago' => $one_year_ago,
            'two_year_ago' => $two_year_ago,
            'all_violation' => $all_violation,
            'all_achievement' => $all_achievement,
            'all_task' => $all_task
        ];


        return view('home', compact('data'));
    }
}
