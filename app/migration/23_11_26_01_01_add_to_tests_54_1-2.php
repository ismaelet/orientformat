<?php

use app\Models\Activities\Section;
use app\Models\Activities\Test;

DB::update(Test::table() . ' SET step = step + 2 WHERE sectionId = 54');

if (!Test::newFromStep(54, 1)) {
	$surveryId = Test::duplicateEntry(97, [
		Test::linkedIndexName(Section::class) => 54,
	]);
}

if (!Test::newFromStep(54, 2)) {
	$recapId = Test::duplicateEntry(98, [
		Test::linkedIndexName(Section::class) => 54,
		'requiredTestId' => $surveryId
	]);
}

(new Test($surveryId))->post([
	'followUpTestId' => $recapId
]);
