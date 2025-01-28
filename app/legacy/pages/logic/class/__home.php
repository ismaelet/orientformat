<?php

// get user
global $user, $grade;

// fetch areas and sections
$areas = [];

$res = \App\Legacy\LegacyDB::select('id, name FROM areas WHERE id<4 ORDER BY id ASC');

while ($row = $res->fetch_assoc()) {

	$area['name'] = $row['name'];
	$area['sections'] = [];

	$legacySections = \App\Legacy\LegacyDB::select('* FROM sections WHERE active=1 AND locked=0 AND area = ? ORDER BY id ASC', [$row['id']]);

	while ($legacySection = $legacySections->fetch_assoc()) {
		switch ($legacySection['id']) {
			case 1:
				$legacySection['resultName'] = 'Stile prevalente nella classe';
				$legacySection['actions'] = [
					'Risultati divisi per stile' => 'stili-parameters',
					'Risultati divisi per studente' => 'stili-students',
				];
				break;
			case 4:
				$legacySection['actions'] = [
					'Risultati divisi per area' => 'autostima-parameters',
					'Risultati divisi per studente' => 'autostima-students',
				];
				break;
			case 5:
				$legacySection['actions'] = [
					'Risultati dell\'autovalutazine' => 'problemi-autovalutazione',
					'Risultati dei test' => 'problemi-tests',
				];
				break;
			case 6:
				$legacySection['resultName'] = 'Stile prevalente nella classe';
				$legacySection['defaultResult'] = 'Strategia';
				break;
			case 7:
				$legacySection['resultName'] = 'Area di interesse prevalente';
				$legacySection['defaultResult'] = 'Area naturalistica';
				break;
			case 8:
				$legacySection['resultName'] = 'Temperamento più pronunciato';
				$legacySection['defaultResult'] = 'Estroversione';
				break;
			case 9:
				$legacySection['defaultResult'] = '38%';
				$legacySection['actions'] = [
					'Risultati dell\'autovalutazine' => 'attenzione-autovalutazione',
					'Risultati del questionario' => 'attenzione-questionario',
				];
				break;
			case 10:
				$legacySection['defaultResult'] = '61%';
				$legacySection['actions'] = [
					'Risultati dell\'autovalutazine' => 'ricordare-autovalutazione',
					'Risultati dei test' => 'ricordare-tests',
				];
				break;
			case 11:
				$legacySection['defaultResult'] = '59%';
				$legacySection['actions'] = [
					'Risultati dell\'autovalutazine' => 'ricordare-autovalutazione',
					'Risultati del racconto' => 'ricordare-tests',
				];
				break;
			case 12:
				$legacySection['defaultResult'] = '72%';
				$legacySection['actions'] = [
					'Risultati dell\'autovalutazine' => 'ricordare-autovalutazione',
				];
				break;
			case 13:
				$legacySection['defaultResult'] = '53%';
				$legacySection['actions'] = [
					'Risultati dell\'autovalutazine' => 'ricordare-autovalutazione',
					'Risultati del racconto' => 'ricordare-tests',
				];
				break;
			case 14:
				$legacySection['resultName'] = 'Tipo di scrittura più usato';
				$legacySection['defaultResult'] = 'Pubblico Testuale';
				$legacySection['actions'] = [
					'Risultati dell\'autovalutazine' => 'ricordare-autovalutazione',
					'Stili di scrittura' => 'ricordare-tests',
				];
				break;
			case 15:
				$legacySection['defaultResult'] = '66%';
				$legacySection['actions'] = [
					'Risultati dell\'autovalutazine' => 'ricordare-autovalutazione',
					'Risultati dei test' => 'ricordare-tests',
				];
				break;
			case 17:
				$legacySection['resultName'] = 'Stile più sviluppato';
				$legacySection['defaultResult'] = 'Pensiero creativo';
				$legacySection['actions'] = [
					'Risultati divisi per area' => 'autostima-parameters',
					'Risultati divisi per studente' => 'autostima-students',
				];
				break;
			case 18:
				$legacySection['resultName'] = 'Attività completata dal';
				$legacySection['defaultResult'] = '100% degli studenti';
				$legacySection['actions'] = [];
				break;
		}

		$area['sections'][] = $legacySection;
	}

	$areas[] = $area;
}
