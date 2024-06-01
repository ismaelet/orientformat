<?php

use App\Http\Controllers\Admin\Pages\DashboardController;
use App\Http\Controllers\Admin\Resources\SchoolClassResource;
use App\Http\Controllers\Admin\Resources\StudentResource;
use App\Http\Controllers\Admin\Resources\UserResource;
use Illuminate\Support\Facades\Route;

/**
 * Admin routes
 */

/**
 * * Dashboard
 */
// Admin dashboard home
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Users
Route::resource('users', UserResource::class)->only(['index']);
Route::post('users/login', [UserResource::class, 'login'])->name('users.login');

// Students
Route::resource('students', StudentResource::class)->only(['index', 'edit', 'update']);

// Classes
Route::resource('school_classes', SchoolClassResource::class)->only(['index']);
