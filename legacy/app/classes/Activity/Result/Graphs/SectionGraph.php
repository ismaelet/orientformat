<?php

namespace Legacy\Activity\Result\Graphs;

use \Legacy\Activity\Result\Handler\SchoolClassSectionResult;

class SectionGraph {

	public static function generate(int $legacySectionId, int $schoolClassId = null) {
		$type = section_config($legacySectionId, 'type');
		$condensedType = section_config($legacySectionId, 'condensedType');
		$schoolClassResults = (new SchoolClassSectionResult($legacySectionId, $schoolClassId))->rawResult;
		$platformResults = (new SchoolClassSectionResult($legacySectionId))->rawResult;
		$schoolClassAverages = $schoolClassResults['values'];
		$platformAverages = $platformResults['values'];

		if (!empty($schoolClassAverages)) {
			$graphData = [
				'labels' => [],
				'data' => [
					'school_class' => [],
					'platform' => [],
				],
				'condensed' => array_keys($schoolClassAverages, max($schoolClassAverages))[0],
			];

			// Generate the school class results
			foreach ($schoolClassAverages as $resultName => $resultValue) {

				if ($type == 'tiers') {
					$resultValue = round($resultValue / array_sum($schoolClassAverages) * 100);
				} else {
					$resultValue = $schoolClassAverages[$resultName];
				}

				$graphData['labels'][] = $resultName;
				$graphData['data']['school_class'][] = $resultValue;
			}

			// Generate the platform results
			foreach ($platformAverages as $resultName => $resultValue) {

				if ($type == 'tiers') {
					$resultValue = round($resultValue / array_sum($platformAverages) * 100);
				} else {
					$resultValue = $platformAverages[$resultName];
				}

				$graphData['data']['platform'][] = $resultValue;
			}

			// Generate the condensed value
			if ($condensedType == 'max') {
				$graphData['condensed'] = array_keys($schoolClassAverages, max($schoolClassAverages))[0];
			} else if ($condensedType == 'average') {
				$graphData['condensed'] = percent(array_sum($graphData['data']['school_class']), count($graphData['data']['school_class']) * 100) . '%';
			}

			return $graphData;
		}

		return false;
	}
}
