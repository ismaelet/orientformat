<?php

// management panel
RouteOld::add('/management', function () {
	$view = new View('management/home');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';
	$view->show();
});

// schools - add
RouteOld::add('/management/schools/add', function () {
	$view = new View('management/schools/add');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';
	$view->template = 'management-add';
	$view->show();
});

// schools - list
RouteOld::add('/management/schools/list', function () {
	$view = new View('management/schools/list');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';
	$view->template = 'management-list';
	$view->show();
});

// classes - add
RouteOld::add('/management/classes/add', function () {
	$view = new View('management/classes/add');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';
	$view->template = 'management-add';
	$view->show();
});

// classes - list
RouteOld::add('/management/classes/list', function () {
	$view = new View('management/classes/list');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';
	$view->template = 'management-list';
	$view->show();
});

// classes - results
RouteOld::add('/management/classes/results', function () {
	$view = new View('management/classes/results');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';
	$view->template = 'management-list';
	$view->show();
});

// teachers - add
RouteOld::add('/management/teachers/add', function () {
	$view = new View('management/teachers/add');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';
	$view->template = 'management-add';
	$view->show();
});

// teachers - reset password
RouteOld::add('/management/teachers/reset', function () {
	$view = new View('management/teachers/reset');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';
	$view->show();
});

// teachers - list
RouteOld::add('/management/teachers/list', function () {
	$view = new View('management/teachers/list');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';
	$view->template = 'management-list';
	$view->show();
});

// students - list
RouteOld::add('/management/students/list', function () {
	$view = new View('management/students/list');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';
	$view->template = 'management-list';
	$view->show();
});

// students - download
RouteOld::add('/management/students/download', function () {
	$view = new View('management/students/download');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';
	$view->show();
});

// students - results
RouteOld::add('/management/students/results', function () {
	$view = new View('management/students/results');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';
	$view->show();
});

// students - completed
RouteOld::add('/management/students/completed', function () {
	$view = new View('management/students/completed');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';
	$view->show();
});
