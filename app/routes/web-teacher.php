<?php

use App\Http\Controllers\ClassController;
use App\Http\Controllers\SchoolClass\GraphController;
use App\Http\Controllers\SchoolClass\SchoolClassProgressController;
use App\Http\Controllers\SchoolClass\SettingsController;
use App\Http\Controllers\SchoolClass\StudentResultController;
use App\Http\Controllers\SchoolClass\TeacherManagementController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\TeacherController;
use App\Http\Middleware\HasClassAccess;
use App\Http\Middleware\StudentBelongsToClass;
use App\Http\Middleware\Teacher;
use App\Http\Middleware\TeacherBelongsToSchool;
use App\Http\Middleware\UnderContruction;
use Illuminate\Support\Facades\Route;

/**
 * Teacher routes
 */
Route::prefix('/teacher')->middleware(Teacher::class)->name('teacher.')->group(function () {
	// Dashboard landing page
	Route::get('', [TeacherController::class, 'index'])
		->middleware(TeacherBelongsToSchool::class)
		->name('dashboard');

	// Class management
	Route::get('classes/create', [ClassController::class, 'create'])
		->name('classes.create');
	Route::post('classes', [ClassController::class, 'store'])
		->name('classes.store');

	// Further readings
	Route::get('read/results', [TeacherController::class, 'showReadResults'])
		->name('read.results');

	// Attach school to teacher
	Route::get('school/show', [TeacherController::class, 'showSchool'])
		->name('school.show');

	Route::post('school/store', [TeacherController::class, 'storeSchool'])
		->name('school.store');
});

/**
 * Class dashboard routes
 */
Route::prefix('/class')->middleware([Teacher::class, HasClassAccess::class, UnderContruction::class])->name('class.')->group(function () {
	// Show class dashboard
	Route::get('{class}', [SchoolClassController::class, 'show'])
		->name('show');

	// General class routes
	Route::get('{class}/progress/areas', [SchoolClassProgressController::class, 'index'])
		->name('general.progress');
	Route::get('{class}/progress/areas/{area}', [SchoolClassProgressController::class, 'show'])
		->name('general.progress.show');

	Route::get('{class}/graphs', [GraphController::class, 'index'])
		->name('general.graphs');

	// Students routes
	Route::get('{class}/students/results', [SchoolClassController::class, 'studentResultsIndex'])
		->name('students.results.index');

	Route::get('{class}/students/results/{student}', [StudentResultController::class, 'show'])
		->middleware(StudentBelongsToClass::class)
		->name('students.results.show');

	Route::get('{class}/students/poi/{student}', [StudentResultController::class, 'showPoi'])
		->middleware(StudentBelongsToClass::class)
		->name('students.poi.show');

	Route::get('{class}/students/autovalutazioni/{student}', [StudentResultController::class, 'showSelfEvaluations'])
		->middleware(StudentBelongsToClass::class)
		->name('students.autovalutazioni.show');

	Route::get('{class}/students/self-evaluations/{student}', [StudentResultController::class, 'showSelfEvaluations'])
		->middleware(StudentBelongsToClass::class)
		->name('students.self-evaluations.show');

	Route::get('{class}/students/guidance', [SchoolClassController::class, 'showStudentGuidance'])
		->name('students.guidance.index');

	// Settings routes
	Route::get('{class}/students/index', [SettingsController::class, 'studentIndex'])
		->name('students.index');

	Route::get('{class}/teachers/index', [TeacherManagementController::class, 'index'])
		->name('teachers.index');

	Route::get('{class}/settings', [SettingsController::class, 'showSettings'])
		->name('settings');
});
