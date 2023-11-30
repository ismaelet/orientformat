<?php

$areas = [];

// redirect('/maintenance');

// content
foreach (schoolClass()->doableAreas as $doableArea) {
	$area['name'] = $doableArea->name;
	$area['id'] = $doableArea->id;
	$area['sections'] = [];

	foreach ($doableArea->getDoableSections(schoolClass()->fullGrade) as $section) {
		if (in_array($section->id, [1, 4, 8, 27])) {
			$area['sections'][] = $section;
		}
	}

	if ($area['sections']) {
		$areas[] = $area;
	}
}
