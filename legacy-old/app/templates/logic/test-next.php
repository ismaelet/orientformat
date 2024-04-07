<?php

use app\Http\Controllers\Activities\Test;
use app\Http\Route;

Route::get(function () {
	Test::get(testId());
});


Route::post(function () {
	Test::post(testId());
});
