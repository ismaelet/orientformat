<?php

$legacyTest = test();
$title = $title ?? __('Cognitive styles');

$sortedResults = [];
$unsoredResults = $legacyTest->detailedResult;
$resultOrder = $resultOrder ?? [1, 3, 5, 7, 2, 4, 6, 8];
$categories = test_config($legacyTest->id, 'groups');


if ($unsoredResults) {
	foreach ($resultOrder as $resultId) {
		$result = $unsoredResults[$resultId];
		$result['value'] = max(round($result['value']  / $result['max'] * 4), 1);
		$result['info'] = $categories[$resultId]['info'];
		$sortedResults[] = $result;
	}
}
