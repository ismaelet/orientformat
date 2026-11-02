<?php

use App\Helpers\Tests\RuotaHelper;
use App\Legacy\ScriptLoader;
use App\Legacy\StyleLoader;
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

$emotionCount = count($emotions);

TestLogic::setParameterCount(1);

$results = RuotaHelper::selectedEmotions(request()->test, legacy_watched_student());
