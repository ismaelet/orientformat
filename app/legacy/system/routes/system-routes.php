<?php

\App\Legacy\LegacyRoute::add('/favicon.ico', function () {
    include SERVER_ROOT.'/app/assets/favicon/favicon.ico';
});
