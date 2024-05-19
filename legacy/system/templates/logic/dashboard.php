<?php

/*
* Load configurations
* 	- requires a dashboard name, set in the router
* 	- requires a file in app/config named dashboard-*name* with all the configurations stored in a $dashboardConfig variable
*/
$dashboardName = \App\Legacy\LegacyView::get('dashboard-name');

require_once(SERVER_ROOT . '/app/config/dashboard-' . $dashboardName . '.php');

// load template parts
\App\Legacy\StyleLoader::add('-expands-dashboard/list', 'template');

// fetch current section
$currentPath = false;

if (strpos((\App\Legacy\LegacyView::getInstance())->name, '-')) {
	$path = explode('/', explode('section-', str_replace('add', 'list', (\App\Legacy\LegacyView::getInstance())->name))[1], 2);
	$currentPath = [
		'category' => $path[0],
		'link' => $path[1],
	];
} else {
	$currentPath = [
		'category' => 'home',
	];
}

// fetch categories
$dashboardNavigation = [];

foreach ($dashboardConfig['navigation'] as $category) {
	$dashboardCategory = [];
	$dashboardCategory['title'] = $category['title'];
	$dashboardCategory['slug'] = $category['slug'];
	$dashboardCategory['url'] = $category['url'] ?? null;
	$dashboardCategory['checked'] = $currentPath && $dashboardCategory['slug'] == $currentPath['category'];
	$dashboardCategory['links'] = [];

	if (!empty($category['links'])) {
		foreach ($category['links'] as $link) {
			$dashboardLink = [];
			$dashboardLink['title'] = $link['title'];
			$dashboardLink['slug'] = $link['slug'];
			$dashboardLink['checked'] = $dashboardCategory['checked'] && $dashboardLink['slug'] == $currentPath['link'];
			$dashboardLink['url'] = $link['url'] ?? client_url('/' . $dashboardConfig['path'] . '/' . $category['slug'] . '/' . $link['slug']);

			$dashboardCategory['links'][] = $dashboardLink;
		}
	}

	$dashboardNavigation[] = $dashboardCategory;
}
