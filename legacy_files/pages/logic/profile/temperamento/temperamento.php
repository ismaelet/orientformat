<?php

use LogicManager\TestLogic;

StyleLoader::add('profile/temperamento/temperamento', 'page');
ScriptLoader::add('profile/temperamento/temperamento', 'page');

$test = test();

$count = count($questions);

bump($questions);

TestLogic::setParameterCount($count)
	->setTestSubmitFunction(
		function ($count) {
			$max = $count * 6;
			$score = 0;

			foreach ($_POST['field'] as $value) {
				$score += $value;
			}

			return round($score / $max * 100);
		}
	);
