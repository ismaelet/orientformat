<?php

use SchoolSystem\SchoolClass;
use UserSystem\Student;
use UserSystem\Teacher;

$studentCount = DB::count(Student::TABLE);
$teacherCount = DB::count(Teacher::TABLE);
$schoolClassCount = DB::count(SchoolClass::TABLE);

$panels = [
	[
		'slug' => 'students',
		'title' => 'Studenti',
		'info' => '<span class="fw-bold">' . $studentCount . '</span> studenti registrati',
		'primary-button' => [
			'type' => 'primary',
			'label' => 'Lista degli studenti',
			'link' => client_url('/students/list'),
		],
	],

	[
		'slug' => 'teachers',
		'title' => 'Docenti',
		'info' => '<span class="fw-bold">' . $teacherCount . '</span> docenti registrati',
		'primary-button' => [
			'type' => 'primary',
			'label' => 'Lista dei docenti',
			'link' => client_url('/teachers/list'),
		],
	],

	[
		'slug' => 'school-classes',
		'title' => 'Classi',
		'info' => '<span class="fw-bold">' . $schoolClassCount . '</span> classi registrate',
		'primary-button' => [
			'type' => 'primary',
			'label' => 'Lista delle classi',
			'link' => client_url('/school-classes/list'),
		],
	],

	[
		'slug' => 'database',
		'title' => 'Database',
		'info' => 'Per accedere ai dati salvati nel database',
		'primary-button' => [
			'type' => 'primary',
			'label' => 'Scarica il database',
			'link' => client_url('/database/download'),
		],
	],
];
