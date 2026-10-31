<?php

use App\Http\Controllers\HelpController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocaleController;
use App\Http\Middleware\Locale;
use Illuminate\Support\Facades\Route;

// Localization
Route::get('locale/{locale}', [LocaleController::class, 'switchLocale'])->name('locale.switch');

// Home
Route::get('', [HomeController::class, 'index'])->middleware(['auth', Locale::class])->name('home');

// Help
Route::get('help', [HelpController::class, 'index'])->name('help');

Route::get('help/ticket/open', [HelpController::class, 'openTicket'])->name('help.ticket.open');
Route::post('help/ticket/store', [HelpController::class, 'storeTicket'])->name('help.ticket.store');

Route::get('/debug-url', function () {
    return response()->json([
        'app_url' => config('app.url'),
        'request_base_url' => request()->getBaseUrl(),
        'request_path' => request()->path(),
        'generated_update_url' => route('livewire.update'),
        'generated_login_url' => route('login'),
    ]);
});

include __DIR__.'/web-legacy.php';

include __DIR__.'/web-admin.php';
include __DIR__.'/web-auth.php';
include __DIR__.'/web-student.php';
include __DIR__.'/web-teacher.php';
include __DIR__.'/web-administrator.php';
