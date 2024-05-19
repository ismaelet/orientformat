<?php

/* TEMP: add class letter */
/*$tempClasses = \Legacy\System\Classes\LegacyDB::select('id, name FROM classes');

while ($tempClassRow = $tempClasses->fetch_assoc()) {
	\Legacy\System\Classes\LegacyDB::update('classes SET letter = ? WHERE id = ?', [$tempClassRow['name'][1], $tempClassRow['id']]);
}
/* END */

/* TEMP: create teachers */
/*$tempTeachers = \Legacy\System\Classes\LegacyDB::select('id, class FROM users WHERE level=1 AND id NOT IN (SELECT userId FROM teachers)');

while ($tempTeacher = $tempTeachers->fetch_assoc()) {
	\Legacy\System\Classes\LegacyDB::add('teachers (userId, classes)', [$tempTeacher['id'], $tempTeacher['class']]);
}
/* END TEMP */

/* TEMP: create students */
/*$tempStudents = \Legacy\System\Classes\LegacyDB::select('id, class FROM users WHERE level=0 AND id NOT IN (SELECT userId FROM students)');

while ($tempStudent = $tempStudents->fetch_assoc()) {
	\Legacy\System\Classes\LegacyDB::add('students (userId, classId)', [$tempStudent['id'], $tempStudent['class']]);
}
/* END TEMP */

/* TEMP: standardize class names */
/*$resTemp = \Legacy\System\Classes\LegacyDB::select('* FROM classes');

while ($rowTemp = $resTemp->fetch_assoc()) {
	$tempName = strtoupper(str_replace(' ', '', $rowTemp['name']));

	if ($tempName[0] == 'I') {
		$tempName = str_replace('III', '3', $tempName);
		$tempName = str_replace('II', '2', $tempName);
	}

	if (strlen($tempName) > 2) $tempName = substr($tempName, 0, 2);

	\Legacy\System\Classes\LegacyDB::update('classes SET name = ? WHERE id = ?', [$tempName, $rowTemp['id']]);
}
/* END TEMP */

/* TEMP: set class grades */
/*$resTemp = \Legacy\System\Classes\LegacyDB::select('* FROM classes WHERE grade=0 OR grade IS null');

while ($rowTemp = $resTemp->fetch_assoc()) {
	$tempGrade = $rowTemp['name'][0];

	if (in_array($tempGrade, [2, 3])) {
		\Legacy\System\Classes\LegacyDB::update('classes SET grade = ? WHERE id = ?', [$tempGrade, $rowTemp['id']]);
	}
}
/* END TEMP */

/* TEMP: set referents */
/*$resTemp = \Legacy\System\Classes\LegacyDB::select('* FROM classes WHERE referentId=0 || referentId IS null');

while ($rowTemp = $resTemp->fetch_assoc()) {
	$tempReferentId = \Legacy\System\Classes\LegacyDB::find('userId FROM teachers WHERE FIND_IN_SET(?, classes) ORDER BY userId ASC', [$rowTemp['id']]);
	\Legacy\System\Classes\LegacyDB::update('classes SET referentId = ? WHERE id = ?', [$tempReferentId, $rowTemp['id']]);
}
/* END TEMP */

/* TEMP: standardize the year */
/*\Legacy\System\Classes\LegacyDB::update('classes SET year=2021 WHERE year IN (20213, 20212)');
\Legacy\System\Classes\LegacyDB::update('classes SET year=2022, grade=3 WHERE year=2021 AND grade=2');

$resTemp = \Legacy\System\Classes\LegacyDB::select('* FROM classes WHERE grade=3 AND year=3');
/* END TEMP */

/* TEMP: full school list */
/*$tempSchools = [
	'Associazione Pedagogica Steineriana - Trento',
	'Collegio Arcivescovile C.Endrici - Trento',
	'Collegio Arcivescovile Dame Inglesi - Rovereto',
	'Gardascuola Società Cooperativa Sociale - Arco',
	'Istituto Comprensivo Ala "Antonio Bresciani"',
	'Istituto Comprensivo Aldeno Mattarello',
	'Istituto Comprensivo Alta Val di Sole',
	'Istituto Comprensivo Alta Vallagarina',
	'Istituto Comprensivo Altopiano di Piné',
	'Istituto Comprensivo Arco',
	'Istituto Comprensivo Avio',
	'Istituto Comprensivo Bassa Anaunia - Tuenno',
	'Istituto Comprensivo Bassa Val di Sole "G. Ciccolini"',
	'Istituto Comprensivo Borgo Valsugana',
	'Istituto Comprensivo Brentonico',
	'Istituto Comprensivo Cavalese',
	'Istituto Comprensivo Cembra',
	'Istituto Comprensivo Centro Valsugana',
	'Istituto Comprensivo Civezzano',
	'Istituto Comprensivo Cles',
	'Istituto Comprensivo Cles "B. Clesio"',
	'Istituto Comprensivo Del Chiese "Don L. Milani"',
	'Istituto Comprensivo di Scuola Primaria e Secondaria di Primiero',
	'Istituto Comprensivo Folgaria - Lavarone - Luserna',
	'Istituto Comprensivo Fondo - Revò',
	'Istituto Comprensivo Giudicarie Esteriori',
	'Istituto Comprensivo Isera - Rovereto',
	'Istituto Comprensivo Lavis',
	'Istituto Comprensivo Levico Terme',
	'Istituto Comprensivo Mezzocorona',
	'Istituto Comprensivo Mezzolombardo - Paganella',
	'Istituto Comprensivo Mori',
	'Istituto Comprensivo Pergine 1',
	'Istituto Comprensivo Pergine 2 "C. Freinet"',
	'Istituto Comprensivo Predazzo - Tesero - Panchià - Ziano',
	'Istituto Comprensivo Riva 1',
	'Istituto Comprensivo Riva 2 "L. Pizzini"',
	'Istituto Comprensivo Rovereto Est',
	'Istituto Comprensivo Rovereto Nord',
	'Istituto Comprensivo Rovereto Sud',
	'Istituto Comprensivo Strigno e Tesino',
	'Istituto Comprensivo Taio',
	'Istituto Comprensivo Tione',
	'Istituto Comprensivo Trento 1',
	'Istituto Comprensivo Trento 2 "J. A. Comenius"',
	'Istituto Comprensivo Trento 3',
	'Istituto Comprensivo Trento 4',
	'Istituto Comprensivo Trento 5',
	'Istituto Comprensivo Trento 6',
	'Istituto Comprensivo Trento 7 "Rita Levi Montalcini"',
	'Istituto Comprensivo Val Rendena',
	'Istituto Comprensivo Valle dei Laghi - Dro',
	'Istituto Comprensivo Valle di Ledro',
	'Istituto Comprensivo Vigolo Vattaro',
	'Istituto Comprensivo Villa Lagarina',
	'Istituto di Istruzione "A. Degasperi" - Borgo Valsugana',
	'Istituto di Istruzione "Don L.milani" - Rovereto',
	'Istituto di Istruzione "L. Guetti" - Tione di Trento',
	'Istituto di Istruzione "La Rosa Bianca" - Cavalese',
	'Istituto di Istruzione "M. Curie" - Pergine Valsugana',
	'Istituto di Istruzione "M. Martini" - Mezzolombardo',
	'Istituto di Prova',
	'Istituto Sacro Cuore - Trento',
	'Istituto Salesiano Maria Ausiliatrice - Trento',
	'Istituto Salesiano S. Croce - Mezzano',
	'Istituto Tecnico Economico E Tecnologico "C.a. Pilati" - Cles',
	'Istituto Tecnico Economico E Tecnologico "G. Floriani" - Riva Del Garda',
	'Liceo "A. Rosmini" - Trento',
	'Scuola Ladina di Fassa - Scola Ladina de Fascia',
	'Scuola Paritaria La Vela - Fondazione Famiglia Materna - Rovereto',
];

foreach ($tempSchools as $tempSchool) {
	$tempSchoolName = $tempSchool;

	if (!\Legacy\System\Classes\LegacyDB::exists('schools WHERE name = ?', [$tempSchoolName])) {
		\Legacy\System\Classes\LegacyDB::add('schools (name)', [$tempSchoolName]);
	}
}
/* END TEMP */