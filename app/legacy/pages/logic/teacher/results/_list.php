<?php

use App\Legacy\LegacyDB;

// theme
$this->styles->add(SERVER_ROOT.'/pages/styles/teacher/teacher.css');
$this->scripts->add(SERVER_ROOT.'/pages/scripts/teacher/teacher.js');

// fetch class
$grade = LegacyDB::find('class FROM users WHERE id = ?', [$user->id]);

// fetch data
$students = LegacyDB::select('*, CONCAT(last_name," ",first_name) as name FROM users WHERE class = ? AND level=0 AND status=1 ORDER BY last_name ASC, first_name ASC, id ASC', [$grade]);

$res = LegacyDB::select('id, advice FROM advices_list ORDER BY id ASC');

while ($choice = $res->fetch_assoc()) {
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
        LegacyDB::delete('advices WHERE userID = ?', $_POST['id']);
    } elseif (LegacyDB::exists('advices WHERE userID = ?', $_POST['id'])) {
        LegacyDB::update('advices SET advices = ? WHERE userID = ?', [$advices, $_POST['id']]);
    } else {
        LegacyDB::add('advices (userID, advices) VALUES (?, ?)', [$_POST['id'], $advices]);
    }
}
