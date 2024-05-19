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
	['Pubblica', 'top'],
	['Privata', 'bottom'],
	['Testuale', 'left'],
	['Non testuale', 'right'],
];

$count = count($types);

\LogicManager\TestLogic::setParameterCount($count);
