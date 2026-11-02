<?php

use API\StudentRequest;
use App\Legacy\LegacyDB;

// theme
$this->styles->add(SERVER_ROOT.'/pages/styles/teacher/teacher.css');
$this->scripts->add(SERVER_ROOT.'/pages/scripts/teacher/teacher.js');

// get user

// fetch class
$grade = LegacyDB::find('class FROM users WHERE id = ?', [$user->id]);

/* TEMPORARY */
$res_temp = LegacyDB::select('id FROM users WHERE level=0 AND class = ?', [$grade]);

while ($row = $res_temp->fetch_assoc()) {
    StudentRequest::progress_areas($row['id']);
}

/***/

// fetch students
$students = LegacyDB::select('* FROM users WHERE class = ? AND status=1 AND level=0 ORDER BY last_name ASC, first_name ASC, id ASC', [$grade]);

// store variables
$this->set('students', $students);
