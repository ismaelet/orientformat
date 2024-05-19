<?php

use app\Http\Controllers\Activities\Test;
use app\Http\TempLegacyRoute;

TempLegacyRoute::get(function () {
	Test::get(testId());
});


TempLegacyRoute::post(function () {
	Test::post(testId());
});
