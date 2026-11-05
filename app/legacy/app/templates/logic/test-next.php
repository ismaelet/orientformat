<?php

use App\Http\Controllers\Activities\TestNextController;
use Legacy\Http\TempLegacyRoute;

TempLegacyRoute::get(function () {
    TestNextController::get(testId());
});

TempLegacyRoute::post(function () {
    TestNextController::post(testId());
});
