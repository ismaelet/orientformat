<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RecoverController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetController;
use Illuminate\Support\Facades\Route;

/**
 * Auth routes
 */
Route::get('/login', [LoginController::class, 'index'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'auth'])->middleware(['guest', 'throttle:6,1'])->name('login.auth');

// Route::get('/register', [RegisterController::class, 'index'])->name('register')->middleware('guest');
Route::post('/register', [RegisterController::class, 'store'])->middleware(['guest', 'throttle:6,1'])->name('register.store');

Route::get('/logout', [LogoutController::class, 'index'])->middleware('auth')->name('logout');
Route::post('/logout', [LogoutController::class, 'logout'])->middleware('auth')->name('logout.logout');

Route::get('/recover', [RecoverController::class, 'index'])->middleware('guest')->name('auth.recover');
Route::post('/recover', [RecoverController::class, 'store'])->middleware(['guest', 'throttle:6,1'])->name('auth.recover');

Route::get('/reset/{token?}', [ResetController::class, 'index'])->name('password.reset')->middleware('guest');
Route::post('/reset', [ResetController::class, 'update'])->middleware(['guest', 'throttle:6,1'])->name('auth.reset');

Route::get('/email/verify', [EmailVerificationController::class, 'notice'])
    ->middleware('auth')
    ->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');
Route::post('/email/verification-notification', [EmailVerificationController::class, 'send'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');
