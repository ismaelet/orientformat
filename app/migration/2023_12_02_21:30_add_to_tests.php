<?php

use app\Models\Activities\Test;

$sectionId = 56;
$step = 4;

if (!Test::newFromStep($sectionId, $step)) {
	$base = Test::newFromStep(53, 5);

	Test::newEmpty()
		->prepare('sectionId', $sectionId)
		->prepare('areaId', $base->areaId())
		->prepare('title', $base->title())
		->prepare('description', $base->description())
		->prepare('shortDescription', $base->shortDescription())
		->prepare('slug', $base->slug())
		->prepare('step', $step)
		->prepare('template', $base->template())
		->prepare('reviewResult', $base->reviewResult())
		->up();
}
