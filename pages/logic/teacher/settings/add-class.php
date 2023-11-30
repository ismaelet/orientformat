<?php

use SchoolSystem\SchoolClass;

$pageType = $_GET['type'] ?? null;
$pageType = in_array($pageType, ['new-middleschool', 'new-highschool', 'collaborate']) ? $pageType : null;
$error = false;

$schools = DB::select('* FROM schools WHERE status = 1 AND id IN (SELECT ' . SchoolClass::SCHOOL_INDEX . ' FROM ' . SchoolClass::TABLE . ') ORDER BY name ASC');

// generate a default school ID based on the other classes
$defaultSchoolId = null;

if (teacher()->schoolClassIds) {
	$classesSql = implode(',', teacher()->schoolClassIds);
	$defaultSchoolId = DB::find(SchoolClass::SCHOOL_INDEX . ' FROM ' . SchoolClass::TABLE . ' WHERE ' . SchoolClass::INDEX . ' IN (' . $classesSql . ') ORDER BY ' . SchoolClass::INDEX . ' DESC');
}

// generate the years array
$startingYears = [];
$currentYear = getdate()['year'];

for ($i = 2020; $i <= $currentYear + 1; $i++) {
	$startingYears[] = [$i, $i . ' / ' . ($i + 1)];
}

// generate the inputs
$formInputs = [
	$pageType == 'new-middleschool' ? [
		['type' => 'lbl', 'text' => 'La classe è al'],
		['type' => 'select', 'name' => 'grade', 'array' => [[1, 'Primo anno'], [2, 'Secondo anno'], [3, 'Terzo anno']]],
	] : [
		['type' => 'lbl', 'text' => 'La classe è al'],
		['type' => 'select', 'name' => 'grade', 'array' => [[4, 'Istituti Tecnici, Professionali e Licei - Primo anno'], [5, 'Istituti Tecnici, Professionali e Licei - Secondo anno'], [6, 'Istituti Tecnici, Professionali e Licei - Terzo anno'], [7, 'Istituti Tecnici, Professionali e Licei - Quarto anno'], [8, 'Istituti Tecnici, Professionali e Licei - Quinto anno'], ['4-P', 'Istruzione e Formazione Professionale - Primo anno'], ['5-P', 'Istruzione e Formazione Professionale - Secondo anno'], ['6-P', 'Istruzione e Formazione Professionale - Terzo anno'], ['7-P', 'Istruzione e Formazione Professionale - Quarto anno']]],
		['type' => 'error', 'error' => 'empty-grade', 'text' => 'Devi scegliere l\'anno scolastico']
	],
	$pageType == 'new-middleschool' ? [
		['type' => 'lbl', 'text' => 'Lettera identificativa della della classe'],
		['type' => 'info', 'text' => 'Lettera che identifica la classe, ad es. se la calsse è una 3B la lettera è "B", se è una 2A è "A", ecc.'],
		['name' => 'letter', 'text' => 'Lettera identificativa', 'custom-class' => 'txt-upp', 'maxlength' => 1, 'required' => true],
		['type' => 'error', 'error' => 'empty-name', 'text' => 'Devi scegliere il nome della classe'],
		['type' => 'error', 'error' => 'duplicate', 'text' => 'Esiste già una classe con questo nome associata a questo istituto']
	] : [
		['type' => 'lbl', 'text' => 'Nome della classe'],
		['type' => 'info', 'text' => 'Nome della classe, ad es. "3BS", "L1B" o "A4F"'],
		['name' => 'letter', 'text' => 'Nome della classe', 'custom-class' => 'txt-upp', 'required' => true],
		['type' => 'error', 'error' => 'empty-name', 'text' => 'Devi scegliere il nome della classe'],
		['type' => 'error', 'error' => 'duplicate', 'text' => 'Esiste già una classe con questo nome associata a questo istituto']
	],
	[
		['type' => 'lbl', 'text' => 'Istituto'],
		$pageType == 'new-middleschool' ? [
			'type' => 'select',
			'name' => 'schoolId',
			'query' => '* FROM schools WHERE status = 1 ORDER BY name ASC',
			'field-name' => 'id',
			'field-show' => 'name',
			'value' => $defaultSchoolId
		] : [
			'type' => 'select',
			'name' => 'schoolId',
			'query' => '* FROM schools WHERE status = 1 AND id IN (40,67,14,48) ORDER BY name ASC',
			'field-name' => 'id',
			'field-show' => 'name',
			'value' => $defaultSchoolId
		],
	],
	[
		['type' => 'lbl', 'text' => 'Anno scolastico'],
		[
			'type' => 'select',
			'name' => 'year',
			'array' => $startingYears,
			'value' => $currentYear
		],
	],

	// ['type' => 'lbl', 'text' => 'Tipo di percorso'],
	// [
	// 	'type' => 'select',
	// 	'name' => 'pathId',
	// 	'query' => '* FROM paths ORDER BY id ASC',
	// 	'field-name' => 'id',
	// 	'field-show' => 'name',
	// 	'value' => 2
	// ],
	// ['type' => 'info', 'text' => 'Vuoi sapere quale percorso scegliere? <a class="fc-primary fw-bold" href="' . client_url('/teacher/paths?return=add') . '">Clicca qui</a><br>Potrai cambiare il tipo di percorso in qualsiasi momento nelle impostazioni della classe.'],
];

/*
* New class
*/
if (isset($_POST['add'])) {
	$grade = $_POST['grade'] ?? null;
	$letter = strtoupper($_POST['letter']);
	$schoolId = $_POST['schoolId'];
	$startingYear = $_POST['year'];
	$professional = 0;

	if (strpos($grade, '-P')) {
		$grade = explode('-', $grade)[0];
		$professional = 1;
	}

	if (!$letter) {
		$error = 'empty-name';
	} else if (!$grade) {
		$error = 'empty-grade';
	} else {
		$code = bin2hex(random_bytes(5));

		while (DB::exists(SchoolClass::TABLE . ' WHERE code = ?', [$code])) {
			$code = bin2hex(random_bytes(5));
		}

		$classId = DB::add(SchoolClass::TABLE . ' (letter, ' . SchoolClass::SCHOOL_INDEX . ', startingYear, year, grade, startingGrade, code, referentId, professional)', [$letter, $schoolId, $startingYear, $startingYear, $grade, $grade, $code, teacherId(), $professional]);

		DB::update("teachers SET classes = CONCAT(classes, '," . $classId . "') WHERE userId = ?", [teacherId()]);

		$_SESSION['dashboard-schoolClassId'] = $classId;

		redirect('/class?classid=' . $classId);
	}
}

/*
* Request collaboration
*/
if (isset($_POST['collaborate'])) {
	$schoolClassId = $_POST['schoolClassId'];
	$schoolClass = new SchoolClass($schoolClassId);

	if (!DB::exists('grade_requests WHERE teacherId = ? AND gradeId = ?', [teacher()->id, $schoolClass->id])) {
		DB::add('grade_requests (teacherId, gradeId, referentId)', [teacher()->id, $schoolClass->id, $schoolClass->referentId]);
	}

	$pageType = 'requested';
}
