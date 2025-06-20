<?php

use App\Http\Controllers\TeacherController;
use App\Http\Middleware\TeacherBelongsToSchool;
use Illuminate\Support\Facades\Route;

// Dashboard landing page
Route::get('', [TeacherController::class, 'index'])
	->middleware(TeacherBelongsToSchool::class)
	->name('dashboard');

// Attach school to teacher
Route::get('school/show', [TeacherController::class, 'showSchool'])
	->name('school.show');

Route::post('school/store', [TeacherController::class, 'storeSchool'])
	->name('school.store');
