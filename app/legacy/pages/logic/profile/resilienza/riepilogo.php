<?php

$legacyTest = legacy_test();
$sibling = $legacyTest->requiredTest;

$titles = [__('Very little'), __('A little'), __('Fairly'), __('Very'), __('Extremely')];

bump($titles);

$score = round($sibling->percentage / 25) + 1;

// reset test
if (isset($_POST['reset'])) {
	$sibling->reset();
}
