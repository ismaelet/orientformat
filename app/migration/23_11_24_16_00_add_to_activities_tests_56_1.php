<?php

use app\Models\Activities\Section;
use app\Models\Activities\Test;

if (!Test::newFromStep(56, 1)) {
	Test::duplicateEntry(35, [
		Test::linkedIndexName(Section::class) => 56,
	]);
}
