<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

$count = 13;

\Legacy\LogicManager\TestLogic::setParameterCount($count)
	->setTestSubmitFunction(
		function () {
			$correctN = 0;

			try {
				foreach ($_POST['field'] as $key => $_looping) {
					if (eval_num($_POST['field'], $key)) $correctN++;
				}
			} catch (\Exception $e) {
				Log::error('Post results not set in "Racconto"', ['userId' => Auth::id(), 'request' => request()->all()]);
			}

			return round($correctN / \Legacy\LogicManager\TestLogic::$parameterCount * 100, 0);
		}
	);

function eval_num($numbers, $key) {
	if ($key) {
		$valid = true;
		$num = (int) $numbers[$key];
		$sibling = $key < 7 ? (int) $numbers[$key + 6] : (int) $numbers[$key - 6];
		$center = (int) $numbers[0];

		if ($num + $center + $sibling != 22) $valid = false;

		foreach ($numbers as $i => $val) if ($i != $key && $val == $num) $valid = false;

		return $valid;
	} else {
		if ($numbers[0] < 10) return true;
		else return false;
	}
}
