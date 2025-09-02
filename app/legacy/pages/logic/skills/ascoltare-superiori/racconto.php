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

include_once(__DIR__ . '/../' . test()->section->mainSection->slug . '/' . test()->slug . '.php');

\App\Legacy\StyleLoader::add(test()->area->slug . '/' . test()->section->mainSection->slug . '/' . test()->slug, 'page');
\App\Legacy\ScriptLoader::add(test()->area->slug . '/' . test()->section->mainSection->slug . '/' . test()->slug, 'page');
