<?php

$areas = [];

// redirect_old('/maintenance');

// content
foreach (schoolClass()->doableAreas as $doableArea) {
	$area['name'] = $doableArea->name;
	$area['id'] = $doableArea->id;
	$area['sections'] = [];

	foreach ($doableArea->getDoableSections(schoolClass()->fullGrade) as $legacySection) {
		if (in_array($legacySection->id, [1, 4, 8, 27])) {
			$area['sections'][] = $legacySection;
		}
	}

	if ($area['sections']) {
		$areas[] = $area;
	}
}
