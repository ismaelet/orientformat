<?php
/*
use Activity\Result\Handler\SchoolClassSectionResult;

function generate_graph_data($sectionId,) {
	$type = section_config($sectionId, 'type');
	$schoolClassResults = (new SchoolClassSectionResult($sectionId, schoolClassId()))->rawResult;
	$schoolClassAverages = $schoolClassResults['values'];

	$graphData = [
		'labels' => [],
		'data' => [],
	];

	foreach ($schoolClassAverages as $resultName => $resultValue) {

		if ($type == 'tiers') {
			$resultValue = round($resultValue / array_sum($schoolClassAverages) * 100);
		} else {
			$resultValue = $schoolClassAverages[$resultName];
		}

		$graphData['labels'][] = $resultName;
		$graphData['data'][] = $resultValue;
	}

	return $graphData;
}
*/