<?php

use app\Models\User\StudentProfile;

StudentProfile::createTable(
	[
		'student_id INT(11) PRIMARY KEY',
		'primary_choice_area VARCHAR(255) NULL',
		'primary_choice_specific VARCHAR(255) NULL',
		'primary_choice_intensity VARCHAR(255) NULL',
	]
);
