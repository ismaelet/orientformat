<?php

use app\Models\Activities\Test;

(new Test(191))->post(
	[
		'slug' => 'punto-di-vista'
	]
);
