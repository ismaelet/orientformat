<?php

// get user
global $user, $grade;

// fetch areas and sections
$areas = [];

$res = \Legacy\System\Classes\LegacyDB::select('id, name FROM areas WHERE id<4 ORDER BY id ASC');

while ($row = $res->fetch_assoc()) {

	$area['name'] = $row['name'];
	$area['sections'] = [];

	$sections = \Legacy\System\Classes\LegacyDB::select('* FROM sections WHERE active=1 AND locked=0 AND area = ? ORDER BY id ASC', [$row['id']]);

	while ($section = $sections->fetch_assoc()) {
		switch ($section['id']) {
			case 1:
				$section['resultName'] = 'Stile prevalente nella classe';
				$section['actions'] = [
					'Risultati divisi per stile' => 'stili-parameters',
					'Risultati divisi per studente' => 'stili-students',
				];
				break;
			case 4:
				$section['actions'] = [
					'Risultati divisi per area' => 'autostima-parameters',
					'Risultati divisi per studente' => 'autostima-students',
				];
				break;
			case 5:
				$section['actions'] = [
					'Risultati dell\'autovalutazine' => 'problemi-autovalutazione',
					'Risultati dei test' => 'problemi-tests',
				];
				break;
			case 6:
				$section['resultName'] = 'Stile prevalente nella classe';
				$section['defaultResult'] = 'Strategia';
				break;
			case 7:
				$section['resultName'] = 'Area di interesse prevalente';
				$section['defaultResult'] = 'Area naturalistica';
				break;
			case 8:
				$section['resultName'] = 'Temperamento più pronunciato';
				$section['defaultResult'] = 'Estroversione';
				break;
			case 9:
				$section['defaultResult'] = '38%';
				$section['actions'] = [
					'Risultati dell\'autovalutazine' => 'attenzione-autovalutazione',
					'Risultati del questionario' => 'attenzione-questionario',
				];
				break;
			case 10:
				$section['defaultResult'] = '61%';
				$section['actions'] = [
					'Risultati dell\'autovalutazine' => 'ricordare-autovalutazione',
					'Risultati dei test' => 'ricordare-tests',
				];
				break;
			case 11:
				$section['defaultResult'] = '59%';
				$section['actions'] = [
					'Risultati dell\'autovalutazine' => 'ricordare-autovalutazione',
					'Risultati del racconto' => 'ricordare-tests',
				];
				break;
			case 12:
				$section['defaultResult'] = '72%';
				$section['actions'] = [
					'Risultati dell\'autovalutazine' => 'ricordare-autovalutazione',
				];
				break;
			case 13:
				$section['defaultResult'] = '53%';
				$section['actions'] = [
					'Risultati dell\'autovalutazine' => 'ricordare-autovalutazione',
					'Risultati del racconto' => 'ricordare-tests',
				];
				break;
			case 14:
				$section['resultName'] = 'Tipo di scrittura più usato';
				$section['defaultResult'] = 'Pubblico Testuale';
				$section['actions'] = [
					'Risultati dell\'autovalutazine' => 'ricordare-autovalutazione',
					'Stili di scrittura' => 'ricordare-tests',
				];
				break;
			case 15:
				$section['defaultResult'] = '66%';
				$section['actions'] = [
					'Risultati dell\'autovalutazine' => 'ricordare-autovalutazione',
					'Risultati dei test' => 'ricordare-tests',
				];
				break;
			case 17:
				$section['resultName'] = 'Stile più sviluppato';
				$section['defaultResult'] = 'Pensiero creativo';
				$section['actions'] = [
					'Risultati divisi per area' => 'autostima-parameters',
					'Risultati divisi per studente' => 'autostima-students',
				];
				break;
			case 18:
				$section['resultName'] = 'Attività completata dal';
				$section['defaultResult'] = '100% degli studenti';
				$section['actions'] = [];
				break;
		}

		$area['sections'][] = $section;
	}

	$areas[] = $area;
}
