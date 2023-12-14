<?php

namespace Activity\Result\Graphs;

use Activity\Result\Handler\SchoolClassSectionResult;

class SectionGraph {

	public static function generate(int $sectionId, int $schoolClassId = null) {
		$type = section_config($sectionId, 'type');
		$condensedType = section_config($sectionId, 'condensedType');
		$schoolClassResults = (new SchoolClassSectionResult($sectionId, $schoolClassId))->rawResult;
		$schoolClassAverages = $schoolClassResults['values'];

		// if ($sectionId == 7) {
		// 	debug($schoolClassResults);
		// }

		if (!empty($schoolClassAverages)) {
			$graphData = [
				'labels' => [],
				'data' => [],
				'condensed' => array_keys($schoolClassAverages, max($schoolClassAverages))[0],
			];

			// Generate the results
			foreach ($schoolClassAverages as $resultName => $resultValue) {

				if ($type == 'tiers') {
					$resultValue = round($resultValue / array_sum($schoolClassAverages) * 100);
				} else {
					$resultValue = $schoolClassAverages[$resultName];
				}

				$graphData['labels'][] = $resultName;
				$graphData['data'][] = $resultValue;
			}

			// Generate the condensed value
			if ($condensedType == 'max') {
				$graphData['condensed'] = array_keys($schoolClassAverages, max($schoolClassAverages))[0];
			} else if ($condensedType == 'average') {
				$graphData['condensed'] = percent(array_sum($graphData['data']), count($graphData['data']) * 100) . '%';
			}

			return $graphData;
		}

		return false;
	}
}
