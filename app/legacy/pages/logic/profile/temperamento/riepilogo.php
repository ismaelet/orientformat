<?php

use \Legacy\Activity\Test;

$legacyTest = test();

// sections
$results = [];
$legacySections = test_config($legacyTest->id, 'sections');

for ($i = 1; $i < 6; $i++) {
	$requiredTestId = \App\Legacy\LegacyDB::find('id FROM ' . Test::TABLE . ' WHERE sectionId = ? AND step = ?', [$legacyTest->sectionId, $i]);
	$requiredTest = new Test($requiredTestId);

	$results[] = round($requiredTest->percentage / 100 * 6);
}

bump($legacySections);
bump($results);

// reset
if (isset($_POST['reset-test'])) {
	(new Test($_POST['reset-test']))->redo();
}
