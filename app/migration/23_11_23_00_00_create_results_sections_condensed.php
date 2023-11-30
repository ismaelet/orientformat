<?php

use app\Models\Activities\Results\CondensedSectionResult;

CondensedSectionResult::dropTable();

CondensedSectionResult::createTable(
	[
		'id INT(11) AUTO_INCREMENT PRIMARY KEY',
		'student_id INT(11)',
		'section_id INT(11)',
		'result VARCHAR(255) NULL',
		'speed INT(11) DEFAULT 0',
	]
);
