<?php

use App\Http\Controllers\VersionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\DataTaskController;
use App\Http\Controllers\HomeroomController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\ViolationController;
use App\Http\Controllers\AchievmentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\HistoryTaskController;
use App\Http\Controllers\ClassStudentController;
use App\Http\Controllers\DataViolationController;
use App\Http\Controllers\DataAchievmentController;
use App\Http\Controllers\StudentAbsenceController;
use App\Http\Controllers\HistoryViolationController;
use App\Http\Controllers\HistoryAchievmentController;

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

Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });
});

Auth::routes();


Route::prefix('/')
    ->middleware('auth')
    ->group(function () {

        Route::get('/home', [HomeController::class, 'index'])->name('home');

        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);

        Route::resource('achievments', AchievmentController::class);
        Route::resource('data-achievments', DataAchievmentController::class);
        Route::resource('data-tasks', DataTaskController::class);
        Route::resource('data-violations', DataViolationController::class);
        Route::resource('homerooms', HomeroomController::class);
        Route::resource('violations', ViolationController::class);
        Route::resource('class-students', ClassStudentController::class);
        Route::resource(
            'history-achievments',
            HistoryAchievmentController::class
        );
        Route::resource('history-tasks', HistoryTaskController::class);
        Route::resource(
            'history-violations',
            HistoryViolationController::class
        );
        Route::resource('tasks', TaskController::class);
        Route::resource('teachers', TeacherController::class);
        Route::resource('students', StudentController::class);
        Route::resource('users', UserController::class);
        Route::resource('presences', PresenceController::class);
        Route::resource('student-absences', StudentAbsenceController::class);
        Route::resource('articles', ArticleController::class);
        Route::resource('quotes', QuoteController::class);
        Route::resource('versions', VersionController::class);

        Route::get('data-violations-report', [DataViolationController::class, 'report'])->name('data.violations.report');
        Route::get('data-achievments-report', [DataAchievmentController::class, 'report'])->name('data.achievments.report');
        Route::get('data-tasks-report', [DataTaskController::class, 'report'])->name('data.tasks.report');
        Route::get('data-absence-report', [StudentAbsenceController::class, 'report'])->name('data.absence.report');

        Route::get('show/data-violations-report/{student}', [DataViolationController::class, 'detailReport'])->name('data.violations.show.report');
        Route::get('show/data-achievments-report/{student}', [DataAchievmentController::class, 'detailReport'])->name('data.achievments.show.report');
        Route::get('show/data-tasks-report/{student}', [DataTaskController::class, 'detailReport'])->name('data.tasks.show.report');

        Route::get('violation/export', [DataViolationController::class, 'exportData'])->name('data.violation.export');
        Route::get('achievment/export', [DataAchievmentController::class, 'exportData'])->name('data.achievment.export');
        Route::get('task/export', [DataTaskController::class, 'exportData'])->name('data.task.export');
        Route::get('absence/export', [StudentAbsenceController::class, 'exportData'])->name('data.absence.export');

        Route::get('violation-detail/export/{student}', [DataViolationController::class, 'exportDetail'])->name('data.violation.export.detail');
        Route::get('achievment-detail/export/{student}', [DataAchievmentController::class, 'exportDetail'])->name('data.achievment.export.detail');
        Route::get('task-detail/export/{student}', [DataTaskController::class, 'exportDetail'])->name('data.task.export.detail');

        Route::post('violation/import', [ViolationController::class, 'import'])->name('violation.import');
        Route::post('achievment/import', [AchievmentController::class, 'import'])->name('achievment.import');
        Route::post('task/import', [TaskController::class, 'import'])->name('task.import');
        Route::post('student/import', [StudentController::class, 'import'])->name('student.import');
        Route::post('teacher/import', [TeacherController::class, 'import'])->name('teacher.import');

    });
