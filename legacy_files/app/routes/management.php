<?php

//management panel
RouteOld::add('/management', function () {

	//setup page
	$view = new View('management/home');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';

	//render page
	$view->show();
});

//schools - add
RouteOld::add('/management/schools/add', function () {

	//setup page
	$view = new View('management/schools/add');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';
	$view->template = 'management-add';

	//render page
	$view->show();
});

//schools - list
RouteOld::add('/management/schools/list', function () {

	//setup page
	$view = new View('management/schools/list');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';
	$view->template = 'management-list';

	//render page
	$view->show();
});

//classes - add
RouteOld::add('/management/classes/add', function () {

	//setup page
	$view = new View('management/classes/add');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';
	$view->template = 'management-add';

	//render page
	$view->show();
});

//classes - list
RouteOld::add('/management/classes/list', function () {

	//setup page
	$view = new View('management/classes/list');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';
	$view->template = 'management-list';

	//render page
	$view->show();
});

//classes - results
RouteOld::add('/management/classes/results', function () {

	//setup page
	$view = new View('management/classes/results');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';
	$view->template = 'management-list';

	//render page
	$view->show();
});

//teachers - add
RouteOld::add('/management/teachers/add', function () {

	//setup page
	$view = new View('management/teachers/add');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';
	$view->template = 'management-add';

	//render page
	$view->show();
});

//teachers - reset password
RouteOld::add('/management/teachers/reset', function () {

	//setup page
	$view = new View('management/teachers/reset');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';

	//render page
	$view->show();
});

//teachers - list
RouteOld::add('/management/teachers/list', function () {

	//setup page
	$view = new View('management/teachers/list');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';
	$view->template = 'management-list';

	//render page
	$view->show();
});

//students - list
RouteOld::add('/management/students/list', function () {

	//setup page
	$view = new View('management/students/list');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';
	$view->template = 'management-list';

	//render page
	$view->show();
});

//students - download
RouteOld::add('/management/students/download', function () {

	//setup page
	$view = new View('management/students/download');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';

	//render page
	$view->show();
});

//students - results
RouteOld::add('/management/students/results', function () {

	//setup page
	$view = new View('management/students/results');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';

	//render page
	$view->show();
});

//students - completed
RouteOld::add('/management/students/completed', function () {

	//setup page
	$view = new View('management/students/completed');
	$view->title('Pannello amministrativo');
	$view->middlewares[] = 'management';

	//render page
	$view->show();
});
