<?php

\App\Legacy\LegacyRoute::add(['/', '/orientamento'], function () {
	redirect_old('/login');
});

\App\Legacy\LegacyRoute::add(['/tutorial', '/help'], function () {
	\App\Legacy\LegacyView::setPage('support')
		->setTitle('Supporto')
		->show();
});
