<?php

use App\Http\Controllers\Api\SectionGraphController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LegacyController;
use App\Http\Controllers\LocaleController;
use App\Http\Middleware\Locale;
use Illuminate\Support\Facades\Route;

Route::prefix(env('APP_SUBDOMAIN'))->group(function () {
	// Localization
	Route::get('locale/{locale}', [LocaleController::class, 'switchLocale'])->name('locale.switch');

	// Home
	Route::get('', [HomeController::class, 'index'])->middleware(['auth', Locale::class])->name('home');

	// Legacy API
	Route::get('api/section-graphs/{section}', [SectionGraphController::class, 'show']);
});

include __DIR__ . '/web-auth.php';
include __DIR__ . '/web-student.php';
include __DIR__ . '/web-teacher.php';
include __DIR__ . '/web-administrator.php';
include __DIR__ . '/web-db.php';

Route::any('{path}', LegacyController::class)->where('path', '.*');
