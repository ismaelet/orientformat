<?php

use Illuminate\Support\Facades\DB;

// theme
$this->styles->add(SERVER_ROOT.'/pages/styles/teacher/teacher.css');
$this->scripts->add(SERVER_ROOT.'/pages/scripts/teacher/teacher.js');

// get user

// fetch class
$grade = DB::scalar('SELECT '.('class FROM users WHERE id = ?').' LIMIT 1', (array) ([$user->id])) ?? false;

// fetch students
$students = array_map(static fn ($row) => (array) $row, DB::select('SELECT '.('* FROM users WHERE class = ? AND status=1 AND level=0 ORDER BY last_name ASC, first_name ASC, id ASC'), (array) ([$grade])));

// store variables
$this->set('students', $students);
