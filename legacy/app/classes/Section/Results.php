<?php

namespace Section;

use \DB;

class Results {

	// parse the numeric result to a string
	/*static function resultByValue($legacySectionId, $value) {
		$result = false;

		if ($value) {
			switch ($legacySectionId) {
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
	static function getGeneralResults($legacySectionId, $classId = false) {
		switch ($legacySectionId) {
			case 3:
				// resilienza
				$testIds = [49];
				$result = self::getGeneralAverageResult($legacySectionId, $testIds, $classId);
				break;
			case 4:
				// autostima
				$testIds = [7, 8, 9, 10, 11, 12];
				$result = self::getGeneralAverageResult($legacySectionId, $testIds, $classId);
				break;
			default:
				$result = false;
		}

		return $result;
	}

	// calculate specific sections
	static private function getGeneralAverageResult($legacySectionId, $testIds, $classId) {

		$testIdsStr = "'" . implode("','", $testIds) . "'";

		if ($classId) {
			$resultIds = \Legacy\System\Classes\LegacyDB::select("DISTINCT id, testID, userID FROM ' . TestResult::TABLE . ' WHERE testID IN (" . $testIdsStr . ") AND userID IN (SELECT userId FROM students WHERE classId=?)", [$classId])->res;
			$resultIds = array_column($resultIds, 'id');
			$count = count($resultIds);
			$resultIdsStr = "'" . implode("','", $resultIds) . "'";
			$tot = \Legacy\System\Classes\LegacyDB::sum("percentage FROM ' . TestResult::TABLE . ' WHERE id IN (" . $resultIdsStr . ")");
		} else {
			$tot = \Legacy\System\Classes\LegacyDB::sum("percentage FROM results_permanent WHERE testID IN (" . $testIdsStr . ")");
			$count = \Legacy\System\Classes\LegacyDB::count("results_permanent WHERE testID IN (" . $testIdsStr . ")");
		}

		$result = round($tot / $count);

		return $result;
	}*/
}
