<?php

use App\Http\Controllers\Activities\GradeController;
use App\Http\Controllers\Activities\StudentAnalysisController;
use App\Http\Controllers\Activities\TestController;
use App\Http\Controllers\MasterpieceController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SchoolClass\StudentResultController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentHomeController;
use App\Http\Middleware\EndReview;
use App\Http\Middleware\HasEmail;
use App\Http\Middleware\HasStudentAccess;
use App\Http\Middleware\Locale;
use App\Http\Middleware\StartReview;
use App\Http\Middleware\Student;
use App\Http\Middleware\StudentOrTeacher;
use Illuminate\Support\Facades\Route;

/**
 * Student only routes
 */
Route::middleware([Student::class, HasEmail::class, StartReview::class, EndReview::class, Locale::class])->group(function () {
    // Home
    Route::any('student', [StudentHomeController::class, 'index'])->name('student');

    // Student Activities
    Route::any('activities/grades', [GradeController::class, 'index'])->name('activities.grades.index');
    Route::any('activities/grades/{grade}', [GradeController::class, 'show'])->name('activities.grades.show');

    // Masterpieces
    Route::post('masterpieces/upload', [MasterpieceController::class, 'upload'])->name('masterpieces.upload');

    // Settings
    Route::get('settings', [StudentController::class, 'settingsIndex'])
        ->name('student.settings');

    Route::post('settings', [StudentController::class, 'settingsUpdate'])
        ->name('student.settings.update');

    Route::post('password', [StudentController::class, 'passwordUpdate'])
        ->name('student.password.update');
});

/**
 * Student and teacher simulation routes
 */
Route::middleware([StudentOrTeacher::class, Locale::class])->group(function () {
    // Section recap
    Route::any('activities/sections/{section}', [SectionController::class, 'show'])->name('section');

    // Test routes
    Route::any('activities/tests/{test}', [TestController::class, 'show'])->name('test');

    Route::post('activities/tests/{test}/store', [TestController::class, 'store'])->name('test.store');

    Route::post('activities/tests/{test}/reset', [TestController::class, 'reset'])->name('test.reset');

    Route::post('activities/tests/{test}/reset-dependent', [TestController::class, 'resetDependent'])->name('test.reset.dependent');
});

/**
 * Student analysis routes
 */
Route::middleware(['auth', Locale::class])->group(function () {
    // Areas analysis
    Route::any('analysis/student/areas/{area}', [StudentAnalysisController::class, 'show'])->name('analysis.student.area');

    // Sections analysis
    Route::any('analysis/student/sections/{section}', [StudentAnalysisController::class, 'show'])->name('analysis.student.section');
});

/**
 * Student review routes
 */
Route::resource('review', ReviewController::class)->middleware(['auth', Student::class])->only(['show', 'store']);

/**
 * Mixed student and teacher routes
 */
Route::middleware(HasStudentAccess::class)->group(function () {
    // Profile
    Route::get('students/{student}/results/pdf', [StudentResultController::class, 'downloadPdf'])
        ->name('students.results.pdf');

    // Self-assessments
    Route::get('students/{student}/self-assessments/pdf', [StudentResultController::class, 'downloadSelfAssessmentPdf'])
        ->name('students.self-assessments.pdf');

    // Masterpieces
    Route::get('students/{student}/masterpieces/{masterpiece}/download', [MasterpieceController::class, 'download'])->name('masterpieces.download');
});
