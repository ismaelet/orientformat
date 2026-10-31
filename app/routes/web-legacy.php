<?php

use App\Http\Controllers\LegacyController;
use Illuminate\Support\Facades\Route;

// Keep all methods supported by the old router, including legacy form posts.
Route::any('wait', [LegacyController::class, 'wait'])->name('wait');
Route::any('add-email', [LegacyController::class, 'addEmail'])->name('add-email');
Route::any('tutorial', [LegacyController::class, 'tutorial'])->name('tutorial');
Route::any('interest', [LegacyController::class, 'interest'])->name('interest');

// Registered before web-student.php so the modern POST /review keeps priority.
Route::any('review', [LegacyController::class, 'review'])->name('legacy.review');
Route::any('teacher/know-more', [LegacyController::class, 'knowMore'])->name('teacher.know-more');
Route::any('teacher/paths', [LegacyController::class, 'paths'])->name('teacher.paths');
Route::any('read', [LegacyController::class, 'read'])->name('read');

// The old root and /help aliases are already handled by modern controllers.
// Preserve the additional landing alias when the application uses a subdirectory.
$landingAlias = trim(parse_url(config('app.url'), PHP_URL_PATH) ?? '', '/');
if ($landingAlias !== '') {
    Route::any($landingAlias, [LegacyController::class, 'landing'])->name('legacy.landing');
}

// System endpoints still use their legacy handlers, with explicit route bounds.
Route::any('ajax/{module?}', LegacyController::class)->where('module', '.*')->name('legacy.ajax');
foreach (['call-function', 'search-table', 'get-class-properties', 'call-class-method'] as $operation) {
    Route::any('api-old/'.$operation.'/{target?}', LegacyController::class)
        ->where('target', '.*')
        ->name('legacy.api.'.$operation);
}
Route::any('favicon.ico', LegacyController::class)->name('legacy.favicon');
