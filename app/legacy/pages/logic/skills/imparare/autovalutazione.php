<?php

use LogicManager\TestLogic;

$legacyTest = legacy_test();

$graph_data = [];

for ($i = 1; $i <= 8; $i++) {
	$graph_data[] = [
		__('tests.131-field-' . $i),
		__('tests.131-text-' . $i),
	];
}

$count = count($graph_data);

\Legacy\LogicManager\TestLogic::setParameterCount($count);
