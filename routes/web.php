<?php

use App\Http\Controllers\Activities\GradeController;
use App\Http\Controllers\Activities\StudentAnalysisController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LegacyController;
use App\Http\Controllers\StudentHomeController;
use App\Http\Controllers\TeacherDashboardController;
use App\Http\Middleware\Admin;
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

/**
 * * Workarounds
 */
Route::get('run-migrations', function () {
	Artisan::call('migrate', [
		'--force' => true
	]);
})->middleware(Admin::class);

Route::get('dump-autoload', function () {
	$output = shell_exec('composer dump-autoload');
	dd($output);
})->middleware(Admin::class);

Route::get('composer-install', function () {
	$output = shell_exec('composer install');
	dd($output);
})->middleware(Admin::class);

/**
 * * Parcially legacy routes
 */
// ~ Home pages
Route::any('student', [StudentHomeController::class, 'index'])->middleware(Student::class)->name('student');

Route::any('teacher-dashboard', [TeacherDashboardController::class, 'index'])->middleware(Teacher::class)->name('teacher.dashboard');

// ~ Student Activities
Route::any('activities/grades', [GradeController::class, 'index'])->middleware([Student::class])->name('activities.grades.index');
Route::any('activities/grades/{grade}', [GradeController::class, 'show'])->middleware([Student::class])->name('activities.grades.show');

// ~ Student Analisys
Route::any('analysis/student/areas/{area}', [StudentAnalysisController::class, 'show'])->middleware(['auth'])->name('analysis.student.area');
Route::any('analysis/student/sections/{section}', [StudentAnalysisController::class, 'show'])->name('analysis.student.section');

Route::get('logout', LegacyController::class)->name('logout');

// Route::get('2024-highschool-survey', [SurveysHighschool2024Controller::class, 'index'])->name('2024-highschool-survey')->middleware(Teacher::class);
// Route::post('2024-highschool-survey', [SurveysHighschool2024Controller::class, 'store'])->middleware(Teacher::class);
