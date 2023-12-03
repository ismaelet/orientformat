<?php

use app\Models\Activities\Test;

(Test::newFromStep(53, 5))
	->prepare('active', 1)
	->prepare('template', 'test-next')
	->post();
