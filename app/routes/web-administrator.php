<?php

use App\Http\Controllers\Administrator\ClassController;
use App\Http\Controllers\Administrator\DownloadController;
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

    // Download data
    Route::get('download', [DownloadController::class, 'index'])->name('download.index');

    Route::get('download/{school}/results', [DownloadController::class, 'downloadResults'])->name('download.results');

    Route::get('download/{school}/students', [DownloadController::class, 'downloadStudents'])->name('download.students');

    Route::get('download/{school}/teachers', [DownloadController::class, 'downloadTeachers'])->name('download.teachers');

    Route::get('download/{school}/classes', [DownloadController::class, 'downloadClasses'])->name('download.classes');
});
