<?php

namespace Section;

use \DB;

class Results {

	// parse the numeric result to a string
	/*static function resultByValue($sectionId, $value) {
		$result = false;

		if ($value) {
			switch ($sectionId) {
				case 3:
					// resilienza
					$names = ['Pochissimo', 'Poco', 'Abbastanza', 'Molto', 'Moltissimo'];
					$score = round($value / 25);
					$result = $names[$score] . ' (' . $value . '%)';
					break;
				default:
					$result = $value . '%';
			}
		}

		return $result;
	}

	// calculate the average results of a section of a class or of all the students
	static function getGeneralResults($sectionId, $classId = false) {
		switch ($sectionId) {
			case 3:
				// resilienza
				$testIds = [49];
				$result = self::getGeneralAverageResult($sectionId, $testIds, $classId);
				break;
			case 4:
				// autostima
				$testIds = [7, 8, 9, 10, 11, 12];
				$result = self::getGeneralAverageResult($sectionId, $testIds, $classId);
				break;
			default:
				$result = false;
		}

		return $result;
	}

	// calculate specific sections
	static private function getGeneralAverageResult($sectionId, $testIds, $classId) {

		$testIdsStr = "'" . implode("','", $testIds) . "'";

		if ($classId) {
			$resultIds = DB::select("DISTINCT id, testID, userID FROM ' . TestResult::TABLE . ' WHERE testID IN (" . $testIdsStr . ") AND userID IN (SELECT userId FROM students WHERE classId=?)", [$classId])->res;
			$resultIds = array_column($resultIds, 'id');
			$count = count($resultIds);
			$resultIdsStr = "'" . implode("','", $resultIds) . "'";
			$tot = DB::sum("percentage FROM ' . TestResult::TABLE . ' WHERE id IN (" . $resultIdsStr . ")");
		} else {
			$tot = DB::sum("percentage FROM results_permanent WHERE testID IN (" . $testIdsStr . ")");
			$count = DB::count("results_permanent WHERE testID IN (" . $testIdsStr . ")");
		}

		$result = round($tot / $count);

		return $result;
	}*/
}
