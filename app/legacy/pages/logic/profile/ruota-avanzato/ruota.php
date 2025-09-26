<?php

use \Legacy\Activity\Test;
use LogicManager\TestLogic;

\App\Legacy\StyleLoader::add('profile/ruota/ruota', 'page');
\App\Legacy\ScriptLoader::add('profile/ruota/ruota', 'page');

$legacyTest = legacy_test();
$result = $legacyTest->completed ? $legacyTest->rawResults : null;
$resultEmotion = $result ? $result[0] : null;
$resultIntensity = $result ? $result[1] : null;
$resultEmotions = [];
$resultIntensities = [];
$stepNames = ['prima', 'seconda', 'terza'];

if ($legacyTest->completed) {
	$resultEmotions[] = $resultEmotion;
	$resultIntensities[] = $resultIntensity;
}

$emotionCount = count($emotions);

\Legacy\LogicManager\TestLogic::setParameterCount(1);

for ($i = 1; $i < $step; $i++) {
	$relatedTestId = \App\Legacy\LegacyDB::find(Test::INDEX . ' FROM ' . Test::TABLE . ' WHERE ' . Test::SECTION_INDEX . ' = ? AND step = ?', [$legacyTest->sectionId, $i]);
	$relatedTest = new Test($relatedTestId);

	if ($relatedTest->completed) {
		$resultEmotions[] = $relatedTest->rawResults[0];
		$resultIntensities[] = $relatedTest->rawResults[1];
	}
}
