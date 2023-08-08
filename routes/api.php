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
use App\Http\Controllers\Api\TeacherController;
use App\Http\Controllers\Api\TeacherDataViolationsController;
use App\Http\Controllers\Api\ViolationController;


Route::post('/login', [AuthController::class, 'login'])->name('api.login');

// student routes
Route::post('/login/student', [AuthController::class, 'loginStudent']);
Route::post('/logout/student', [AuthController::class, 'logout']);
Route::get('/profile/student', [StudentController::class, 'profile']);
Route::get('/students/data-violations', [StudentDataViolationsController::class, 'studentViolations']);
Route::get('/students/data-achievments', [StudentDataAchievmentsController::class, 'studentAchievments']);
Route::get('/students/data-tasks', [StudentDataTasksController::class, 'studentTasks']);
Route::get('/student/{nis}', [StudentController::class, 'detailSiswa']);

// data ruotes
Route::get('/violations', [ViolationController::class, 'index']);
Route::get('achievments', [AchievmentController::class, 'index']);
Route::get('/tasks', [TaskController::class, 'index']);

// teacher routes
Route::post('/login/teacher', [AuthController::class, 'loginTeacher']);
Route::post('/logout/teacher', [AuthController::class, 'logout']);
Route::get('/profile/teacher', [TeacherController::class, 'profile']);
Route::get('/list/student/teacher', [TeacherController::class, 'listStudent']);
Route::post('/add/student/violation', [TeacherDataViolationsController::class, 'addViolation']);
Route::post('/add/students/violation', [TeacherDataViolationsController::class, 'addViolations']);
Route::get('/teacher/history/scan', [TeacherController::class, 'historyScan']);
