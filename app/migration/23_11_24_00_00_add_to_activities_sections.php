<?php

use app\Models\Activities\Area;
use app\Models\Activities\Section;

(new Section(15))->post(
	[
		'grades' => '5',
		'years' => '5',
	],
);

Section::add(
	[
		Section::linkedIndexName(Area::class) => 2,
		'name' => 'Imparare',
		'slug' => 'imparare-avanzato',
		'description' => 'Capire come si impara',
		'grades' => '7,10',
		'years' => '7L,7P',
		'mainSectionId' => 15,
	]
);
