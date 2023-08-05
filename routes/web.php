<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\DataTaskController;
use App\Http\Controllers\HomeroomController;
use App\Http\Controllers\ViolationController;
use App\Http\Controllers\AchievmentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\HistoryScanController;
use App\Http\Controllers\ClassStudentController;
use App\Http\Controllers\DataViolationController;
use App\Http\Controllers\DataAchievmentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('/')
    ->middleware('auth')
    ->group(function () {
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);

        Route::resource('achievments', AchievmentController::class);
        Route::resource('data-achievments', DataAchievmentController::class);
        Route::resource('data-tasks', DataTaskController::class);
        Route::resource('data-violations', DataViolationController::class);
        Route::resource('homerooms', HomeroomController::class);
        Route::resource('students', StudentController::class);
        Route::resource('tasks', TaskController::class);
        Route::resource('teachers', TeacherController::class);
        Route::resource('users', UserController::class);
        Route::resource('violations', ViolationController::class);
        Route::resource('history-scans', HistoryScanController::class);
        Route::resource('class-students', ClassStudentController::class);
    });
