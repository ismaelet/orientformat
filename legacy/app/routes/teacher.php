<?php

// teacher panel

use \Legacy\Activity\Area;

\App\Legacy\LegacyRoute::add('/teacher', function () {
	\App\Legacy\LegacyView::setPage('teacher/home')
		->addMiddlewares(['teacher'])
		->setTitle('Gestione della classe')
		->show();
});

\App\Legacy\LegacyRoute::add('/teacher/add-class', function () {
	\App\Legacy\LegacyView::setPage('teacher/settings/add-class')
		->addMiddlewares(['teacher'])
		->setTitle('Aggiungi una classe')
		->setTemplate('form')
		->show();
});

\App\Legacy\LegacyRoute::add('/teacher/simulation', function () {
	\App\Legacy\LegacyView::setPage('teacher/simulation')
		->addMiddlewares(['teacher'])
		->setTitle('Simulazione studente')
		->show();
});

\App\Legacy\LegacyRoute::add('/teacher/know-more', function () {
	\App\Legacy\LegacyView::setPage('teacher/know-more')
		->addMiddlewares(['teacher'])
		->setTitle('Saperne di più')
		->show();
});

\App\Legacy\LegacyRoute::add('/teacher/documents', function () {
	\App\Legacy\LegacyView::setPage('teacher/documents')
		->addMiddlewares(['teacher'])
		->setTitle('Modulistica')
		->show();
});

\App\Legacy\LegacyRoute::add('/teacher/settings', function () {
	\App\Legacy\LegacyView::setPage('teacher/settings')
		->addMiddlewares(['teacher'])
		->setTemplate('form')
		->setTitle('Impostazioni')
		->show();
});

\App\Legacy\LegacyRoute::add('/teacher/support/open-ticket', function () {
	\App\Legacy\LegacyView::setPage('teacher/support/open-ticket')
		->addMiddlewares(['teacherOrAdministrator'])
		->setTitle('Supporto')
		->show();
});

\App\Legacy\LegacyRoute::add('/teacher/support', function () {
	\App\Legacy\LegacyView::setPage('teacher/support/ticket-list')
		->addMiddlewares(['teacher'])
		->setTitle('Supporto')
		->show();
});

\App\Legacy\LegacyRoute::add('/teacher/paths', function () {
	\App\Legacy\LegacyView::setPage('teacher/paths')
		->addMiddlewares(['teacher'])
		->setTitle('Percorsi')
		->show();
});

// class panel
\App\Legacy\LegacyRoute::add('/class', function () {
	\App\Legacy\LegacyView::setPage('class/home')
		->addMiddlewares(['class'])
		->setTemplate('school-class')
		->setTitle('Gestione della classe')
		->set('dashboard-name', 'class')
		->show();
});

// specific class pages
\App\Legacy\LegacyRoute::add('/class/*', function ($url) {
	$pageUrl = explode('class/', $url)[1];

	\App\Legacy\LegacyView::setPage('class/section-' . $pageUrl)
		->addMiddlewares(['class'])
		->setTemplate('school-class')
		->setTitle('Gestione della classe')
		->set('dashboard-name', 'class')
		->show();
});

// read more
\App\Legacy\LegacyRoute::add('/read', function () {
	$id = $_GET['id'] ?? null;
	$areaId = $_GET['area-id'] ?? null;

	if ($id) $legacySection = \App\Legacy\LegacyDB::find('slug FROM activities_sections WHERE id=?', $id);
	if ($areaId) $area = \App\Legacy\LegacyDB::find('slug FROM ' . Area::TABLE . ' WHERE id=?', $areaId);

	$page = $id ? $legacySection : 'area-' . $area;

	if (!$page) {
		redirect_old('/');
	}

	\App\Legacy\LegacyView::setPage('read/' . $page)
		->setTemplate('read')
		->setMiddlewares(['public', 'logged', 'active', 'beginner-review'])
		->show();
});
