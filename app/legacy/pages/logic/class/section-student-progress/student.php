<?php

use Illuminate\Support\Facades\DB;
use Legacy\UserSystem\Student;

// get user
global $user, $grade;

$studentId = $_GET['id'];
$student = new Student($studentId);

if ($student->schoolClass->id != $grade->id) {
    redirect_old('/class');
}

// fetch areas and sections
$areas = [];

$res = array_map(static fn ($row) => (array) $row, DB::select('SELECT '.('id, name FROM areas WHERE id<4 ORDER BY id ASC'), (array) ([])));

while ($row = array_shift($res)) {

    $area['name'] = $row['name'];
    $area['sections'] = [];

    $legacySections = array_map(static fn ($row) => (array) $row, DB::select('SELECT '.('* FROM sections WHERE active=1 AND area = ? ORDER BY id ASC'), (array) ([$row['id']])));

    while ($legacySection = array_shift($legacySections)) {
        switch ($legacySection['id']) {
            case 1:
                $legacySection['resultName'] = 'Stile prevalente';
                break;
            case 4:
                $legacySection['actions'] = [
                    'Risultati divisi per area' => 'autostima-parameters',
                    'Risultati divisi per studente' => 'autostima-students',
                ];
                break;
            case 5:
                $legacySection['defaultResult'] = '47%';
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
                break;
            case 18:
                $legacySection['resultName'] = 'Stato';
                $legacySection['defaultResult'] = 'Completato';
                $legacySection['actions'] = [
                    'Esamina l\'albero' => 'ricordare-autovalutazione',
                ];
                break;
        }

        $area['sections'][] = $legacySection;
    }

    $areas[] = $area;
}

$areas[] = [
    'name' => 'Questionari',
    'sections' => [
        [
            'id' => 101,
            'slug' => 'survey-start',
            'resultName' => 'Stato',
            'defaultResult' => 'Completato',
            'name' => 'Questionario iniziale',
        ],
        [
            'id' => 102,
            'slug' => 'survey-end',
            'resultName' => 'Stato',
            'defaultResult' => 'Completato',
            'name' => 'Questionario finale',
        ],
    ],
];
