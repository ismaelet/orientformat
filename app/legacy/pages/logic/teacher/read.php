<?php

/* OLD
//theme
$this->styles->add(SERVER_ROOT . '/pages/styles/teacher/teacher.css');
$this->scripts->add(SERVER_ROOT . '/pages/scripts/teacher/teacher.js');

//get user


//fetch areas and sections
$areas = [];

$res = \App\Legacy\LegacyDB::select('id, name FROM areas ORDER BY id ASC');

while ($row = $res->fetch_assoc()) {

    $legacySections = \App\Legacy\LegacyDB::select('* FROM sections WHERE active=1 AND locked=0 AND area<4 AND area = ? ORDER BY id ASC', [$row['id']]);

    $area['name'] = $row['name'];
    $area['sections'] = $legacySections;

    $areas[] = $area;
}

$areas[3]['area'] = 4;
*/
