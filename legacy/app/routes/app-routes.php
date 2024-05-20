<?php

\App\Legacy\LegacyRoute::add(['/tutorial', '/help'], function () {
	\App\Legacy\LegacyView::setPage('support')
		->setTitle('Supporto')
		->show();
});
