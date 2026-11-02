<?php

use Illuminate\Support\Facades\DB;

// theme
$this->styles->add(SERVER_ROOT.'/pages/styles/teacher/teacher.css');
$this->scripts->add(SERVER_ROOT.'/pages/scripts/teacher/teacher.js');

// fetch class
$grade = DB::scalar('SELECT '.('class FROM users WHERE id = ?').' LIMIT 1', (array) ([$user->id])) ?? false;

// fetch data
$students = array_map(static fn ($row) => (array) $row, DB::select('SELECT '.('*, CONCAT(last_name," ",first_name) as name FROM users WHERE class = ? AND level=0 AND status=1 ORDER BY last_name ASC, first_name ASC, id ASC'), (array) ([$grade])));

$res = array_map(static fn ($row) => (array) $row, DB::select('SELECT '.('id, advice FROM advices_list ORDER BY id ASC'), (array) ([])));

while ($choice = array_shift($res)) {
    $choices[$choice['id']] = $choice['advice'];
}

// add advice
if (isset($_POST['add-advice'])) {

    $advices = [];

    foreach ($_POST['advice'] as $advice) {
        if ($advice) {
            $advices[] = $advice;
        }
    }

    $advices = implode(',', $advices);

    if (empty($advices)) {
        DB::delete('DELETE FROM '.('advices WHERE userID = ?'), (array) ($_POST['id']));
    } elseif (DB::selectOne('SELECT 1 FROM '.('advices WHERE userID = ?').' LIMIT 1', (array) ($_POST['id'])) !== null) {
        DB::update('UPDATE '.('advices SET advices = ? WHERE userID = ?'), (array) ([$advices, $_POST['id']]));
    } else {
        DB::insert('INSERT INTO '.('advices (userID, advices) VALUES (?, ?)'), (array) ([$_POST['id'], $advices]));
    }
}
