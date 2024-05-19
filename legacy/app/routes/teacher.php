<?php

// teacher panel

use \Legacy\Activity\Area;
use \Legacy\Activity\Section;

\Legacy\System\Classes\LegacyRoute::add('/teacher', function () {
	\Legacy\System\Classes\LegacyView::setPage('teacher/home')
		->addMiddlewares(['teacher'])
		->setTitle('Gestione della classe')
		->show();
});

\Legacy\System\Classes\LegacyRoute::add('/teacher/add-class', function () {
	\Legacy\System\Classes\LegacyView::setPage('teacher/settings/add-class')
		->addMiddlewares(['teacher'])
		->setTitle('Aggiungi una classe')
		->setTemplate('form')
		->show();
});

\Legacy\System\Classes\LegacyRoute::add('/teacher/simulation', function () {
	\Legacy\System\Classes\LegacyView::setPage('teacher/simulation')
		->addMiddlewares(['teacher'])
		->setTitle('Simulazione studente')
		->show();
});

\Legacy\System\Classes\LegacyRoute::add('/teacher/know-more', function () {
	\Legacy\System\Classes\LegacyView::setPage('teacher/know-more')
		->addMiddlewares(['teacher'])
		->setTitle('Saperne di più')
		->show();
});

\Legacy\System\Classes\LegacyRoute::add('/teacher/documents', function () {
	\Legacy\System\Classes\LegacyView::setPage('teacher/documents')
		->addMiddlewares(['teacher'])
		->setTitle('Modulistica')
		->show();
});

\Legacy\System\Classes\LegacyRoute::add('/teacher/settings', function () {
	\Legacy\System\Classes\LegacyView::setPage('teacher/settings')
		->addMiddlewares(['teacher'])
		->setTemplate('form')
		->setTitle('Impostazioni')
		->show();
});

\Legacy\System\Classes\LegacyRoute::add('/teacher/support/open-ticket', function () {
	\Legacy\System\Classes\LegacyView::setPage('teacher/support/open-ticket')
		->addMiddlewares(['teacher'])
		->setTitle('Supporto')
		->show();
});

\Legacy\System\Classes\LegacyRoute::add('/teacher/support', function () {
	\Legacy\System\Classes\LegacyView::setPage('teacher/support/ticket-list')
		->addMiddlewares(['teacher'])
		->setTitle('Supporto')
		->show();
});

\Legacy\System\Classes\LegacyRoute::add('/teacher/paths', function () {
	\Legacy\System\Classes\LegacyView::setPage('teacher/paths')
		->addMiddlewares(['teacher'])
		->setTitle('Percorsi')
		->show();
});

// class panel
\Legacy\System\Classes\LegacyRoute::add('/class', function () {
	\Legacy\System\Classes\LegacyView::setPage('class/home')
		->addMiddlewares(['class'])
		->setTemplate('school-class')
		->setTitle('Gestione della classe')
		->set('dashboard-name', 'class')
		->show();
});

// specific class pages
\Legacy\System\Classes\LegacyRoute::add('/class/*', function ($url) {
	$pageUrl = explode('class/', $url)[1];

	\Legacy\System\Classes\LegacyView::setPage('class/section-' . $pageUrl)
		->addMiddlewares(['class'])
		->setTemplate('school-class')
		->setTitle('Gestione della classe')
		->set('dashboard-name', 'class')
		->show();
});

// read more
\Legacy\System\Classes\LegacyRoute::add('/read', function () {
	$id = $_GET['id'] ?? null;
	$areaId = $_GET['area-id'] ?? null;

	if ($id) $section = \Legacy\System\Classes\LegacyDB::find('slug FROM ' . Section::TABLE . ' WHERE id=?', $id);
	if ($areaId) $area = \Legacy\System\Classes\LegacyDB::find('slug FROM ' . Area::TABLE . ' WHERE id=?', $areaId);

	$page = $id ? $section : 'area-' . $area;

	if (!$page) {
		redirect_old('/');
	}

	\Legacy\System\Classes\LegacyView::setPage('read/' . $page)
		->setTemplate('read')
		->setMiddlewares(['public', 'logged', 'active', 'beginner-review'])
		->show();
});
