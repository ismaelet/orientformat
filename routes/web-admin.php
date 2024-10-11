<?php

use App\Http\Controllers\Admin\Pages\DashboardController;
use App\Http\Controllers\Admin\Pages\DatabaseController;
use App\Http\Controllers\Admin\Resources\SchoolClassResource;
use App\Http\Controllers\Admin\Resources\StudentResource;
use App\Http\Controllers\Admin\Resources\UserResource;
use Illuminate\Support\Facades\Route;

// Admin dashboard home
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Users
Route::resource('users', UserResource::class)->only(['index', 'destroy']);
Route::post('users/login', [UserResource::class, 'login'])->name('users.login');

// Students
Route::resource('students', StudentResource::class)->only(['index', 'edit', 'update', 'destroy']);

// Classes
Route::resource('school_classes', SchoolClassResource::class)->only(['index', 'destroy']);

// Database
Route::get('/database/download', [DatabaseController::class, 'index']);
Route::post('/database/download/active-students', [DatabaseController::class, 'downloadActiveStudents'])->name('database.download.active-students');
Route::post('/database/download/students', [DatabaseController::class, 'downloadStudents'])->name('database.download.students');
Route::post('/database/download/teachers', [DatabaseController::class, 'downloadTeachers'])->name('database.download.teachers');
Route::post('/database/download/classes', [DatabaseController::class, 'downloadSchoolClasses'])->name('database.download.classes');
Route::post('/database/download/results', [DatabaseController::class, 'downloadResults'])->name('database.download.results');
Route::post('/database/download/reviews', [DatabaseController::class, 'downloadReviews'])->name('database.download.reviews');
Route::post('/database/download/advices', [DatabaseController::class, 'downloadAdvices'])->name('database.download.advices');
