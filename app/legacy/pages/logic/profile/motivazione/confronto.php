<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Legacy\LogicManager\TestLogic;

$legacyTest = legacy_test();

$count = 20;

$groups = [];

for ($i = 1; $i <= 4; $i++) {
    $groups[] = __('tests.24-group-'.$i);
}

$results = DB::scalar('SELECT '.('result FROM results_others WHERE userID = ? AND testID = ?').' LIMIT 1', (array) ([watchedStudentId(), $legacyTest->id])) ?? false;

if ($results) {
    $results = explode(',', $results);
}

TestLogic::setParameterCount($count)
    ->setTestSubmitFunction(function () {
        $results = implode(',', $_POST['field_other']);

        DB::delete('DELETE FROM '.('results_others WHERE userID = ? AND testID = ?'), (array) ([Auth::id(), testId()]));
        DB::insert('INSERT INTO '.(('results_others (userID, testID, result)'.' VALUES (?, ?, ?)')), (array) ([Auth::id(), testId(), $results]));

        return 100;
    });
