<?php

use Illuminate\Support\Facades\DB;
use Legacy\Activity\Test;

$legacyTest = legacy_test();

// setup variables
$results = [];

for ($i = 1; $i < $legacyTest->step; $i++) {

    $requiredTestId = DB::scalar('SELECT '.('id FROM '.Test::TABLE.' WHERE sectionId = ? AND step = ?').' LIMIT 1', (array) ([$legacyTest->sectionId, $i])) ?? false;

    $requiredTest = new Test($requiredTestId);
    $results[$i]['id'] = $requiredTest->id;
    $results[$i]['title'] = $requiredTest->title;
    $results[$i]['completed'] = $requiredTest->completed;
    $results[$i]['url'] = $requiredTest->clientUrl;
    $results[$i]['score'] = $requiredTest->completed ? ((int) $requiredTest->percentage).'%' : 'Da fare';
}
