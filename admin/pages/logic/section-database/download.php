<?php

use SchoolSystem\School;
use SchoolSystem\SchoolClass;
use Student\Profile;
use UserSystem\Student;
use UserSystem\Student\Advice;
use UserSystem\Teacher;

/*
* TEMP: condensed columns
*/
/*
$tests = DB::select('* FROM tests WHERE active = 1 AND template <> "recap" ORDER BY sectionID ASC, step ASC');

while ($test = $tests->fetch_assoc()) {
	if (!$test['static'] && !$test['dependentOn']) {
		// results
		$colName = 'test' . $test['id'] . '_results';
		$colExists = (DB::execute("SHOW COLUMNS FROM results_condensed LIKE '" . $colName . "'"))->num_rows;

		if (!$colExists) {
			DB::execute("ALTER TABLE results_condensed ADD " . $colName . " VARCHAR(200) DEFAULT ''");
		}

		// percentage
		$colName = 'test' . $test['id'] . '_percentage';
		$colExists = (DB::execute("SHOW COLUMNS FROM results_condensed LIKE '" . $colName . "'"))->num_rows;

		if (!$colExists) {
			DB::execute("ALTER TABLE results_condensed ADD " . $colName . " INT(3) DEFAULT 100");
		}
	}

	// speed
	$colName = 'test' . $test['id'] . '_speed';
	$colExists = (DB::execute("SHOW COLUMNS FROM results_condensed LIKE '" . $colName . "'"))->num_rows;

	if (!$colExists) {
		DB::execute("ALTER TABLE results_condensed ADD " . $colName . " INT(4) DEFAULT 0");
	}

	// times
	$colName = 'test' . $test['id'] . '_times';
	$colExists = (DB::execute("SHOW COLUMNS FROM results_condensed LIKE '" . $colName . "'"))->num_rows;

	if (!$colExists) {
		DB::execute("ALTER TABLE results_condensed ADD " . $colName . " INT(3) DEFAULT 1");
	}
}
*/
/*
* END TEMP
*/

/*
* TEMP: copy results to condensed
*/
/*

$tests = [];
$students = DB::select('* FROM students WHERE userId NOT IN (SELECT studentId FROM results_condensed)');

$testRows = DB::select('
		tests.id as testId, title, sections.name as sectionName, static, dependentOn
		FROM tests
			INNER JOIN sections ON tests.sectionID = sections.id
		WHERE tests.active = 1 AND template <> "recap"
		ORDER BY sectionID ASC, step ASC
	');

while ($test = $testRows->fetch_assoc()) {
	$tests[] = $test;
}

while ($student = $students->fetch_assoc()) {
	DB::add('results_condensed (studentId)', [$student['userId']]);

	foreach ($tests as $test) {
		$result = DB::row(
			'result, percentage, speed, timesNumber
			FROM results_permanent
			WHERE userID = ? AND testID = ?',
			[$student['userId'], $test['testId']]
		);

		if ($result) {
			if (!$test['static'] && !$test['dependentOn']) {
				DB::update('results_condensed SET test' . $test['testId'] . '_results = ?, test' . $test['testId'] . '_percentage = ? WHERE studentId = ?', [$result['result'], $result['percentage'], $student['userId']]);
			}

			DB::update('results_condensed SET test' . $test['testId'] . '_speed = ?, test' . $test['testId'] . '_times = ? WHERE studentId = ?', [$result['speed'], $result['timesNumber'], $student['userId']]);
		}
	}
}
*/

// update current year
// DB::update(SchoolClass::TABLE . ' SET year = startingYear + grade - startingGrade');
/*
* END TEMP
*/

$startingYear = 2021;
$currentYear = getdate()['year'];

/*
* Download students
*/
if (isset($_POST['download-students'])) {
	$studentsArray = [];
	$yearFilter = $_POST['download-students'] != 'all' ? $_POST['download-students'] : false;
	$yearSql = $yearFilter ? 'AND startingYear = ?' : '';
	$parameters = $yearFilter ? [$yearFilter] : [];
	$fileTitle = $yearFilter ? 'Lista degli studenti - ' . $yearFilter . '-' . ($yearFilter + 1) : 'Lista di tutti gli studenti';

	$students = DB::select('
	' . Student::INDEX . ', firstName, lastName, CONCAT (grade, letter) as gradeName, startingYear, grade, birthdate, schools.name as schoolName
		FROM ' . Student::TABLE . '
			INNER JOIN ' . User::TABLE . ' ON ' . Student::TABLE . '.' . Student::INDEX . ' = ' . User::TABLE . '.' . User::INDEX . '

			INNER JOIN ' . SchoolClass::TABLE . ' ON ' . Student::TABLE . '.' . Student::SCHOOL_CLASS_INDEX . ' = ' . SchoolClass::TABLE . '.' . SchoolClass::INDEX . '

			INNER JOIN ' . School::TABLE . ' ON ' . SchoolClass::TABLE . '.' . SchoolClass::SCHOOL_INDEX . ' = ' . School::TABLE . '.' . School::INDEX . '
	WHERE ' . User::TABLE . '.status = 1 AND admin = 0 ' . $yearSql . '
	ORDER BY ' . User::TABLE . '.' . User::INDEX . ' ASC', $parameters);

	while ($student = $students->fetch_assoc()) {
		$studentData = [
			'ID' => $student['userId'],
			'Cognome' => $student['lastName'],
			'Nome' => $student['firstName'],
			'Classe' => $student['gradeName'],
			'Istituto' => $student['schoolName'],
			'Registrato/a nel' => $student['startingYear'] . '/' . ($student['startingYear'] + 1),
			'Anno di corso' => $student['grade'],
			'Data di nascita' => $student['birthdate'],
		];

		$studentsArray[] = $studentData;
	}

	download_csv($studentsArray, $fileTitle);
}

/*
* Download teachers
*/
if (isset($_POST['download-teachers'])) {
	$teachersArray = [];
	$yearFilter = $_POST['download-teachers'] != 'all' ? $_POST['download-teachers'] : false;
	$yearSql = $yearFilter ? 'AND YEAR(time) = ?' : '';
	$parameters = $yearFilter ? [$yearFilter] : [];
	$fileTitle = $yearFilter ? 'Lista dei docenti - ' . $yearFilter : 'Lista dei docenti';

	$teachers = DB::select('
	userId, firstName, lastName, email
		FROM ' . Teacher::TABLE . '
			INNER JOIN ' . User::TABLE . ' ON ' . Teacher::TABLE . '.' . Teacher::INDEX . ' = ' . User::TABLE . '.' . User::INDEX . '
	WHERE ' . User::TABLE . '.status = 1 AND admin = 0 ' . $yearSql . '
	ORDER BY ' . User::TABLE . '.' . User::INDEX . ' ASC', $parameters);

	while ($teacher = $teachers->fetch_assoc()) {
		$teacherData = [
			'ID' => $teacher['userId'],
			'Cognome' => $teacher['lastName'],
			'Nome' => $teacher['firstName'],
			'E-mail' => $teacher['email'] ?: '.',
		];

		$teachersArray[] = $teacherData;
	}

	download_csv($teachersArray, $fileTitle);
}

/*
* Download grades
*/
if (isset($_POST['download-school-classes'])) {
	$gradesArray = [];
	$yearFilter = $_POST['download-school-classes'] != 'all' ? $_POST['download-school-classes'] : false;
	$yearSql = $yearFilter ? 'AND startingYear = ?' : '';
	$parameters = $yearFilter ? [$yearFilter] : [];
	$fileTitle = $yearFilter ? 'Lista delle classi - ' . $yearFilter . '-' . ($yearFilter + 1) : 'Lista di tutte le classi';

	$grades = DB::select('
	grade, startingYear, CONCAT(grade, letter) as gradeName, CONCAT (lastName, " ", firstName) as referentName, schools.name as schoolName
		FROM ' . SchoolClass::TABLE . '
			INNER JOIN ' . School::TABLE . ' ON ' . SchoolClass::TABLE . '.' . SchoolClass::SCHOOL_INDEX . ' = ' . School::TABLE . '.' . School::INDEX . '

			INNER JOIN ' . User::TABLE . ' ON ' . SchoolClass::TABLE . '.referentId = ' . User::TABLE . '.' . User::INDEX . '
			
	WHERE ' . SchoolClass::TABLE . '.status = 1 AND admin = 0 ' . $yearSql . '
	ORDER BY ' . SchoolClass::TABLE . '.' . SchoolClass::INDEX . ' ASC', $parameters);

	while ($grade = $grades->fetch_assoc()) {
		$gradeData = [
			'Nome' => $grade['gradeName'],
			'Istituto' => $grade['schoolName'],
			'Anno scolastico' => $grade['startingYear'] . '/' . ($grade['startingYear'] + 1),
			'Anno di corso' => $grade['grade'],
		];

		$gradesArray[] = $gradeData;
	}

	download_csv($gradesArray, $fileTitle);
}

/*
* Download results
*/
if (isset($_POST['download-results'])) {
	$studentsArray = [];
	$yearFilter = $_POST['download-results'] != 'all' ? $_POST['download-results'] : false;
	$yearSql = $yearFilter ? 'AND year = ?' : '';
	$parameters = $yearFilter ? [$yearFilter] : [];
	$fileTitle = $yearFilter ? 'Lista dei risultati - ' . $yearFilter . '-' . ($yearFilter + 1) : 'Lista di tutti i risultati';

	$results = DB::select('
	*, CONCAT (grade, letter) as gradeName, year as gradeYear, grade as grade, birthdate as birthdate, schools.name as schoolName
		FROM students
			INNER JOIN users ON students.userId = users.id
			INNER JOIN classes ON students.classId = classes.id
			INNER JOIN schools ON classes.school = schools.id
			LEFT JOIN results_condensed ON students.userId = results_condensed.studentId
	WHERE users.status = 1 ' . $yearSql . '
	ORDER BY users.id ASC', $parameters);

	// fetch tests data
	$tests = [];

	$testRows = DB::select('
		tests.id as testId, title, sections.name as sectionName, static, dependentOn
		FROM tests
			INNER JOIN sections ON tests.sectionID = sections.id
		WHERE tests.active = 1 AND template <> "recap"
		ORDER BY sectionID ASC, step ASC
	');

	while ($test = $testRows->fetch_assoc()) {
		$tests[] = $test;
	}

	// generate results
	while ($result = $results->fetch_assoc()) {
		$resultData = [
			'ID' => $result['userId'],
			'Cognome' => $result['lastname'],
			'Nome' => $result['firstname'],
			'Classe' => $result['gradeName'],
			'Istituto' => $result['schoolName'],
			'Anno scolastico' => $result['gradeYear'] . '/' . ($result['gradeYear'] + 1),
			'Anno di corso' => $result['grade'],
		];

		foreach ($tests as $test) {
			$testTitle = $test['sectionName'] . ' - ' . $test['title'];

			if (!$test['static'] && !$test['dependentOn']) {
				$resultData[$testTitle . ' - Risultati'] = !empty($result['test' . $test['testId'] . '_results']) ? str_replace(',', ' - ', $result['test' . $test['testId'] . '_results']) : '.';
				$resultData[$testTitle . ' - Percentuale'] = isset($result['test' . $test['testId'] . '_percentage']) ? $result['test' . $test['testId'] . '_percentage'] . '%' : '.';
			}

			$resultData[$testTitle . ' - Tempo Impiegato'] = $result && $result['test' . $test['testId'] . '_speed'] ? $result['test' . $test['testId'] . '_speed'] : '.';
			$resultData[$testTitle . ' - Numero di volte completato'] = $result && $result['test' . $test['testId'] . '_times'] ? $result['test' . $test['testId'] . '_times'] : 0;
		}

		$resultsArray[] = $resultData;
	}

	download_csv($resultsArray, $fileTitle);
}

/*
* Download reviews
*/
if (isset($_POST['download-reviews'])) {
	$reviewsArray = [];
	$yearFilter = $_POST['download-reviews'] != 'all' ? $_POST['download-reviews'] : false;
	$yearSql = $yearFilter ? 'AND year = ?' : '';
	$parameters = $yearFilter ? [$yearFilter] : [];
	$fileTitle = $yearFilter ? 'Lista dei risultati dei questionari - ' . $yearFilter . '-' . ($yearFilter + 1) : 'Lista dei risultati dei questionari';

	// questions
	/*$startQuestions = [];
	$endQuestions = [];
	$resStart = DB::select('CONCAT("s", areaId, "d", slug) as name FROM review_questions WHERE reviewIds="" OR reviewIds IN (1, 2) OR FIND_IN_SET(1, reviewIds) OR FIND_IN_SET(2, reviewIds) ORDER BY areaId ASC, slug ASC');
	$resEnd = DB::select('CONCAT("s", areaId, "d", slug) as name FROM review_questions WHERE reviewIds="" OR reviewIds=3 OR FIND_IN_SET(3, reviewIds) ORDER BY areaId ASC, slug ASC');

	while ($row = $resStart->fetch_assoc()) {
		$startQuestions[] = $row['name'];
	}

	while ($row = $resEnd->fetch_assoc()) {
		$endQuestions[] = $row['name'];
	}*/

	// generate questions mockup
	$startQuestions = [];
	$endQuestions = [];

	$mockupStartProfileId = DB::find('id FROM review_results WHERE reviewId IN (1, 2) ORDER BY reviewId DESC');
	$mockupStartProfile = new Profile($mockupStartProfileId);

	foreach ($mockupStartProfile->numericResults as $questionSlug => $_looping) {
		$startQuestions[] = $questionSlug;
	}

	$mockupEndProfileId = DB::find('id FROM review_results WHERE reviewId = 3 ORDER BY reviewId DESC');
	$mockupEndProfile = new Profile($mockupEndProfileId);

	foreach ($mockupEndProfile->numericResults as $questionSlug => $_looping) {
		$endQuestions[] = $questionSlug;
	}

	asort($startQuestions);
	asort($endQuestions);

	// fetch students
	$students = DB::select('
	userId, firstname, lastname, CONCAT (grade, letter) as gradeName, year as gradeYear, grade as grade, schools.name as schoolName
		FROM students
			INNER JOIN users ON students.userId = users.id
			INNER JOIN classes ON students.classId = classes.id
			INNER JOIN schools ON classes.school = schools.id
			INNER JOIN review_results ON students.userId = review_results.studentId
	WHERE users.status = 1 ' . $yearSql . '
	ORDER BY users.id ASC', $parameters);

	while ($student = $students->fetch_assoc()) {
		$reviewResults = [
			'ID' => $student['userId'],
			'Cognome' => $student['lastname'],
			'Nome' => $student['firstname'],
			'Classe' => $student['gradeName'],
			'Istituto' => $student['schoolName'],
			'Anno scolastico' => $student['gradeYear'] . '/' . ($student['gradeYear'] + 1),
			'Anno di corso' => $student['grade'],
		];

		// reviews results
		$startProfileId = DB::find('id FROM review_results WHERE studentId = ? AND reviewId IN (1, 2) ORDER BY reviewId DESC', [$student['userId']]);
		$endProfileId = DB::find('id FROM review_results WHERE studentId = ? AND reviewId = 3', [$student['userId']]);

		$startProfile = $startProfileId ? new Profile($startProfileId) : null;

		foreach ($startQuestions as $questionSlug) {
			$reviewResults['Iniziale - ' . $questionSlug] = $startProfile->numericResults[$questionSlug] ?? '.';
		}

		$endProfile = $endProfileId ? new Profile($endProfileId) : null;

		foreach ($endQuestions as $questionSlug) {
			$reviewResults['Finale - ' . $questionSlug] = $endProfile->numericResults[$questionSlug] ?? '.';
		}

		$reviewsArray[] = $reviewResults;
	}

	download_csv($reviewsArray, $fileTitle);
}

/*
* Download advices
*/
if (isset($_POST['download-advices'])) {
	$studentsArray = [];
	$yearFilter = $_POST['download-advices'] != 'all' ? $_POST['download-advices'] : false;
	$yearSql = $yearFilter ? 'AND year = ?' : '';
	$parameters = $yearFilter ? [$yearFilter] : [];
	$fileTitle = $yearFilter ? 'Lista dei consigli orientativi - ' . $yearFilter . '-' . ($yearFilter + 1) : 'Lista di tutti i consigli orientativi';

	$students = DB::select('
	advices, users.id as userId, firstname, lastname
		FROM advices
			INNER JOIN students ON advices.userID = students.userId
			INNER JOIN users ON students.userId = users.id
			INNER JOIN classes ON students.classId = classes.id
	WHERE users.status = 1 ' . $yearSql . '
	ORDER BY users.id ASC', $parameters);


	while ($student = $students->fetch_assoc()) {
		$advices = explode(',', $student['advices']);

		$studentData = [
			'ID' => $student['userId'],
			'Cognome' => $student['lastname'],
			'Nome' => $student['firstname'],
			'Consiglio 1' => isset($advices[0]) ? (new Advice($advices[0]))->name : '.',
			'Consiglio 2' => isset($advices[1]) ? (new Advice($advices[1]))->name : '.',
			'Consiglio 3' => isset($advices[2]) ? (new Advice($advices[2]))->name : '.',
		];

		$studentsArray[] = $studentData;
	}


	download_csv($studentsArray, $fileTitle);
}
