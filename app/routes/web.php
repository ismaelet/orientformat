<?php

use App\Http\Controllers\Api\SectionGraphController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LegacyController;
use App\Http\Controllers\LocaleController;
use App\Http\Middleware\Locale;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

// Localization
Route::get('locale/{locale}', [LocaleController::class, 'switchLocale'])->name('locale.switch');

// Home
Route::get('', [HomeController::class, 'index'])->middleware(['auth', Locale::class])->name('home');

// Help
Route::get('help', [HelpController::class, 'index'])->name('help');

Route::get('help/ticket/open', [HelpController::class, 'openTicket'])->name('help.ticket.open');
Route::post('help/ticket/store', [HelpController::class, 'storeTicket'])->name('help.ticket.store');

// Legacy API
Route::get('api/section-graphs/{section}', [SectionGraphController::class, 'show']);

include __DIR__ . '/web-auth.php';
include __DIR__ . '/web-student.php';
include __DIR__ . '/web-teacher.php';
include __DIR__ . '/web-administrator.php';
include __DIR__ . '/web-db.php';

Route::any('{path}', LegacyController::class)->where('path', '.*');
