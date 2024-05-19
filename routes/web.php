<?php

use App\Http\Controllers\Activities\StudentAnalysisController;
use App\Http\Controllers\Activities\TestController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LegacyController;
use App\Http\Controllers\StudentHomeController;
use App\Http\Controllers\SurveysHighschool2024Controller;
use App\Http\Controllers\TeacherDashboardController;
use App\Http\Middleware\Student;
use App\Http\Middleware\Teacher;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/**
 * * App routes
 */
// ~ Home
Route::get('', [HomeController::class, 'index'])->middleware('auth')->name('home');
Route::get('/', [HomeController::class, 'index'])->middleware('auth')->name('home');

// ~ Surveys
Route::get('/2024-highschool-survey', [SurveysHighschool2024Controller::class, 'index'])->name('2024-highschool-survey');

/**
 * * Workarounds
 */
Route::get('/run-migrations', function () {
	Artisan::call('migrate', [
		'--force' => true
	]);
});

/**
 * * Parcially legacy routes
 */
// ~ Home pages
Route::any('/student', [StudentHomeController::class, 'index'])->middleware(Student::class)->name('student');

Route::any('/teacher-dashboard', [TeacherDashboardController::class, 'index'])->middleware(Teacher::class)->name('teacher.dashboard');

// ~ Student Activities
Route::any('/activities/tests/{test}', [TestController::class, 'show'])->middleware(['auth'])->name('activities.tests');

// ~ Student Analisys
Route::any('/analysis/student/areas/{area}', [StudentAnalysisController::class, 'show'])->middleware(['auth'])->name('analysis.student.area');
Route::any('/analysis/student/sections/{section}', [StudentAnalysisController::class, 'show'])->name('analysis.student.section');

/**
 * * Legacy routes
 */
Route::get('/logout', LegacyController::class)->name('logout');

Route::any('{path}', LegacyController::class)->where('path', '^(?!api\/).*');
