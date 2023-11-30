<?php

// teacher panel

use Activity\Area;
use Activity\Section;

Route::add('/teacher', function () {
	View::setPage('teacher/home')
		->addMiddlewares(['teacher'])
		->setTitle('Gestione della classe')
		->show();
});

Route::add('/teacher/add-class', function () {
	View::setPage('teacher/settings/add-class')
		->addMiddlewares(['teacher'])
		->setTitle('Aggiungi una classe')
		->setTemplate('form')
		->show();
});

Route::add('/teacher/simulation', function () {
	View::setPage('teacher/simulation')
		->addMiddlewares(['teacher'])
		->setTitle('Simulazione studente')
		->show();
});

Route::add('/teacher/know-more', function () {
	View::setPage('teacher/know-more')
		->addMiddlewares(['teacher'])
		->setTitle('Saperne di più')
		->show();
});

Route::add('/teacher/documents', function () {
	View::setPage('teacher/documents')
		->addMiddlewares(['teacher'])
		->setTitle('Modulistica')
		->show();
});

Route::add('/teacher/settings', function () {
	View::setPage('teacher/settings')
		->addMiddlewares(['teacher'])
		->setTemplate('form')
		->setTitle('Impostazioni')
		->show();
});

Route::add('/teacher/support/open-ticket', function () {
	View::setPage('teacher/support/open-ticket')
		->addMiddlewares(['teacher'])
		->setTitle('Supporto')
		->show();
});

Route::add('/teacher/support', function () {
	View::setPage('teacher/support/ticket-list')
		->addMiddlewares(['teacher'])
		->setTitle('Supporto')
		->show();
});

Route::add('/teacher/paths', function () {
	View::setPage('teacher/paths')
		->addMiddlewares(['teacher'])
		->setTitle('Percorsi')
		->show();
});

// class panel
Route::add('/class', function () {
	View::setPage('class/home')
		->addMiddlewares(['class'])
		->setTemplate('school-class')
		->setTitle('Gestione della classe')
		->set('dashboard-name', 'class')
		->show();
});

// specific class pages
Route::add('/class/*', function ($url) {
	$pageUrl = explode('class/', $url)[1];

	View::setPage('class/section-' . $pageUrl)
		->addMiddlewares(['class'])
		->setTemplate('school-class')
		->setTitle('Gestione della classe')
		->set('dashboard-name', 'class')
		->show();
});

// read more
Route::add('/read', function () {
	$id = $_GET['id'] ?? null;
	$areaId = $_GET['area-id'] ?? null;

	if ($id) $section = DB::find('slug FROM ' . Section::TABLE . ' WHERE id=?', $id);
	if ($areaId) $area = DB::find('slug FROM ' . Area::TABLE . ' WHERE id=?', $areaId);

	$page = $id ? $section : 'area-' . $area;

	if (!$page) {
		redirect('/');
	}

	View::setPage('read/' . $page)
		->setTemplate('read')
		->setMiddlewares(['public', 'logged', 'active', 'beginner-review'])
		->show();
});
