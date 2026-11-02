<?php

use Illuminate\Support\Facades\DB;
use Legacy\UserSystem\Student;

$students = array_map(static fn ($row) => (array) $row, DB::select('SELECT '.('
		students.id FROM students
		INNER JOIN users ON students.userId = users.id
		WHERE '.Student::SCHOOL_CLASS_INDEX.' = ? AND users.status=1
		ORDER BY last_name ASC, first_name ASC, id ASC'), (array) ([schoolClassId()])));

// fetch choices
$choices = [];
$choicesRes = array_map(static fn ($row) => (array) $row, DB::select('SELECT '.('id, advice FROM advices_list ORDER BY id ASC'), (array) ([])));

while ($choice = array_shift($choicesRes)) {
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
