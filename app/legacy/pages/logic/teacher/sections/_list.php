<?php

use Illuminate\Support\Facades\DB;

// theme
$this->styles->add(SERVER_ROOT.'/pages/styles/teacher/teacher.css');
$this->scripts->add(SERVER_ROOT.'/pages/scripts/teacher/teacher.js');

// get user

// fetch areas and sections
$areas = [];

$res = array_map(static fn ($row) => (array) $row, DB::select('SELECT '.('id, name FROM areas WHERE id<4 ORDER BY id ASC'), (array) ([])));

while ($row = array_shift($res)) {

    $legacySections = array_map(static fn ($row) => (array) $row, DB::select('SELECT '.('* FROM sections WHERE active=1 AND locked=0 AND area = ? ORDER BY id ASC'), (array) ([$row['id']])));

    $area['name'] = $row['name'];
    $area['sections'] = $legacySections;

    $areas[] = $area;
}

// store variables
$this->set('areas', $areas);
