<?php

$questions = [
	__('tests.138-question-1'),
	__('tests.138-question-2'),
	__('tests.138-question-3'),
	__('tests.138-question-4'),
	__('tests.138-question-5'),
	__('tests.138-question-6'),
	__('tests.138-question-7'),
	__('tests.138-question-8'),
	__('tests.138-question-9'),
	__('tests.138-question-10'),
];

$answers = [
	[
		'res' => [__('tests.138-answers-1-1'), __('tests.138-answers-1-2'), __('tests.138-answers-1-3')],
		'right' => 3
	],
	[
		'res' => [__('tests.138-answers-2-1'), __('tests.138-answers-2-2'), __('tests.138-answers-2-3')],
		'right' => 2
	],
	[
		'res' => [__('tests.138-answers-3-1'), __('tests.138-answers-3-2'), __('tests.138-answers-3-3')],
		'right' => 1
	],
	[
		'res' => [__('tests.138-answers-4-1'), __('tests.138-answers-4-2'), __('tests.138-answers-4-3')],
		'right' => 2
	],
	[
		'res' => [__('tests.138-answers-5-1'), __('tests.138-answers-5-2'), __('tests.138-answers-5-3')],
		'right' => 3
	],
	[
		'res' => [__('tests.138-answers-6-1'), __('tests.138-answers-6-2'), __('tests.138-answers-6-3')],
		'right' => 1
	],
	[
		'res' => [__('tests.138-answers-7-1'), __('tests.138-answers-7-2'), __('tests.138-answers-7-3')],
		'right' => 3
	],
	[
		'res' => [__('tests.138-answers-8-1'), __('tests.138-answers-8-2'), __('tests.138-answers-8-3')],
		'right' => 1
	],
	[
		'res' => [__('tests.138-answers-9-1'), __('tests.138-answers-9-2'), __('tests.138-answers-9-3')],
		'right' => 1
	],
	[
		'res' => [__('tests.138-answers-10-1'), __('tests.138-answers-10-2'), __('tests.138-answers-10-3')],
		'right' => 3
	],
];

include_once(__DIR__ . '/../' . legacy_test()->section->mainSection->slug . '/' . legacy_test()->slug . '.php');

\App\Legacy\StyleLoader::add(legacy_test()->area->slug . '/' . legacy_test()->section->mainSection->slug . '/' . legacy_test()->slug, 'page');
\App\Legacy\ScriptLoader::add(legacy_test()->area->slug . '/' . legacy_test()->section->mainSection->slug . '/' . legacy_test()->slug, 'page');
