<?php

use app\Http\Controllers\Activities\Test;
use app\Http\Route;

\App\Legacy\LegacyRoute::get(function () {
	Test::get(testId());
});


\App\Legacy\LegacyRoute::post(function () {
	Test::post(testId());
});
