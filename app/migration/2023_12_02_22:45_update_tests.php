<?php

use app\Models\Activities\Test;

(Test::newFromStep(54, 3))
	->prepare('title', 'Analizza il testo: Eveline - 1')
	->post();

(Test::newFromStep(54, 4))
	->prepare('title', 'Analizza il testo: Eveline - 2')
	->post();
