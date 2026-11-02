<?php

use App\Legacy\LegacyDB;
use Illuminate\Support\Facades\Auth;

$legacyTest = legacy_test();

$count = 20;

$groups = [];

for ($i = 1; $i <= 4; $i++) {
    $groups[] = __('tests.24-group-'.$i);
}

$results = LegacyDB::find('result FROM results_others WHERE userID = ? AND testID = ?', [watchedStudentId(), $legacyTest->id]);

if ($results) {
    $results = explode(',', $results);
}

Legacy\LogicManager\TestLogic::setParameterCount($count)
    ->setTestSubmitFunction(function () {
        $results = implode(',', $_POST['field_other']);

        LegacyDB::delete('results_others WHERE userID = ? AND testID = ?', [Auth::id(), testId()]);
        LegacyDB::add('results_others (userID, testID, result)', [Auth::id(), testId(), $results]);

        return 100;
    });
