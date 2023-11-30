<?php

use app\Models\Activities\Test;

(new Test(175))->post([
	'active' => 0
]);

(new Test(176))->post([
	'template' => 'test-next'
]);
