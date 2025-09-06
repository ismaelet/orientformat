<?php

use App\Http\Controllers\Administrator\ClassController;
use App\Http\Controllers\Administrator\StudentController;
use App\Http\Controllers\Administrator\TeacherController;
use App\Http\Middleware\Administrator;
use Illuminate\Support\Facades\Route;

Route::middleware(Administrator::class)->prefix('administrator')->name('administrator.')->group(function () {

	// Administrator dashboard
	Route::get('dashboard', [ClassController::class, 'index'])->name('dashboard');

	// School classes management
	Route::resource('classes', ClassController::class)->only(['index']);

	// Teacher management
	Route::resource('teachers', TeacherController::class)->only(['index']);

	// Student management
	Route::resource('students', StudentController::class)->only(['index']);
});
