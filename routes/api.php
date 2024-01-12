<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\QuoteController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\TeacherController;
use App\Http\Controllers\Api\VersionController;
use App\Http\Controllers\Api\ViolationController;
use App\Http\Controllers\Api\AchievmentController;
use App\Http\Controllers\Api\StudentAbsencesController;
use App\Http\Controllers\Api\StudentDataTasksController;
use App\Http\Controllers\Api\TeacherDataTasksController;
use App\Http\Controllers\Api\StudentDataViolationsController;
use App\Http\Controllers\Api\TeacherDataViolationsController;
use App\Http\Controllers\Api\StudentDataAchievmentsController;
use App\Http\Controllers\Api\TeacherDataAchievmentsController;


// route siswa
Route::prefix('student')->group(function () {
    // Auth
    Route::post('/login', [AuthController::class, 'loginStudent']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Data siswa
    Route::get('/profile', [StudentController::class, 'profile']);
    Route::get('/{code}', [StudentController::class, 'detailSiswa']);

    // Data pelanggaran
    Route::get('/list/violation', [ViolationController::class, 'indexStudent']);
    Route::get('/data/violation', [StudentDataViolationsController::class, 'studentViolations']);

    // Data prestasi
    Route::get('/list/achievment', [AchievmentController::class, 'indexStudent']);
    Route::get('/data/achievment', [StudentDataAchievmentsController::class, 'studentAchievments']);

    // Data Absensi
    Route::post('/absence/create', [StudentAbsencesController::class, 'absenceStudent']);
    Route::get('/absence/data', [StudentController::class, 'getAbsence']);

    // Data tugas
    Route::get('/data/task', [StudentDataTasksController::class, 'studentTasks']);
    Route::get('/list/task', [TaskController::class, 'indexStudent']);

    // Quote
    Route::get('/generate/quote', [QuoteController::class, 'generateQuote']);

    // Artikel
    Route::get('/list/article', [ArticleController::class, 'listArticle']);
    Route::get('/article/{article}', [ArticleController::class, 'detailArticle']);
});

// route guru
Route::prefix('teacher')->group(function () {
    // Auth
    Route::post('/login', [AuthController::class, 'loginTeacher']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Data guru
    Route::get('/profile', [TeacherController::class, 'profile']);

    // Daftar siswa
    Route::get('/list/student', [TeacherController::class, 'listStudent']);
    Route::get('/all/student', [TeacherController::class, 'allStudent']);

    // Data pelanggaran
    Route::get('/list/violation', [ViolationController::class, 'indexTeacher']);
    Route::post('/add/student/violation', [TeacherDataViolationsController::class, 'addViolation']);
    Route::post('/add/students/violation', [TeacherDataViolationsController::class, 'addViolations']);

    // Data Prestasi
    Route::get('/list/achievment', [AchievmentController::class, 'indexTeacher']);
    Route::post('/add/student/achievment', [TeacherDataAchievmentsController::class, 'addAchievment']);
    Route::post('/add/students/achievment', [TeacherDataAchievmentsController::class, 'addAchievments']);

    // Data tugas
    Route::get('/list/task', [TaskController::class, 'indexTeacher']);
    Route::post('/add/student/task', [TeacherDataTasksController::class, 'addTask']);
    Route::post('/add/students/task', [TeacherDataTasksController::class, 'addTasks']);

    // Data scan
    Route::get('/history/scan', [TeacherController::class, 'historyScans']);

    // Data Absensi siswa
    Route::get('/list/presence', [TeacherController::class, 'listPresence']);
    Route::get('/students/absences', [TeacherController::class, 'presences']);
    Route::post('/add/presence', [StudentAbsencesController::class, 'TeacherAbsenceStudent']);
});

Route::get('/version', [VersionController::class, 'index']);