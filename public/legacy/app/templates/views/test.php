<?php

use LogicManager\TestLogic;

?>

{% extends main %}

{% block main %}

<form class="test__body" method="POST" data-style="<?= get_grade_style() ?>" data-test-id="<?= testId() ?>" data-completed="<?= test()->completed ? 'true' : 'false' ?>">
	<input type="hidden" class="js-count" name="result_count" value="<?= ($resultCount ?? (TestLogic::$parameterCount ?? 0)) ?>" data-count="<?= ($resultCount ?? (TestLogic::$parameterCount ?? 0)) ?>">
	<input type="hidden" class="js-time-passed" name="speed" value="0">

	{% place content %}

</form>

{% end main %}