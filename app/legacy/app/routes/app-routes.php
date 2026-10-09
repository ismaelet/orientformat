<?php

\App\Legacy\LegacyRoute::add(['/', '/' . env('APP_SUBDOMAIN')], function () {
    redirect_old('/login');
});

\App\Legacy\LegacyRoute::add(['/tutorial', '/help'], function () {
    return \App\Legacy\LegacyView::setPage('support')
        ->setTitle('Supporto')
        ->show();
});
