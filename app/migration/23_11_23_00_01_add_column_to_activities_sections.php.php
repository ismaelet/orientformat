<?php

use app\Models\Activities\Section;

Section::hasColumn('grades');
Section::addColumns(
	[
		['grades VARCHAR(255) NULL', 'locked'],
	]
);

Section::transferColumnData('years', 'grades');

Section::updateAllInSet('6L', 6, 'grades');
Section::updateAllInSet('7L', 7, 'grades');
Section::updateAllInSet('8L', 8, 'grades');
Section::updateAllInSet('6P', 9, 'grades');
Section::updateAllInSet('7P', 10, 'grades');
