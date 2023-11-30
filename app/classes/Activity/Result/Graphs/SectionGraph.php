<?php

namespace Activity\Result\Graphs;

use Activity\Result\Handler\SchoolClassSectionResult;

class SectionGraph {

	public static function generate(int $sectionId, int $schoolClassId = null) {
		$type = section_config($sectionId, 'type');
		$schoolClassResults = (new SchoolClassSectionResult($sectionId, $schoolClassId))->rawResult;
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
}
