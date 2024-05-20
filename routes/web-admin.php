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
