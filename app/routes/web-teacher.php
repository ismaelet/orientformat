<?php

use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\TeacherController;
use App\Http\Middleware\HasClassAccess;
use App\Http\Middleware\Teacher;
use App\Http\Middleware\TeacherBelongsToSchool;
use Illuminate\Support\Facades\Route;

Route::prefix(env('APP_SUBDOMAIN'))->group(function () {

	/**
	 * Teacher routes
	 */
	Route::prefix('/teacher')->middleware(Teacher::class)->name('teacher.')->group(function () {
		// Dashboard landing page
		Route::get('', [TeacherController::class, 'index'])
			->middleware(TeacherBelongsToSchool::class)
			->name('dashboard');

		// Attach school to teacher
		Route::get('school/show', [TeacherController::class, 'showSchool'])
			->name('school.show');

		Route::post('school/store', [TeacherController::class, 'storeSchool'])
			->name('school.store');
	});

	/**
	 * Class dashboard routes
	 */
	Route::prefix('/class')->middleware([Teacher::class, HasClassAccess::class])->name('class.')->group(function () {
		// Show class dashboard
		Route::get('{class}', [SchoolClassController::class, 'show'])
			->name('show');

		// General class routes
		Route::get('{class}/results', [SchoolClassController::class, 'showResults'])
			->name('general.results');

		// Students routes
		Route::get('{class}/students/results', [SchoolClassController::class, 'studentResultsIndex'])
			->name('students.results.index');

		Route::get('{class}/students/results/{student}', [SchoolClassController::class, 'studentResultsShow'])
			->name('students.results.show');

		Route::get('{class}/students/guidance', [SchoolClassController::class, 'showStudentGuidance'])
			->name('students.guidance.index');

		// Settings routes
		Route::get('{class}/students/index', [SchoolClassController::class, 'showStudentIndex'])
			->name('students.index');

		Route::get('{class}/teachers/index', [SchoolClassController::class, 'showTeacherIndex'])
			->name('teachers.index');

		Route::get('{class}/settings', [SchoolClassController::class, 'showSettings'])
			->name('settings');
	});
});
