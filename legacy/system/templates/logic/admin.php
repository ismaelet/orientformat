<?php

// fetch current section
$currentSection = false;

if (strpos(\App\Legacy\LegacyView::getInstance()->page, '-')) {
	$currentPath = explode('/', explode('section-', \App\Legacy\LegacyView::getInstance()->page)[1], 2);
	$currentSection = \App\Legacy\LegacyDB::row('* FROM admin_sections WHERE category=? AND slug=?', [$currentPath[0], $currentPath[1]]);
}

// fetch categories
$menu['categories'] = [];
$queryManager = manager() ? '' : 'manager=0';

$categories = \App\Legacy\LegacyDB::select('* FROM admin_categories ' . ($queryManager ? 'WHERE ' . $queryManager : '') . ' ORDER BY manager ASC, sort ASC, name ASC');

while ($categoryData = $categories->fetch_assoc()) {
	$category = [];
	$category['name'] = $categoryData['name'];
	$category['slug'] = $categoryData['slug'];
	$category['checked'] = $currentSection && $category['slug'] == $currentSection['category'];

	$legacySections = \App\Legacy\LegacyDB::select('* FROM admin_sections WHERE category=? AND hidden=0 ' . ($queryManager ? 'AND ' . $queryManager : '') . ' ORDER BY sort ASC, name ASC', [$category['slug']]);

	while ($legacySectionData = $legacySections->fetch_assoc()) {
		$legacySection = [];
		$legacySection['name'] = $legacySectionData['name'];
		$legacySection['checked'] = $currentSection && $category['checked'] && ($legacySectionData['slug'] == $currentSection['slug'] || ($legacySectionData['hidden'] && str_replace('add', 'list',  $currentSection['slug'])));
		$legacySection['url'] = empty($legacySectionData['url']) ? client_url('/' . $legacySectionData['category'] . '/' . $legacySectionData['slug']) : $legacySectionData['url'];

		$category['sections'][] = $legacySection;
	}

	$menu['categories'][] = $category;
}

$navigationLogo =
	file_exists(SERVER_ROOT . $file = LOGO_DIR . 'logo.svg') ?
	embed_icon(LOGO_DIR . 'logo', ['menu__logo']) :
	'<img class="menu__logo image-fit" src="' . client_path(LOGO_DIR . 'logo.png') . '"></img>';
