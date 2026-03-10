<?php

use App\Http\Controllers\Admin\DataDownloadController;
use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(['auth', Admin::class])->group(function () {
    Route::get('data-download/details', [DataDownloadController::class, 'details'])->name('data-download.details');
});
