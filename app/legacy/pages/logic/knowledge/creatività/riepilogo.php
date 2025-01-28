<?php

use \Legacy\Activity\Test;

$legacyTest = test();

// setup variables
$results = [];

for ($i = 1; $i < $legacyTest->step; $i++) {

	$requiredTestId = \App\Legacy\LegacyDB::find('id FROM ' . Test::TABLE . ' WHERE sectionId = ? AND step = ?', [$legacyTest->sectionId, $i]);

	$requiredTest = new Test($requiredTestId);
	$results[$i]['id'] = $requiredTest->id;
	$results[$i]['title'] = $requiredTest->title;
	$results[$i]['completed'] = $requiredTest->completed;
	$results[$i]['url'] = $requiredTest->clientUrl;
	$results[$i]['score'] = $requiredTest->completed ? ((int) $requiredTest->percentage) . '%' : 'Da fare';
}

/*
* Form handling
*/
if (isset($_POST['reset-test'])) {
	(new Test($_POST['reset-test']))->redo();
}
