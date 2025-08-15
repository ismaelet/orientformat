<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

$solution = $solution ?? [4, 5, 8, 1];
$answers = $answers ?? [1, 2, 3, 4, 5, 6, 7, 8];
$count = count($solution);

\Legacy\LogicManager\TestLogic::setParameterCount($count)
	->setTestSubmitFunction(function () use ($solution) {
		try {
			foreach ($_POST['field'] as $key => $answer) {
				if (strtolower($answer) != strtolower($solution[$key])) {
					return 0;
				}
			}
		} catch (\Exception $e) {
			Log::error('Post results not set in "Sagome"', ['userId' => Auth::id(), 'request' => request()->all()]);
		}

		return 100;
	});
