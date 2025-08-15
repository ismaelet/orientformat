<?php

use App\Http\Controllers\AdministratorDashboardController;
use App\Http\Middleware\Administrator;
use Illuminate\Support\Facades\Route;

Route::any('administrator-dashboard', [AdministratorDashboardController::class, 'index'])->middleware(Administrator::class)->name('administrator.dashboard');
