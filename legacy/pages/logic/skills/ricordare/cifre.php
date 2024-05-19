<?php

use \Legacy\Activity\Result\TestResult;
use LogicManager\TestLogic;

$test = test();
$right = true;
$count = 8;

$levelOld = $test->rawResults[0] ?? 0;

$answers = [
	[9, 2, 4],
	[5, 0, 3, 1],
	[4, 8, 7, 9, 1],
	[2, 6, 3, 0, 9, 5],
	[1, 7, 4, 2, 9, 0, 2],
	[2, 6, 3, 9, 0, 5, 4, 7],
	[2, 9, 5, 7, 3, 4, 8, 1, 6],
	[0, 5, 3, 1, 7, 9, 2, 4, 7, 3],
];

bump($answers);

// calculate if the last test was right
if ($test->rawResults) {
	foreach ($test->rawResults as $key => $value) {
		if ($key) {
			if ($test->rawResults[$key] != $answers[$levelOld][$key - 1]) {
				$right = false;
			}
		}
	}
}

$level = $right ? $levelOld + 1 : $levelOld;

// view section
$view_text = [];

if ($level <= $count) {
	foreach ($answers[$level] as $answer) {
		$view_text[] = $answer;
	}
}

$view_text = implode(' <span class="dot">&middot;</span> ', $view_text);

// process result
if (isset($_POST['check'])) {
	$result = [];

	// clear previous results
	\Legacy\System\Classes\LegacyDB::delete(TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' = ? AND ' . TestResult::TEST_INDEX . ' = ?', [studentId(), $test->id,]);

	// save result
	if (isset($_POST['field'])) {
		foreach ($_POST['field'] as $value) {
			$result[] = $value;
		}
	}

	\Legacy\System\Classes\LegacyDB::add(
		TestResult::TABLE . ' (' . TestResult::USER_INDEX . ', ' . TestResult::TEST_INDEX . ', result, percentage)',
		[studentId(), $test->id, implode(',', $result), ($level - 1) * 10]
	);

	redirect_old();
}

Test\Legacy\System\Classes\Logic::setTestSubmitFunction(
	function () {
		$maxLevel = count(\Legacy\System\Classes\LegacyView::get('answers'));
		$level = $_POST['field'][0];
		$level = empty($_POST['skip-cbx']) ? $level : $level - 1;
		$level = $level > $maxLevel ? $maxLevel : $level;

		return percent($level, $maxLevel);
	}
);
