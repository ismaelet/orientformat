<?php

use App\Helpers\Tests\RuotaHelper;
use \Legacy\Activity\Test;

\App\Legacy\StyleLoader::add('profile/ruota/ruota', 'page');
\App\Legacy\ScriptLoader::add('profile/ruota/ruota', 'page');

$legacyTest = test();
$result = $legacyTest->completed ? $legacyTest->rawResults : null;
$resultEmotion = $result ? $result[0] : null;
$resultIntensity = $result ? $result[1] : null;
$resultEmotions = [];
$resultIntensities = [];
$stepNames = ['prima', 'seconda', 'terza'];

$emotionCount = count($emotions);

\Legacy\LogicManager\TestLogic::setParameterCount(1);

$results = RuotaHelper::selectedEmotions(request()->test, legacy_watched_student());
