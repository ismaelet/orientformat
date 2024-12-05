<?php

use \Legacy\SchoolSystem\SchoolClass;

$pageType = $_GET['type'] ?? null;
$pageType = in_array($pageType, ['new-middleschool', 'new-highschool', 'collaborate']) ? $pageType : null;
$error = false;

$schools = \App\Legacy\LegacyDB::select('* FROM schools WHERE status = 1 AND id IN (SELECT ' . SchoolClass::SCHOOL_INDEX . ' FROM ' . SchoolClass::TABLE . ') ORDER BY name ASC');

// generate a default school ID based on the other classes
$defaultSchoolId = null;

if (teacher()->schoolClassIds) {
	$classesSql = implode(',', teacher()->schoolClassIds);
	$defaultSchoolId = \App\Legacy\LegacyDB::find(SchoolClass::SCHOOL_INDEX . ' FROM ' . SchoolClass::TABLE . ' WHERE ' . SchoolClass::INDEX . ' IN (' . $classesSql . ') ORDER BY ' . SchoolClass::INDEX . ' DESC');
}

// generate the years array
$startingYears = [];
$currentYear = getdate()['year'];
$currentMonth = (int) date('m', strtotime('now'));
$currentYear = $currentMonth > 6 ? $currentYear : $currentYear - 1;

for ($i = 2020; $i <= $currentYear + 1; $i++) {
	$startingYears[] = [$i, $i . ' / ' . ($i + 1)];
}

// generate the inputs
$formInputs = [];

if ($pageType == 'new-middleschool') {
	$formInputs[] = [
		['type' => 'lbl', 'text' => 'La classe è al'],
		['type' => 'select', 'name' => 'grade', 'array' => [[1, 'Primo anno'], [2, 'Secondo anno'], [3, 'Terzo anno']]],
	];
}

$formInputs[] =
	$pageType == 'new-middleschool' ? [
		['type' => 'lbl', 'text' => 'Lettera identificativa della della classe'],
		['type' => 'info', 'text' => 'Lettera che identifica la classe, ad es. se la classe è una 3B la lettera è "B", se è una 2A è "A", ecc.'],
		['name' => 'letter', 'text' => 'Lettera identificativa', 'custom-class' => 'txt-upp', 'maxlength' => 1, 'required' => true],
		['type' => 'error', 'error' => 'empty-name', 'text' => 'Devi scegliere il nome della classe'],
		['type' => 'error', 'error' => 'duplicate', 'text' => 'Esiste già una classe con questo nome associata a questo istituto']
	] : [
		['type' => 'lbl', 'text' => 'Nome della classe'],
		['type' => 'info', 'text' => 'Nome della classe, ad es. "3BS", "L1B" o "A4F"'],
		['name' => 'letter', 'text' => 'Nome della classe', 'custom-class' => 'txt-upp', 'required' => true],
		['type' => 'error', 'error' => 'empty-name', 'text' => 'Devi scegliere il nome della classe'],
		['type' => 'error', 'error' => 'duplicate', 'text' => 'Esiste già una classe con questo nome associata a questo istituto']
	];

if ($pageType == 'new-highschool') {
	$formInputs[] = [
		['type' => 'lbl', 'text' => 'La classe è iscritta in un'],
		['type' => 'radio', 'name' => 'school_class_type', 'value' => 'L', 'text' => 'Istituto Tecnico, Professionale o Liceo', 'size' => 2, 'checked' => true],
		['type' => 'radio', 'name' => 'school_class_type', 'value' => 'P', 'text' => 'Istituto di Istruzione e Formazione Professionale', 'size' => 2],
	];

	$formInputs[] = [
		['type' => 'lbl', 'text' => 'Anno di corso'],
		['type' => 'info', 'text' => 'L\'anno di corso della classe, calcolato automaticamente in base al nome fornito.'],
		['type' => 'hidden', 'name' => 'grade',],
		['type' => 'select', 'name' => 'visible_grade', 'disabled' => true, 'array' => [[1, 'Primo anno'], [2, 'Secondo anno'], [3, 'Terzo anno'], [4, 'Quarto anno'], [5, 'Quinto anno']]],
		['type' => 'error', 'error' => 'empty-name', 'text' => 'Devi scegliere il nome della classe'],
		['type' => 'error', 'error' => 'empty-grade', 'text' => 'Devi scegliere l\'anno scolastico']
	];
}

array_push(
	$formInputs,

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
		'query' => '* FROM schools WHERE status = 1 AND has_high_school = 1 ORDER BY name ASC',
		'field-name' => 'id',
		'field-show' => 'name',
		'value' => $defaultSchoolId
	],
	[
		['type' => 'lbl', 'text' => 'Anno scolastico'],
		[
			'type' => 'select',
			'name' => 'year',
			'array' => $startingYears,
			'value' => $currentYear
		],
	]
);

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

		while (\App\Legacy\LegacyDB::exists(SchoolClass::TABLE . ' WHERE code = ?', [$code])) {
			$code = bin2hex(random_bytes(5));
		}

		$classId = \App\Legacy\LegacyDB::add(SchoolClass::TABLE . ' (letter, ' . SchoolClass::SCHOOL_INDEX . ', startingYear, year, grade, startingGrade, code, referentId, professional)', [$letter, $schoolId, $startingYear, $startingYear, $grade, $grade, $code, teacherId(), $professional]);

		\App\Legacy\LegacyDB::update("teachers SET classes = CONCAT(classes, '," . $classId . "') WHERE userId = ?", [teacherId()]);

		$_SESSION['dashboard-schoolClassId'] = $classId;

		redirect_old('/class?classid=' . $classId);
	}
}

/*
* Request collaboration
*/
if (isset($_POST['collaborate'])) {
	$schoolClassId = $_POST['schoolClassId'];
	$schoolClass = new SchoolClass($schoolClassId);

	if (!\App\Legacy\LegacyDB::exists('grade_requests WHERE teacherId = ? AND gradeId = ?', [teacher()->id, $schoolClass->id])) {
		\App\Legacy\LegacyDB::add('grade_requests (teacherId, gradeId, referentId)', [teacher()->id, $schoolClass->id, $schoolClass->referentId]);
	}

	$pageType = 'requested';
}
