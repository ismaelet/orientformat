<?php

use \Legacy\UserSystem\Student;

$students = \System\Classes\DBOld::select('
		students.id FROM students
		INNER JOIN users ON students.userId = users.id
		WHERE ' . Student::SCHOOL_CLASS_INDEX . ' = ? AND users.status=1
		ORDER BY lastName ASC, firstName ASC, id ASC', [schoolClassId()]);

// fetch choices
$choices = [];
$choicesRes = \System\Classes\DBOld::select('id, advice FROM advices_list ORDER BY id ASC');

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
		\System\Classes\DBOld::delete('advices WHERE userID = ?', $_POST['id']);
	} else if (\System\Classes\DBOld::exists('advices WHERE userID = ?', $_POST['id'])) {
		\System\Classes\DBOld::update('advices SET advices = ? WHERE userID = ?', [$advices, $_POST['id']]);
	} else {
		\System\Classes\DBOld::add('advices (userID, advices) VALUES (?, ?)', [$_POST['id'], $advices]);
	}
}
