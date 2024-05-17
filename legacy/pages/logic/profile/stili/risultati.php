<?php

//fetch sibling test data
$sibling = new \Legacy\Activity\Test($test->step - 1, $user);

//set groups
$groups = ['Visivo', 'Collaborativo', 'Globale', 'Intuitivo', 'Uditivo', 'Autonomo', 'Analitico', 'Sistematico'];

$count = count($groups);

bump($groups);

//calculate the results
$results = [];

foreach ($sibling->rawResults as $key => $result) {

	switch (true) {
		case in_array($key, [3, 9, 13]):
			$group = 1;
			break;
		case in_array($key, [1, 18, 23]):
			$group = 2;
			break;
		case in_array($key, [6, 10, 19]):
			$group = 3;
			break;
		case in_array($key, [0, 12, 21]):
			$group = 4;
			break;
		case in_array($key, [5, 11, 16]):
			$group = 5;
			break;
		case in_array($key, [2, 4, 17]):
			$group = 6;
			break;
		case in_array($key, [7, 15, 22]):
			$group = 7;
			break;
		case in_array($key, [8, 14, 20]):
			$group = 8;
			break;
	}

	if (!isset($results[$group])) $results[$group] = 0;

	$results[$group] += ($result + 1) / 3;
}

//prepare the circles
$circles = [];

foreach ($groups as $key => $group) {

	$circle['group'] = $key;

	for ($i = 1; $i < 5; $i++) {

		$angle = deg2rad(360 / $count * ($key + 5));

		$circle['val'] = $i;

		$circle['w'] = round(cos($angle), 4);
		$circle['h'] = round(sin($angle), 4);

		$circle['checked'] = round($results[$key]) == (5 - $i);

		$circles[] = $circle;
	}
}
