<?php

// elements

use UserSystem\Student;

$header = [];

$h_comp = [];

$h_comp['logo'] = true;
$h_comp['name-bar'] = false;
$h_comp['srch-bar'] = false;
$h_comp['lang-bar'] = false;
$h_comp['login'] = true;
$h_comp['force-mob'] = false;
$h_comp['privacy'] = true;
$h_comp['wishlist'] = false;

$header['color'] = 'light';
$header['floating'] = false;

// name
$h_name = '<span class="txt-c1">O</span>RIENTAMENTO';
$h_name_mob = '<span class="txt-c1">Ori.</span>For.';

// links
$h_links = [];

$raw_links = [
	[
		'title' => 'Gestisci classe',
		'loc' => 'teacher',
		'url' => CLIENT_ROOT . '/teacher',
		'logged' => true,
		'teacher' => true,
		'mobile' => true,
	],
	[
		'title' => 'Attività',
		'loc' => 'activities',
		'url' => CLIENT_ROOT . '/activities',
		'logged' => true,
		'student' => true,
	],
	[
		'title' => 'Simulazione',
		'loc' => '',
		'url' => client_url('/teacher/simulation'),
		'teacher' => true,
		'drop' => 'simulation',
	],
	[
		'title' => 'Saperne di più',
		'loc' => '',
		'url' => client_url('/teacher/know-more'),
		'teacher' => true,
	],
	[
		'title' => 'Contattaci',
		'loc' => '',
		'url' => client_url('/teacher/support/open-ticket'),
		'teacher' => true,
	],
	[
		'title' => 'Gestione',
		'loc' => 'admin',
		'url' => client_url('/admin'),
		'manager' => true,
	],
	[
		'title' => 'Supporto',
		'loc' => 'help',
		'url' => client_url('/help'),
	],
	[
		'title' => 'Login',
		'loc' => 'login',
		'url' => CLIENT_ROOT . '/login',
		'logged' => false,
		'mobile' => true,

	],
	[
		'title' => 'Logout',
		'loc' => 'login',
		'url' => CLIENT_ROOT . '/logout',
		'logged' => true,
		'mobile' => true,
	],
	[
		'title' => 'Logout',
		'loc' => 'login',
		'url' => CLIENT_ROOT . '/logout',
		'logged' => true,
		'teacher' => true,
		'mobile' => false,
	]
];

foreach ($raw_links as $link) {

	$valid = true;

	// check logged filter
	if (isset($link['logged'])) {

		if ($link['logged'] && !userId()) $valid = false;
		else if (!$link['logged'] && userId()) $valid = false;
	}

	// check student filter
	if (isset($link['student']) && user()->groupId != 0) $valid = false;

	// check teacher filter
	if (isset($link['teacher']) && user()->groupId != 1) $valid = false;

	// check manager filter
	if (isset($link['manager']) && !manager()) $valid = false;

	// check admin filter
	if (isset($link['admin']) && !admin()) $valid = false;

	if ($valid) $h_links[] = $link;
}

// login bar
$h_log_out = ['Login', CLIENT_ROOT . '/login'];
$h_log_in = false;

if (userId()) {
	if (user()->groupId == 2) $h_log_in = ['Amministrazione', CLIENT_ROOT . '/management'];
	else if (user()->groupId == 1) $h_log_in = ['Gestione Classi', CLIENT_ROOT . '/teacher'];
	else $h_log_in = ['Logout', client_url('/logout')];
}

// survey end
$header['survey-end'] = false;

if (
	logged() &&
	!user()->groupId &&
	View::getInstance()->location != 'review' &&
	!DB::exists('review_results WHERE studentId = ? AND reviewId = 3', [userId()])
) {
	$h_grade = (new Student(userId()))->schoolClass;
	$header['survey-end'] = $h_grade && $h_grade->ended;
}

$h_drop = [
	'simulation' => [
		['Scuola secondaria di primo grado', '/teacher/simulation?type=middle-school'],
		['Istituti Tecnici, Professionali e Licei', '/teacher/simulation?type=high-school'],
		['Istruzione e Formazione Professionale', '/teacher/simulation?type=professional-school'],
	],
];
