<?php

use App\Http\Controllers\Admin\Pages\DashboardController;
use App\Http\Controllers\Admin\Resources\UserController;
use Illuminate\Support\Facades\Route;

/**
 * Admin routes
 */

/**
 * * Dashboard
 */
// Admin dashboard home
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

/**
 * * Resources
 */
// Users
Route::resource('users', UserController::class)->only(['index', 'edit', 'update', 'destroy']);
Route::post('/users/{id}/login', [UserController::class, 'login'])->name('users.login');
