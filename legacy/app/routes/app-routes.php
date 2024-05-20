<?php

// homepage

use Illuminate\Support\Facades\Auth;

\App\Legacy\LegacyRoute::add(['/', '/orientamento'], function () {
	redirect_old('/login');
});

// support
\App\Legacy\LegacyRoute::add(['/tutorial', '/help'], function () {
	\App\Legacy\LegacyView::setPage('support')
		->setTitle('Supporto')
		->show();
});
