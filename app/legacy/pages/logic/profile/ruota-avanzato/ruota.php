<?php

use App\Legacy\ScriptLoader;
use App\Legacy\StyleLoader;
use Illuminate\Support\Facades\DB;
use Legacy\Activity\Test;
use Legacy\LogicManager\TestLogic;

StyleLoader::add('profile/ruota/ruota', 'page');
ScriptLoader::add('profile/ruota/ruota', 'page');

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

TestLogic::setParameterCount(1);

for ($i = 1; $i < $step; $i++) {
    $relatedTestId = DB::scalar('SELECT '.(Test::INDEX.' FROM '.Test::TABLE.' WHERE '.Test::SECTION_INDEX.' = ? AND step = ?').' LIMIT 1', (array) ([$legacyTest->sectionId, $i])) ?? false;
    $relatedTest = new Test($relatedTestId);

    if ($relatedTest->completed) {
        $resultEmotions[] = $relatedTest->rawResults[0];
        $resultIntensities[] = $relatedTest->rawResults[1];
    }
}
