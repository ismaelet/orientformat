<?php

use LogicManager\TestLogic;

\Legacy\System\Classes\StyleLoader::add('profile/temperamento/temperamento', 'page');
\Legacy\System\Classes\ScriptLoader::add('profile/temperamento/temperamento', 'page');

$test = test();

$count = count($questions);

bump($questions);

Test\Legacy\System\Classes\Logic::setParameterCount($count)
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
