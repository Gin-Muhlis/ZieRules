<?php

namespace App\Http\Controllers\Api;

require_once app_path() . '/helpers/helpers.php';

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Task;
use Exception;
use Illuminate\Support\Facades\DB;

class StudentDataTasksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function studentTasks(Request $request)
    {
      try {
        $student = $request->user();

        $this->authorize('student-view', $student);

        $results = [];
        $tasks = DB::table('tasks')->select('id', 'name', 'class', 'description')->get();

        foreach ($student->dataTasks as $task) {
            $results[] = [
                'id' => $task->id,
                'teacher' => $task->teacher->name,
                'date' =>generateDate( $task->date->toDateString()),
                'description' => $task->description
            ];
        }

        $finishedTasks = [];
        $unfinishedTasks = [];

        foreach($tasks as $task) {
            if (!is_null(collect($results)->firstWhere('id', $task->id))) {
                $finishedTasks[] = [
                    'finished' => true,
                    'id' => $task->id,
                    'name' => $task->name,
                    'class' => $task->class,
                    'description' => $task->description,
                    'result' => collect($results)->firstWhere('id', $task->id)
                ];
            } else {
                $unfinishedTasks[] = [
                    'finished' => false,
                    'id' => $task->id,
                    'name' => $task->name,
                    'class' => $task->class,
                    'description' => $task->description
                ];
            }
            
        } 

        $dataTask = array_merge($unfinishedTasks, $finishedTasks);

        return response()->json([
            'status' => 200,
            'dataTask' => $dataTask
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
