<?php

use App\Legacy\LegacyDB;
use Legacy\UserSystem\Student;

$students = LegacyDB::select('
		students.id FROM students
		INNER JOIN users ON students.userId = users.id
		WHERE '.Student::SCHOOL_CLASS_INDEX.' = ? AND users.status=1
		ORDER BY last_name ASC, first_name ASC, id ASC', [schoolClassId()]);

// fetch choices
$choices = [];
$choicesRes = LegacyDB::select('id, advice FROM advices_list ORDER BY id ASC');

while ($choice = $choicesRes->fetch_assoc()) {
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
