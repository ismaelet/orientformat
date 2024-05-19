<?php

use \Legacy\Activity\Test;

$test = test();

// sections
$results = [];
$sections = test_config($test->id, 'sections');

for ($i = 1; $i < 6; $i++) {
	$requiredTestId = \Legacy\System\Classes\LegacyDB::find('id FROM ' . Test::TABLE . ' WHERE sectionId = ? AND step = ?', [$test->sectionId, $i]);
	$requiredTest = new Test($requiredTestId);

	$results[] = round($requiredTest->percentage / 100 * 6);
}

bump($sections);
bump($results);

// reset
if (isset($_POST['reset-test'])) {
	(new Test($_POST['reset-test']))->redo();
}
