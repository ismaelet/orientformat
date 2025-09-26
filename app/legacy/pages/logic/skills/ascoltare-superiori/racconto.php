<?php

$answers = [
	[
		'right' => 3
	],
	[
		'right' => 1
	],
	[
		'right' => 4
	],
	[
		'right' => 1
	],
	[
		'right' => 2
	],
	[
		'right' => 4
	],
	[
		'right' => 2
	],
	[
		'right' => 3
	],
	[
		'right' => 2
	],
	[
		'right' => 1
	],
];

include_once(__DIR__ . '/../' . legacy_test()->section->mainSection->slug . '/' . legacy_test()->slug . '.php');

\App\Legacy\StyleLoader::add(legacy_test()->area->slug . '/' . legacy_test()->section->mainSection->slug . '/' . legacy_test()->slug, 'page');
\App\Legacy\ScriptLoader::add(legacy_test()->area->slug . '/' . legacy_test()->section->mainSection->slug . '/' . legacy_test()->slug, 'page');
