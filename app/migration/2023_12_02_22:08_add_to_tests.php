<?php

use app\Models\Activities\Test;

$sectionId = 54;
$step = 5;

if (!Test::newFromStep($sectionId, $step)) {
	$base = Test::newFromStep(53, 5);

	Test::newEmpty()
		->prepare('sectionId', $sectionId)
		->prepare('areaId', $base->areaId())
		->prepare('title', "Le cause e le conseguenze")
		->prepare('description', "Completa lo schema di relazione riportando nei riquadri vuoti le informazioni elencate sotto.")
		->prepare('shortDescription', "Completa lo schema")
		->prepare('slug', $base->slug())
		->prepare('step', $step)
		->prepare('template', $base->template())
		->prepare('reviewResult', $base->reviewResult())
		->up();
}
