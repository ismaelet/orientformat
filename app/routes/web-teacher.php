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
	});
});
