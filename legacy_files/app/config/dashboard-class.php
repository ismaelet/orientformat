<?php

$dashboardNavigation = [];

$dashboardNavigation[] =
	[
		'title' => 'Tutte le classi',
		'slug' => 'classes',
		'url' => client_url('/')
	];

$dashboardNavigation[] =
	[
		'title' => 'Riepilogo',
		'slug' => 'home',
		'url' => client_url('/class')
	];

$dashboardNavigation[] =
	[
		'title' => 'Classe',
		'slug' => 'class-progress',
		'links' => [
			['title' => 'Progresso della classe', 'slug' => 'graphs'],
		]
	];

if (schoolClass()->isMiddleSchool) {
	$dashboardNavigation[] =
		[
			'title' => 'Studenti',
			'slug' => 'students',
			'links' => [
				['title' => 'Lista degli studenti', 'slug' => 'list'],
				['title' => 'Progresso degli studenti', 'slug' => 'progress/list'],
				['title' => 'Consigli orientativi', 'slug' => 'suggestion']
			]
		];
} else {
	$dashboardNavigation[] =
		[
			'title' => 'Studenti',
			'slug' => 'students',
			'links' => [
				['title' => 'Lista degli studenti', 'slug' => 'list'],
				['title' => 'Progresso degli studenti', 'slug' => 'progress/list'],
			]
		];
}

$dashboardNavigation[] =
	[
		'title' => 'Impostazioni',
		'slug' => 'settings',
		'links' => [
			['title' => 'Impostazioni generali', 'slug' => 'general'],
		]
	];

$dashboardConfig = [
	'path' => 'class',
	'logo' => false,
	'return-link' => true,
	'navigation' => $dashboardNavigation,
];

unset($dashboardNavigation);
