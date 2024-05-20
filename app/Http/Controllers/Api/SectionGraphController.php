<?php

namespace App\Http\Controllers\Api;

use \Legacy\Activity\Result\Handler\SchoolClassSectionResult;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SectionGraphController extends Controller {

	/**
	 * Get the current section record
	 */
	public function show(Request $request, int $id): JsonResponse {

		if ($request->school_class_id) {
			$results = (new SchoolClassSectionResult($id, $request->school_class_id))->rawResult;
		} else {
			$resultsModel = (new SchoolClassSectionResult($id));
			$results = $resultsModel->rawResult;
		}

		$averages = $results['values'] ?? null;
		$type = section_config($id, 'type');
		$condensedType = section_config($id, 'condensedType');

		if (empty($averages)) {
			return response()->json(['error' => 'No results found for this section.'], 404);
		}

		$graphData = [
			'labels' => [],
			'data' => [],
			'condensed' => array_keys($averages, max($averages))[0],
		];

		// Generate the school class results
		foreach ($averages as $resultName => $resultValue) {

			if ($type == 'tiers') {
				$resultValue = round($resultValue / array_sum($averages) * 100);
			} else {
				$resultValue = $averages[$resultName];
			}

			$graphData['labels'][] = $resultName;
			$graphData['data'][] = $resultValue;
		}

		// Generate the condensed value
		if ($condensedType == 'max') {
			$graphData['condensed'] = array_keys($averages, max($averages))[0];
		} else if ($condensedType == 'average') {
			$graphData['condensed'] = percent(array_sum($graphData['data']), count($graphData['data']) * 100) . '%';
		}

		return response()->json($graphData);
	}
}
