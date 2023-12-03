<?php

use app\Models\Activities\Test;

if (!Test::hasColumn('completeSection')) {
	Test::addColumns(
		[
			['completeSection TINYINT(1) DEFAULT 0'],
		]
	);
}

(new Test(92))->prepare('completeSection', true)->post();
(new Test(151))->prepare('completeSection', true)->post();

DB::delete('results_sections_condensed');
