<?php

use App\Http\Controllers\Activities\StudentAnalysisController;
use App\Http\Controllers\LegacyController;
use App\Http\Controllers\SurveysHighschool2024Controller;
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
Route::any('/analysis/student/areas/{area}', [StudentAnalysisController::class, 'show'])->middleware(['auth'])->name('analysis.student.area');
Route::any('/analysis/student/sections/{section}', [StudentAnalysisController::class, 'show'])->name('analysis.student.section');

/**
 * * Legacy routes
 */
Route::any('/', LegacyController::class)->name('home');

Route::any('{path}', LegacyController::class)->where('path', '^(?!api\/).*');
