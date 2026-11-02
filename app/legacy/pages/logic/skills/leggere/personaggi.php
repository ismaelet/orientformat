<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Legacy\LogicManager\TestLogic;

$legacyTest = legacy_test();

$colors = ['c4', 'c1', 'c5', 'c2'];

$questions = [];

for ($i = 1; $i <= 12; $i++) {
    $question = [
        'text' => __('tests.71-text-'.$i),
        'answers' => [],
        'emotions' => [],
    ];

    for ($k = 1; $k <= 4; $k++) {
        $question['answers'][] = __('tests.71-answer-'.$i.'-'.$k);
    }

    for ($k = 1; $k <= 3; $k++) {
        $question['emotions'][] = __('tests.71-emotion-'.$i.'-'.$k);
    }

    $questions[] = $question;
}

$answers = [2, 4, 3, 2, 1, 2, 1, 2, 1, 2, 2, 4];
$answers_emotions = [
    [2],
    [3],
    [1],
    [2],
    [2, 4],
    [1, 4],
    [1, 3],
    [1],
    [1],
    [1, 4],
    [2, 3],
    [2, 3],
];

$results_emotions = explode(',', DB::scalar('SELECT '.('result FROM results_others WHERE userID = ? AND testID = ?').' LIMIT 1', (array) ([Auth::id(), $legacyTest->id])) ?? false);

$count = count($questions) * 2;

bump($questions);

TestLogic::setParameterCount($count)
    ->setTestSubmitFunction(function ($count) {
        $rightN = 0;
        $viewData = legacy_view_data();
        $answers = $viewData['answers'] ?? null;
        $answers_emotions = $viewData['answers_emotions'] ?? null;

        $results = implode(',', $_POST['field_other']);

        DB::delete('DELETE FROM '.('results_others WHERE userID = ? AND testID = ?'), (array) ([Auth::id(), testId()]));
        DB::insert('INSERT INTO '.('results_others (userID, testID, result) VALUES (?, ?, ?)'), (array) ([Auth::id(), testId(), $results]));

        if (! empty($_POST['field'])) {
            foreach ($_POST['field'] as $key => $field) {
                if ($field == $answers[$key]) {
                    $rightN++;
                }
            }
        }

        if (! empty($_POST['field_other'])) {
            foreach ($_POST['field_other'] as $key => $field) {
                $valid = true;
                $values = explode('+', $field);
                $emotions = $answers_emotions[$key];

                foreach ($values as $val) {
                    if (! in_array($val, $emotions)) {
                        $valid = false;
                    }
                }

                foreach ($emotions as $emotion) {
                    if (! in_array($emotion, $values)) {
                        $valid = false;
                    }
                }

                if ($valid) {
                    $rightN++;
                }
            }
        }

        return round($rightN / $count * 100);
    });
