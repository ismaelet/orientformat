<?php

use App\Legacy\LegacyRoute;

LegacyRoute::add('/favicon.ico', function () {
    include SERVER_ROOT.'/app/assets/favicon/favicon.ico';
});
