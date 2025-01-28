<?php

$legacyTest = test();
$sibling = $legacyTest->requiredTest;

$titles = ['Pochissimo', 'Poco', 'Abbastanza', 'Molto', 'Moltissimo'];

bump($titles);

$score = round($sibling->percentage / 25) + 1;

// reset test
if (isset($_POST['reset'])) {
	$sibling->reset();
}
