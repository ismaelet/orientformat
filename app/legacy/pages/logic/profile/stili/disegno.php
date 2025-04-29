<?php

//$this->add_element('tilt');

$methods = [];

for ($i = 1; $i <= 4; $i++) {
	$methods[] = [
		__('tests.32-title-' . $i),
		[
			__('tests.32-info-' . $i . '-1'),
			__('tests.32-info-' . $i . '-2')
		]
	];
}
