<?php

use App\Http\Controllers\Api\AchievmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\StudentDataAchievmentsController;
use App\Http\Controllers\Api\StudentDataTasksController;
use App\Http\Controllers\Api\StudentDataViolationsController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\ViolationController;


Route::post('/login', [AuthController::class, 'login'])->name('api.login');

// student routes
Route::post('/login/student', [AuthController::class, 'loginStudent']);
Route::post('/logout/student', [AuthController::class, 'logoutStudent']);
Route::get('/profile/student', [StudentController::class, 'profile']);
Route::get('/students/data-violations', [StudentDataViolationsController::class, 'studentViolations']);
Route::get('/students/data-achievments', [StudentDataAchievmentsController::class, 'studentAchievments']);
Route::get('/students/data-tasks', [StudentDataTasksController::class, 'studentTasks']);

// data ruotes
Route::get('/violations', [ViolationController::class, 'index']);
Route::get('achievments', [AchievmentController::class, 'index']);
Route::get('/tasks', [TaskController::class, 'index']);
