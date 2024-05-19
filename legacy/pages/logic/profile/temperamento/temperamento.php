<?php

use LogicManager\TestLogic;

\App\Legacy\StyleLoader::add('profile/temperamento/temperamento', 'page');
\App\Legacy\ScriptLoader::add('profile/temperamento/temperamento', 'page');

$legacyTest = test();

$count = count($questions);

bump($questions);

\LogicManager\TestLogic::setParameterCount($count)
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
