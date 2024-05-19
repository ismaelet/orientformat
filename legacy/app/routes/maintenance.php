<?php

//offline
\App\Legacy\LegacyRoute::add('/offline', function () {

	//setup page
	$view = new View('errors/offline');
	$view->title = 'Offline';
	$view->template = 'void';
	$view->middlewares = [];

	//render page
	$view->show();
});
