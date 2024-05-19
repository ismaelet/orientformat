<?php

use \Legacy\SchoolSystem\SchoolClass;

$done = $_GET['done'] ?? false;
$error = false;

$inputs = [
	schoolClass()->isMiddleSchool ? [
		['type' => 'done', 'text' => 'Impostazioni salvate con successo!'],
		['type' => 'lbl', 'text' => 'Anno scolastico'],
		['type' => 'select', 'name' => 'grade', 'value' => schoolClass()->currentGrade, 'array' => [[1, 'Primo anno'], [2, 'Secondo anno'], [3, 'Terzo anno']]],
		['type' => 'error', 'error' => 'empty-grade', 'text' => 'Devi scegliere l\'anno scolastico']
	] : [
		['type' => 'done', 'text' => 'Impostazioni salvate con successo!'],
		['type' => 'lbl', 'text' => 'Anno scolastico'],
		['type' => 'select', 'name' => 'grade', 'value' => schoolClass()->currentGrade . (schoolClass()->isProfessional ? '-P' : null), 'array' => [[4, 'Istituti Tecnici, Professionali e Licei - Primo anno'], [5, 'Istituti Tecnici, Professionali e Licei - Secondo anno'], [6, 'Istituti Tecnici, Professionali e Licei - Terzo anno'], [7, 'Istituti Tecnici, Professionali e Licei - Quarto anno'], [8, 'Istituti Tecnici, Professionali e Licei - Quinto anno'], ['4-P', 'Istruzione e Formazione Professionale - Primo anno'], ['5-P', 'Istruzione e Formazione Professionale - Secondo anno'], ['6-P', 'Istruzione e Formazione Professionale - Terzo anno'], ['7-P', 'Istruzione e Formazione Professionale - Quarto anno']]],
		['type' => 'error', 'error' => 'empty-grade', 'text' => 'Devi scegliere l\'anno scolastico']
	],
	schoolClass()->isMiddleSchool ? [
		['type' => 'lbl', 'text' => 'Lettera identificativa della della classe'],
		['type' => 'info', 'text' => 'Lettera che identifica la classe, ad es. se la calsse è una 3B la lettera è "B", se è una 2A è "A", ecc.'],
		['name' => 'letter', 'text' => 'Lettera identificativa', 'custom-class' => 'txt-upp', 'maxlength' => 1, 'required' => true, 'value' => schoolClass()->letter],
		['type' => 'error', 'error' => 'duplicate', 'text' => 'Esiste già una classe con questo nome associata a questo istituto']
	] : [
		['type' => 'lbl', 'text' => 'Nome della classe'],
		['type' => 'info', 'text' => 'Nome della classe, ad es. "3BS", "L1B" o "A4F"'],
		['name' => 'letter', 'text' => 'Lettera identificativa', 'custom-class' => 'txt-upp', 'maxlength' => 10, 'required' => true, 'value' => schoolClass()->letter],
		['type' => 'error', 'error' => 'duplicate', 'text' => 'Esiste già una classe con questo nome associata a questo istituto']
	],
	[
		['type' => 'lbl', 'text' => 'Istituto'],
		[
			'type' => 'select',
			'name' => 'schoolId',
			'query' => '* FROM schools WHERE status=1 ORDER BY name ASC',
			'field-name' => 'id',
			'field-show' => 'name',
			'value' => schoolClass()->schoolId,
		],
	],
];

/*
* Form submit
*/
if (isset($_POST['submit'])) {
	$fullClassGrade = $_POST['grade'];
	$professional = 0;

	if (strpos($fullClassGrade, '-')) {
		$fullClassGrade = explode('-', $fullClassGrade);
		$classGrade = $fullClassGrade[0];
		$professional = $fullClassGrade[1] == 'P' ? 1 : 0;
	} else {
		$classGrade = $fullClassGrade;
	}

	$letter = strtoupper($_POST['letter']);
	$schoolId = $_POST['schoolId'];
	$ended = (int) isset($_POST['survey-end']);

	\App\Legacy\LegacyDB::update(SchoolClass::TABLE . ' SET grade = ?, letter = ?, ' . SchoolClass::SCHOOL_INDEX . ' = ?, ended = ?, professional = ? WHERE id = ?', [$classGrade, $letter, $schoolId, $ended, $professional, schoolClassId()]);

	redirect_old('?done=1');
}

if (isset($_POST['delete'])) {
	\App\Legacy\LegacyDB::delete(SchoolClass::TABLE . ' WHERE ' . SchoolClass::INDEX . ' = ?', [schoolClassId()]);

	redirect_old('/teacher');
}
