<?php

use \Legacy\UserSystem\Student;

$parseAnswer = [
	'Lo escludo' => 'Lo esclude',
	'Lo sto valutando' => 'Lo sta valutando',
	'Ne sono quasi sicuro/a' => 'Ne è quasi sicuro/a',
	'Ne sono sicuro/a' => 'Ne è sicuro/a',
];

$parseIcons = [
	0 => 'close-thick',
	1 => 'close-thick',
	2 => 'average',
	3 => 'correct',
];

// fetch students
$students = \System\Classes\DBOld::select('id FROM students INNER JOIN users on students.userId = users.id WHERE ' . Student::SCHOOL_CLASS_INDEX . ' = ? AND users.status = 1 AND id IN (SELECT userID FROM advices) ORDER BY lastName ASC, firstName ASC, id ASC', schoolClassId());

// fetch choices
$choices = [];
$choicesRes = \System\Classes\DBOld::select('id, advice FROM advices_list ORDER BY id ASC');

while ($choice = $choicesRes->fetch_assoc()) {
	$choices[$choice['id']] = $choice['advice'];
}

function _compare_advice($student, $advice) {
	$result = 0;

	$parseAnswer = [
		'Lo escludo' => 1,
		'Lo sto valutando' => 2,
		'Ne sono quasi sicuro/a' => 3,
		'Ne sono sicuro/a' => 4,
	];

	foreach ($student->choices as $choiceArea => $choice) {
		if ($advice->category->name == $choiceArea) {
			$choiceVal = $parseAnswer[trim($choice)];

			if ($choiceVal > 1) {
				if ($advice->generic || !isset($student->specificChoices[$advice->category->name]) || isset($student->combinedChoices[$advice->name])) $result = 3;
				else $result = 2;
			} else {
				$result = 1;
			}

			break;
		}
	}

	return $result;
}
