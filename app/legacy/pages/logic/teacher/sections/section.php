<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Legacy\UserSystem\Student;

// theme
$this->styles->add(SERVER_ROOT.'/pages/styles/teacher/teacher.css');
$this->scripts->add(SERVER_ROOT.'/pages/scripts/teacher/teacher.js');

// get variables
$id = $_GET['id'] ?? false;

// fetch class
$grade = DB::scalar('SELECT '.('class FROM users WHERE id = ?').' LIMIT 1', (array) ([$user->id])) ?? false;

// fetch section
$legacySection = (array) DB::selectOne('SELECT '.('* FROM sections WHERE id = ?').' LIMIT 1', (array) ([$id])) ?: null;

if (! $legacySection) {
    redirect_old('/teacher/sections');
}

// fetch tests
$legacyTests = [];
$res = array_map(static fn ($row) => (array) $row, DB::select('SELECT '.('* FROM '.Test::TABLE.' WHERE sectionId = ? AND active=1 AND template<>? AND (static=0 OR shared=1) ORDER BY step ASC'), (array) ([$legacySection['id'], 'recap'])));

while ($row = array_shift($res)) {
    $legacyTests[] = $row;
}

// fetch studens
$students = array_map(static fn ($row) => (array) $row, DB::select('SELECT '.('id FROM users WHERE class = ? AND status=1 AND level=0'), (array) ([$grade])));

// fetch results
$results = [];

while ($studentRow = array_shift($students)) {

    $result = [];

    $student = new Student($studentRow['id']);

    $result['studentId'] = Auth::id();
    $result['values'][0] = $student->last_name.' '.$student->first_name;

    foreach ($legacyTests as $legacyTest) {

        $row = (array) DB::selectOne('SELECT '.('completed, percentage FROM '.TestResult::TABLE.' WHERE '.TestResult::USER_INDEX.' = ? AND '.TestResult::TEST_INDEX.' = ?').' LIMIT 1', (array) ([Auth::id(), $legacyTest['id']])) ?: null;

        if ($legacyTest['static'] && DB::selectOne('SELECT 1 FROM '.(TestResult::TABLE.' WHERE '.TestResult::USER_INDEX.' = ? AND '.TestResult::TEST_INDEX.' IN (SELECT id FROM '.Test::TABLE.' WHERE sectionId = ? AND step = ?)').' LIMIT 1', (array) ([Auth::id(), $legacyTest['sectionID'], $legacyTest['step'] - 1])) !== null) {
            $row['completed'] = true;
        }

        if ($row && $row['completed']) {

            if ($legacyTest['type'] != 2 && ($legacyTest['template'] == 'survey' || $legacyTest['type'] == 3)) {
                $text = 'completato con<br>autovalutazione <span class="txt-c5 font-bold">'.$row['percentage'].'%</span>';
            } elseif ($legacyTest['type'] == 1) {
                $text = 'completato con<br>risultato <span class="txt-c5 font-bold">'.$row['percentage'].'%</span>';
            } else {
                $text = '<span class="txt-sbold">completato</span>';
            }

            if ($legacyTest['shared']) {

                $area = DB::scalar('SELECT '.('slug FROM areas WHERE id = ?').' LIMIT 1', (array) ([$legacyTest['areaID']])) ?? false;

                $text .= '<br><a href="'.route('test', ['test' => $legacyTest['id'], 'student_id' => $student->id]).'" class="txt-c4 font-bold view-result">Visualizza</a>';
            }

            if ($legacyTest['template'] == 'survey' && DB::selectOne('SELECT 1 FROM '.('surveys WHERE testId = ?').' LIMIT 1', (array) ([$legacyTest['id']])) !== null) {
                $text .= '<br><span class="clickable txt-gre font-bold view-result">Scarica le risposte</span>';
            }

            $result['values'][] = $text;
        } else {
            $result['values'][] = '<span class="txt-red txt-sbold">non completato</span>';
        }
    }

    $results[] = $result;
}

// averages
$enableAverage = DB::scalar('SELECT COUNT(*) FROM '.('tests WHERE sectionId = ? AND type<>2 AND static=0 AND template<>"recap"'), (array) ([$id]));

// average - class
$result = [];
$result[] = 'Media della classe';

$studentsN = DB::scalar('SELECT COUNT(*) FROM '.('users WHERE level=0 AND status=1 AND class = ?'), (array) ($grade));

foreach ($legacyTests as $legacyTest) {

    $resN = DB::scalar('SELECT COUNT(*) FROM '.(TestResult::TABLE.' WHERE '.TestResult::USER_INDEX.' IN (SELECT ID FROM users WHERE level=0 AND status=1 AND class = ?) AND testID = ?'), (array) ([$grade, $legacyTest['id']]));
    $total = DB::scalar('SELECT SUM(percentage) FROM '.TestResult::TABLE.' WHERE '.TestResult::USER_INDEX.' IN (SELECT ID FROM users WHERE level=0 AND status=1 AND class = ?) AND testID = ?', [$grade, $legacyTest['id']]);

    if ($resN / $studentsN > .75 && $legacyTest['type'] != 2) {

        $percent = round($total / $resN);

        $result[] = 'risultato medio: <span class="txt-c5 font-bold">'.$percent.'%</span>';
    } elseif ($legacyTest['type'] == 2) {
        $result[] = '-';
    } else {
        $result[] = '<span class="txt-sbold">È necessario che più alunni completino l\'attività per avere un valore attendibile</span>';
    }
}

$average_class = $result;

// average - all
$result = [];
$result[] = 'Media dei partecipanti';

$studentsN = DB::scalar('SELECT COUNT(*) FROM '.('users WHERE level=0 AND status=1'), (array) ([]));

foreach ($legacyTests as $legacyTest) {

    $resN = DB::scalar('SELECT COUNT(*) FROM '.(TestResult::TABLE.' WHERE '.TestResult::USER_INDEX.' IN (SELECT ID FROM users WHERE level=0 AND status=1) AND testID = ?'), (array) ([$legacyTest['id']]));
    $total = DB::scalar('SELECT SUM(percentage) FROM '.TestResult::TABLE.' WHERE '.TestResult::USER_INDEX.' IN (SELECT ID FROM users WHERE level=0 AND status=1) AND testID = ?', [$legacyTest['id']]);

    if ($resN / $studentsN > .40 && $legacyTest['type'] != 2) {

        $percent = round($total / $resN);

        $result[] = 'risultato medio: <span class="txt-c5 font-bold">'.$percent.'%</span>';
    } elseif ($legacyTest['type'] == 2) {
        $result[] = '-';
    } else {
        $result[] = '<span class="txt-sbold">È necessario che più alunni completino l\'attività per avere un valore attendibile</span>';
    }
}

$average_all = $result;

// download results
if (isset($_POST['download'])) {

    $testId = $_POST['testId'];
    $studentId = $_POST['studentId'];

    if (DB::selectOne('SELECT 1 FROM '.(TestResult::TABLE.' WHERE testID = ? AND userID = ?').' LIMIT 1', (array) ([$testId, $studentId])) !== null) {
        print_survey_results($testId, $studentId, true);
    }
}

// store variables
$this->set('section', $legacySection);
$this->set('tests', $legacyTests);
$this->set('results', $results);
$this->set('enableAverage', $enableAverage);
$this->set('average_class', $average_class);
$this->set('average_all', $average_all);
