<?php

$legacyTest = legacy_test();
$sibling = $legacyTest->requiredTest;

$questions = [
    [__('surveys.104'), 1],
    [__('surveys.105'), 1],
    [__('surveys.106'), 1],
    [__('surveys.107'), 2],
    [__('surveys.108'), 2],
    [__('surveys.109'), 2],
    [__('surveys.110'), 3],
    [__('surveys.111'), 3],
    [__('surveys.112'), 1],
    [__('surveys.113'), 2],
    [__('surveys.114'), 4],
    [__('surveys.115'), 4],
    [__('surveys.116'), 3],
    [__('surveys.117'), 3],
    [__('surveys.118'), 4],
    [__('surveys.119'), 4],
    [__('surveys.120'), 5],
    [__('surveys.121'), 5],
    [__('surveys.122'), 6],
    [__('surveys.123'), 6],
    [__('surveys.124'), 5],
    [__('surveys.125'), 5],
    [__('surveys.126'), 7],
    [__('surveys.127'), 8],
    [__('surveys.128'), 6],
    [__('surveys.129'), 6],
    [__('surveys.130'), 7],
    [__('surveys.131'), 7],
    [__('surveys.132'), 7],
    [__('surveys.133'), 8],
    [__('surveys.134'), 8],
    [__('surveys.135'), 8],
];

$titles = [
    [__('tests.20-area-1'), 'top'],
    [__('tests.20-area-2'), 'top'],
    [__('tests.20-area-3'), 'lef'],
    [__('tests.20-area-4'), 'rig'],
    [__('tests.20-area-5'), 'lef'],
    [__('tests.20-area-6'), 'rig'],
    [__('tests.20-area-7'), 'bot'],
    [__('tests.20-area-8'), 'bot'],

    [__('tests.20-area-9'), 'top'],
    [__('tests.20-area-10'), 'lef'],
    [__('tests.20-area-11'), 'rig'],
    [__('tests.20-area-12'), 'bot'],
];

bump($titles);

$boxes = false;

// calculate results
if ($sibling->completed) {

    $boxes = [];

    foreach ($questions as $key => $question) {

        $box = [];

        $box['question'] = $question[0];
        $box['group'] = $question[1];
        $box['result'] = $sibling->rawResults[$key];

        $boxes[$key + 1] = $box;
    }
}
