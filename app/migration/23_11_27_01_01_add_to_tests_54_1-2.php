<?php

use app\Models\Activities\Section;
use app\Models\Activities\Test;

DB::update(Test::table() . ' SET step = step + 2 WHERE sectionId = 53');

if (!Test::newFromStep(53, 1)) {
	$surveryId = Test::duplicateEntry(97, [
		Test::linkedIndexName(Section::class) => 53,
	]);
}

if (!Test::newFromStep(53, 2)) {
	$recapId = Test::duplicateEntry(98, [
		Test::linkedIndexName(Section::class) => 53,
		'requiredTestId' => $surveryId
	]);
}

(new Test($surveryId))->post([
	'followUpTestId' => $recapId
]);
