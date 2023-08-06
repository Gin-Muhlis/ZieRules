<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\TeacherController;
use App\Http\Controllers\Api\DataTaskController;
use App\Http\Controllers\Api\HomeroomController;
use App\Http\Controllers\Api\ViolationController;
use App\Http\Controllers\Api\AchievmentController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\HistoryScanController;
use App\Http\Controllers\Api\ClassStudentController;
use App\Http\Controllers\Api\DataViolationController;
use App\Http\Controllers\Api\TaskDataTasksController;
use App\Http\Controllers\Api\DataAchievmentController;
use App\Http\Controllers\Api\StudentDataTasksController;
use App\Http\Controllers\Api\TeacherDataTasksController;
use App\Http\Controllers\Api\TeacherHomeroomsController;
use App\Http\Controllers\Api\StudentHistoryScansController;
use App\Http\Controllers\Api\TeacherHistoryScansController;
use App\Http\Controllers\Api\ClassStudentStudentsController;
use App\Http\Controllers\Api\ClassStudentHomeroomsController;
use App\Http\Controllers\Api\StudentDataViolationsController;
use App\Http\Controllers\Api\TeacherDataViolationsController;
use App\Http\Controllers\Api\StudentDataAchievmentsController;
use App\Http\Controllers\Api\TeacherDataAchievmentsController;
use App\Http\Controllers\Api\ViolationDataViolationsController;
use App\Http\Controllers\Api\AchievmentDataAchievmentsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

// student login
Route::post('/login/student', [AuthController::class, 'loginStudent'])->name('student.api.login');
Route::post('/logout/student', [AuthController::class, 'logoutStudent'])->name('student.api.logout');
Route::get('/profile/student', [StudentController::class, 'profile'])->name('profile.student');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);

        Route::apiResource('achievments', AchievmentController::class);

        // Achievment Data Achievments
        Route::get('/achievments/{achievment}/data-achievments', [
            AchievmentDataAchievmentsController::class,
            'index',
        ])->name('achievments.data-achievments.index');
        Route::post('/achievments/{achievment}/data-achievments', [
            AchievmentDataAchievmentsController::class,
            'store',
        ])->name('achievments.data-achievments.store');

        Route::apiResource('data-achievments', DataAchievmentController::class);

        Route::apiResource('data-tasks', DataTaskController::class);

        Route::apiResource('data-violations', DataViolationController::class);

        Route::apiResource('homerooms', HomeroomController::class);

        Route::apiResource('tasks', TaskController::class);

        // Task Data Tasks
        Route::get('/tasks/{task}/data-tasks', [
            TaskDataTasksController::class,
            'index',
        ])->name('tasks.data-tasks.index');
        Route::post('/tasks/{task}/data-tasks', [
            TaskDataTasksController::class,
            'store',
        ])->name('tasks.data-tasks.store');

        Route::apiResource('violations', ViolationController::class);

        // Violation Data Violations
        Route::get('/violations/{violation}/data-violations', [
            ViolationDataViolationsController::class,
            'index',
        ])->name('violations.data-violations.index');
        Route::post('/violations/{violation}/data-violations', [
            ViolationDataViolationsController::class,
            'store',
        ])->name('violations.data-violations.store');

        Route::apiResource('history-scans', HistoryScanController::class);

        Route::apiResource('class-students', ClassStudentController::class);

        // ClassStudent Students
        Route::get('/class-students/{classStudent}/students', [
            ClassStudentStudentsController::class,
            'index',
        ])->name('class-students.students.index');
        Route::post('/class-students/{classStudent}/students', [
            ClassStudentStudentsController::class,
            'store',
        ])->name('class-students.students.store');

        // ClassStudent Homerooms
        Route::get('/class-students/{classStudent}/homerooms', [
            ClassStudentHomeroomsController::class,
            'index',
        ])->name('class-students.homerooms.index');
        Route::post('/class-students/{classStudent}/homerooms', [
            ClassStudentHomeroomsController::class,
            'store',
        ])->name('class-students.homerooms.store');

        Route::apiResource('students', StudentController::class);

        // Student Data Violations
        Route::get('/students/{student}/data-violations', [
            StudentDataViolationsController::class,
            'index',
        ])->name('students.data-violations.index');
        Route::post('/students/{student}/data-violations', [
            StudentDataViolationsController::class,
            'store',
        ])->name('students.data-violations.store');

        // Student Data Achievments
        Route::get('/students/{student}/data-achievments', [
            StudentDataAchievmentsController::class,
            'index',
        ])->name('students.data-achievments.index');
        Route::post('/students/{student}/data-achievments', [
            StudentDataAchievmentsController::class,
            'store',
        ])->name('students.data-achievments.store');

        // Student Data Tasks
        Route::get('/students/{student}/data-tasks', [
            StudentDataTasksController::class,
            'index',
        ])->name('students.data-tasks.index');
        Route::post('/students/{student}/data-tasks', [
            StudentDataTasksController::class,
            'store',
        ])->name('students.data-tasks.store');

        // Student History Scans
        Route::get('/students/{student}/history-scans', [
            StudentHistoryScansController::class,
            'index',
        ])->name('students.history-scans.index');
        Route::post('/students/{student}/history-scans', [
            StudentHistoryScansController::class,
            'store',
        ])->name('students.history-scans.store');

        Route::apiResource('teachers', TeacherController::class);

        // Teacher Data Violations
        Route::get('/teachers/{teacher}/data-violations', [
            TeacherDataViolationsController::class,
            'index',
        ])->name('teachers.data-violations.index');
        Route::post('/teachers/{teacher}/data-violations', [
            TeacherDataViolationsController::class,
            'store',
        ])->name('teachers.data-violations.store');

        // Teacher Data Achievments
        Route::get('/teachers/{teacher}/data-achievments', [
            TeacherDataAchievmentsController::class,
            'index',
        ])->name('teachers.data-achievments.index');
        Route::post('/teachers/{teacher}/data-achievments', [
            TeacherDataAchievmentsController::class,
            'store',
        ])->name('teachers.data-achievments.store');

        // Teacher Data Tasks
        Route::get('/teachers/{teacher}/data-tasks', [
            TeacherDataTasksController::class,
            'index',
        ])->name('teachers.data-tasks.index');
        Route::post('/teachers/{teacher}/data-tasks', [
            TeacherDataTasksController::class,
            'store',
        ])->name('teachers.data-tasks.store');

        // Teacher Homerooms
        Route::get('/teachers/{teacher}/homerooms', [
            TeacherHomeroomsController::class,
            'index',
        ])->name('teachers.homerooms.index');
        Route::post('/teachers/{teacher}/homerooms', [
            TeacherHomeroomsController::class,
            'store',
        ])->name('teachers.homerooms.store');

        // Teacher History Scans
        Route::get('/teachers/{teacher}/history-scans', [
            TeacherHistoryScansController::class,
            'index',
        ])->name('teachers.history-scans.index');
        Route::post('/teachers/{teacher}/history-scans', [
            TeacherHistoryScansController::class,
            'store',
        ])->name('teachers.history-scans.store');

        Route::apiResource('users', UserController::class);
    });
