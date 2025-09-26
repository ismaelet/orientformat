<?php

$count = 9;

if (!isset($graphData)) {
	for ($i = 1; $i <= $count; $i++) {
		$translationId = legacy_test()->id == 162 ? 162 : 119;

		$graphData[] = [
			'name' => __('tests.' . $translationId . '-name-' . $i),
			'description' => __('tests.' . $translationId . '-description-' . $i)
		];
	}
}

$legacyTest = legacy_test();

\Legacy\LogicManager\TestLogic::setParameterCount($count);
