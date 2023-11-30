<?php

use app\Models\Activities\Grade;

Grade::dropTable();

Grade::createTable(
	[
		'id INT(11) AUTO_INCREMENT PRIMARY KEY',
		'absolute_number INT(2) NULL',
		'school_relative_number INT(2) NULL',
		'is_highschool TINYINT(1) DEFAULT 0',
		'is_professional TINYINT(1) DEFAULT 0',
	]
);

for ($i = 1; $i <= 3; $i++) {
	Grade::add([
		'absolute_number' => $i,
		'school_relative_number' => $i,
	]);
}

for ($i = 4; $i <= 8; $i++) {
	Grade::add([
		'absolute_number' => $i,
		'school_relative_number' => $i - 3,
		'is_highschool' => 1,
	]);
}

for ($i = 6; $i <= 7; $i++) {
	Grade::add([
		'absolute_number' => $i,
		'school_relative_number' => $i - 3,
		'is_highschool' => 1,
		'is_professional' => 1,
	]);
}
