<?php

use LogicManager\TestLogic;

$legacyTest = test();
$sibling = $legacyTest->requiredTest;

$results = [];
$types = test_config(63, 'types');

if ($sibling->completed) {
	foreach ($types as $key => $type) {
		$results[] = [
			'title' => $type,
			'score' => $sibling->rawResults[$key] - 1,
		];
	}
}

$categories = [
	[__('tests.63-group-1'), 'top'],
	[__('tests.63-group-2'), 'bottom'],
	[__('tests.63-group-3'), 'left'],
	[__('tests.63-group-4'), 'right'],
];

$count = count($types);

\LogicManager\TestLogic::setParameterCount($count);
