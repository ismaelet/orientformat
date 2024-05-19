<?php

//theme
$this->styles->add(SERVER_ROOT . '/pages/styles/teacher/teacher.css');
$this->scripts->add(SERVER_ROOT . '/pages/scripts/teacher/teacher.js');

//get variables
$id = $_GET['id'] ?? false;


//fetch class
$grade = \Legacy\System\Classes\LegacyDB::find('class FROM users WHERE id = ?', [$user->id]);

//fetch section
$section = \Legacy\System\Classes\LegacyDB::row('* FROM sections WHERE id = ?', [$id]);

if (!$section) redirect_old('/teacher/sections');

//fetch tests
$tests = [];
$res = \Legacy\System\Classes\LegacyDB::select('* FROM ' . Test::TABLE . ' WHERE sectionId = ? AND active=1 AND template<>? AND (static=0 OR shared=1) ORDER BY step ASC', [$section['id'], 'recap']);

while ($row = $res->fetch_assoc()) $tests[] = $row;

//fetch studens
$students = \Legacy\System\Classes\LegacyDB::select('id FROM users WHERE class = ? AND status=1 AND level=0', [$grade]);

//fetch results
$results = [];

while ($studentRow = $students->fetch_assoc()) {

	$result = [];

	$student = new \Legacy\UserSystem\Student($studentRow['id']);

	$result['studentId'] = studentId();
	$result['values'][0] = $student->lastname . ' ' . $student->firstname;

	foreach ($tests as $test) {

		$row = \Legacy\System\Classes\LegacyDB::row('completed, percentage FROM ' . TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' = ? AND ' . TestResult::TEST_INDEX . ' = ?', [studentId(), $test['id']]);

		if ($test['static'] && \Legacy\System\Classes\LegacyDB::exists(TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' = ? AND ' . TestResult::TEST_INDEX . ' IN (SELECT id FROM ' . Test::TABLE . ' WHERE sectionId = ? AND step = ?)', [studentId(), $test['sectionID'], $test['step'] - 1])) $row['completed'] = true;

		if ($row && $row['completed']) {

			if ($test['type'] != 2 && ($test['template'] == 'survey' || $test['type'] == 3))
				$text = 'completato con<br>autovalutazione <span class="txt-c5 fw-bold">' . $row['percentage'] . '%</span>';

			else if ($test['type'] == 1)
				$text = 'completato con<br>risultato <span class="txt-c5 fw-bold">' . $row['percentage'] . '%</span>';

			else
				$text = '<span class="txt-sbold">completato</span>';

			if ($test['shared']) {

				$area = \Legacy\System\Classes\LegacyDB::find('slug FROM areas WHERE id = ?', [$test['areaID']]);

				$text .= '<br><a href="' . client_url('/' . $area . '/section?id=' . $test['sectionID'] . '&step=' . $test['step'] . '&user=' . studentId()) . '" class="txt-c4 fw-bold view-result">Visualizza</a>';
			}

			if ($test['template'] == 'survey' && \Legacy\System\Classes\LegacyDB::exists('surveys WHERE testId = ?', [$test['id']]))
				$text .= '<br><span class="clickable txt-gre fw-bold view-result">Scarica le risposte</span>';

			$result['values'][] = $text;
		} else
			$result['values'][] = '<span class="txt-red txt-sbold">non completato</span>';
	}

	$results[] = $result;
}

//averages
$enableAverage = \Legacy\System\Classes\LegacyDB::count('tests WHERE sectionId = ? AND type<>2 AND static=0 AND template<>"recap"', [$id]);

//average - class
$result = [];
$result[] = 'Media della classe';

$studentsN = \Legacy\System\Classes\LegacyDB::count('users WHERE level=0 AND status=1 AND class = ?', $grade);

foreach ($tests as $test) {

	$resN = \Legacy\System\Classes\LegacyDB::count(TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' IN (SELECT ID FROM users WHERE level=0 AND status=1 AND class = ?) AND testID = ?', [$grade, $test['id']]);
	$total = \Legacy\System\Classes\LegacyDB::sum('percentage FROM ' . TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' IN (SELECT ID FROM users WHERE level=0 AND status=1 AND class = ?) AND testID = ?', [$grade, $test['id']]);

	if ($resN / $studentsN > .75 && $test['type'] != 2) {

		$percent = round($total / $resN);

		$result[] = 'risultato medio: <span class="txt-c5 fw-bold">' . $percent . '%</span>';
	} else if ($test['type'] == 2) $result[] = '-';
	else $result[] = '<span class="txt-sbold">È necessario che più alunni completino l\'attività per avere un valore attendibile</span>';
}

$average_class = $result;

//average - all
$result = [];
$result[] = 'Media dei partecipanti';

$studentsN = \Legacy\System\Classes\LegacyDB::count('users WHERE level=0 AND status=1');

foreach ($tests as $test) {

	$resN = \Legacy\System\Classes\LegacyDB::count(TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' IN (SELECT ID FROM users WHERE level=0 AND status=1) AND testID = ?', [$test['id']]);
	$total = \Legacy\System\Classes\LegacyDB::sum('percentage FROM ' . TestResult::TABLE . ' WHERE ' . TestResult::USER_INDEX . ' IN (SELECT ID FROM users WHERE level=0 AND status=1) AND testID = ?', [$test['id']]);

	if ($resN / $studentsN > .40 && $test['type'] != 2) {

		$percent = round($total / $resN);

		$result[] = 'risultato medio: <span class="txt-c5 fw-bold">' . $percent . '%</span>';
	} else if ($test['type'] == 2) $result[] = '-';
	else $result[] = '<span class="txt-sbold">È necessario che più alunni completino l\'attività per avere un valore attendibile</span>';
}

$average_all = $result;

//download results
if (isset($_POST['download'])) {

	$testId = $_POST['testId'];
	$studentId = $_POST['studentId'];

	if (\Legacy\System\Classes\LegacyDB::exists(TestResult::TABLE . ' WHERE testID = ? AND userID = ?', [$testId, $studentId]))
		print_survey_results($testId, $studentId, true);
}

//store variables
$this->set('section', $section);
$this->set('tests', $tests);
$this->set('results', $results);
$this->set('enableAverage', $enableAverage);
$this->set('average_class', $average_class);
$this->set('average_all', $average_all);
