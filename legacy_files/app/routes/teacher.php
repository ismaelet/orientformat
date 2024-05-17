<?php

// teacher panel

use \Legacy\Activity\Area;
use \Legacy\Activity\Section;

RouteOld::add('/teacher', function () {
	ViewOld::setPage('teacher/home')
		->addMiddlewares(['teacher'])
		->setTitle('Gestione della classe')
		->show();
});

RouteOld::add('/teacher/add-class', function () {
	ViewOld::setPage('teacher/settings/add-class')
		->addMiddlewares(['teacher'])
		->setTitle('Aggiungi una classe')
		->setTemplate('form')
		->show();
});

RouteOld::add('/teacher/simulation', function () {
	ViewOld::setPage('teacher/simulation')
		->addMiddlewares(['teacher'])
		->setTitle('Simulazione studente')
		->show();
});

RouteOld::add('/teacher/know-more', function () {
	ViewOld::setPage('teacher/know-more')
		->addMiddlewares(['teacher'])
		->setTitle('Saperne di più')
		->show();
});

RouteOld::add('/teacher/documents', function () {
	ViewOld::setPage('teacher/documents')
		->addMiddlewares(['teacher'])
		->setTitle('Modulistica')
		->show();
});

RouteOld::add('/teacher/settings', function () {
	ViewOld::setPage('teacher/settings')
		->addMiddlewares(['teacher'])
		->setTemplate('form')
		->setTitle('Impostazioni')
		->show();
});

RouteOld::add('/teacher/support/open-ticket', function () {
	ViewOld::setPage('teacher/support/open-ticket')
		->addMiddlewares(['teacher'])
		->setTitle('Supporto')
		->show();
});

RouteOld::add('/teacher/support', function () {
	ViewOld::setPage('teacher/support/ticket-list')
		->addMiddlewares(['teacher'])
		->setTitle('Supporto')
		->show();
});

RouteOld::add('/teacher/paths', function () {
	ViewOld::setPage('teacher/paths')
		->addMiddlewares(['teacher'])
		->setTitle('Percorsi')
		->show();
});

// class panel
RouteOld::add('/class', function () {
	ViewOld::setPage('class/home')
		->addMiddlewares(['class'])
		->setTemplate('school-class')
		->setTitle('Gestione della classe')
		->set('dashboard-name', 'class')
		->show();
});

// specific class pages
RouteOld::add('/class/*', function ($url) {
	$pageUrl = explode('class/', $url)[1];

	ViewOld::setPage('class/section-' . $pageUrl)
		->addMiddlewares(['class'])
		->setTemplate('school-class')
		->setTitle('Gestione della classe')
		->set('dashboard-name', 'class')
		->show();
});

// read more
RouteOld::add('/read', function () {
	$id = $_GET['id'] ?? null;
	$areaId = $_GET['area-id'] ?? null;

	if ($id) $section = \System\Classes\DBOld::find('slug FROM ' . Section::TABLE . ' WHERE id=?', $id);
	if ($areaId) $area = \System\Classes\DBOld::find('slug FROM ' . Area::TABLE . ' WHERE id=?', $areaId);

	$page = $id ? $section : 'area-' . $area;

	if (!$page) {
		redirect_old('/');
	}

	ViewOld::setPage('read/' . $page)
		->setTemplate('read')
		->setMiddlewares(['public', 'logged', 'active', 'beginner-review'])
		->show();
});
