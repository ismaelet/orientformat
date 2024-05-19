<?php

//management panel
\Legacy\System\Classes\LegacyRoute::add('/management', function () {

	//setup page
	$view = new View('management/home');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';

	//render page
	$view->show();
});

//schools - add
\Legacy\System\Classes\LegacyRoute::add('/management/schools/add', function () {

	//setup page
	$view = new View('management/schools/add');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';
	$view->template = 'management-add';

	//render page
	$view->show();
});

//schools - list
\Legacy\System\Classes\LegacyRoute::add('/management/schools/list', function () {

	//setup page
	$view = new View('management/schools/list');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';
	$view->template = 'management-list';

	//render page
	$view->show();
});

//classes - add
\Legacy\System\Classes\LegacyRoute::add('/management/classes/add', function () {

	//setup page
	$view = new View('management/classes/add');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';
	$view->template = 'management-add';

	//render page
	$view->show();
});

//classes - list
\Legacy\System\Classes\LegacyRoute::add('/management/classes/list', function () {

	//setup page
	$view = new View('management/classes/list');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';
	$view->template = 'management-list';

	//render page
	$view->show();
});

//classes - results
\Legacy\System\Classes\LegacyRoute::add('/management/classes/results', function () {

	//setup page
	$view = new View('management/classes/results');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';
	$view->template = 'management-list';

	//render page
	$view->show();
});

//teachers - add
\Legacy\System\Classes\LegacyRoute::add('/management/teachers/add', function () {

	//setup page
	$view = new View('management/teachers/add');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';
	$view->template = 'management-add';

	//render page
	$view->show();
});

//teachers - reset password
\Legacy\System\Classes\LegacyRoute::add('/management/teachers/reset', function () {

	//setup page
	$view = new View('management/teachers/reset');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';

	//render page
	$view->show();
});

//teachers - list
\Legacy\System\Classes\LegacyRoute::add('/management/teachers/list', function () {

	//setup page
	$view = new View('management/teachers/list');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';
	$view->template = 'management-list';

	//render page
	$view->show();
});

//students - list
\Legacy\System\Classes\LegacyRoute::add('/management/students/list', function () {

	//setup page
	$view = new View('management/students/list');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';
	$view->template = 'management-list';

	//render page
	$view->show();
});

//students - download
\Legacy\System\Classes\LegacyRoute::add('/management/students/download', function () {

	//setup page
	$view = new View('management/students/download');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';

	//render page
	$view->show();
});

//students - results
\Legacy\System\Classes\LegacyRoute::add('/management/students/results', function () {

	//setup page
	$view = new View('management/students/results');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';

	//render page
	$view->show();
});

//students - completed
\Legacy\System\Classes\LegacyRoute::add('/management/students/completed', function () {

	//setup page
	$view = new View('management/students/completed');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';

	//render page
	$view->show();
});
