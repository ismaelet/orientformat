<?php

use Legacy\Http\Controllers\Activities\Test;
use Legacy\Http\TempLegacyRoute;

TempLegacyRoute::get(function () {
    Test::get(testId());
});

TempLegacyRoute::post(function () {
    Test::post(testId());
});
