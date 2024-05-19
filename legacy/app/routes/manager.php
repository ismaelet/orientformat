<?php

// management panel
\App\Legacy\LegacyRoute::add('/management', function () {
	$view = new View('management/home');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';
	$view->show();
});

// schools - add
\App\Legacy\LegacyRoute::add('/management/schools/add', function () {
	$view = new View('management/schools/add');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';
	$view->template = 'management-add';
	$view->show();
});

// schools - list
\App\Legacy\LegacyRoute::add('/management/schools/list', function () {
	$view = new View('management/schools/list');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';
	$view->template = 'management-list';
	$view->show();
});

// classes - add
\App\Legacy\LegacyRoute::add('/management/classes/add', function () {
	$view = new View('management/classes/add');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';
	$view->template = 'management-add';
	$view->show();
});

// classes - list
\App\Legacy\LegacyRoute::add('/management/classes/list', function () {
	$view = new View('management/classes/list');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';
	$view->template = 'management-list';
	$view->show();
});

// classes - results
\App\Legacy\LegacyRoute::add('/management/classes/results', function () {
	$view = new View('management/classes/results');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';
	$view->template = 'management-list';
	$view->show();
});

// teachers - add
\App\Legacy\LegacyRoute::add('/management/teachers/add', function () {
	$view = new View('management/teachers/add');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';
	$view->template = 'management-add';
	$view->show();
});

// teachers - reset password
\App\Legacy\LegacyRoute::add('/management/teachers/reset', function () {
	$view = new View('management/teachers/reset');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';
	$view->show();
});

// teachers - list
\App\Legacy\LegacyRoute::add('/management/teachers/list', function () {
	$view = new View('management/teachers/list');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';
	$view->template = 'management-list';
	$view->show();
});

// students - list
\App\Legacy\LegacyRoute::add('/management/students/list', function () {
	$view = new View('management/students/list');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';
	$view->template = 'management-list';
	$view->show();
});

// students - download
\App\Legacy\LegacyRoute::add('/management/students/download', function () {
	$view = new View('management/students/download');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';
	$view->show();
});

// students - results
\App\Legacy\LegacyRoute::add('/management/students/results', function () {
	$view = new View('management/students/results');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';
	$view->show();
});

// students - completed
\App\Legacy\LegacyRoute::add('/management/students/completed', function () {
	$view = new View('management/students/completed');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';
	$view->show();
});
