<?php

use app\Http\Controllers\Activities\Test;
use app\Http\Route;

\Legacy\System\Classes\LegacyRoute::get(function () {
	Test::get(testId());
});


\Legacy\System\Classes\LegacyRoute::post(function () {
	Test::post(testId());
});
