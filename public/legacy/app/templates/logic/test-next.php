<?php

use app\Http\Controllers\Activities\Test;
use app\Http\Route;

RouteOld::get(function () {
	Test::get(testId());
});


RouteOld::post(function () {
	Test::post(testId());
});
