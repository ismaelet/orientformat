<?php

use App\Models\Results\User\AdditionalResult;
use Illuminate\Support\Facades\Auth;

$count = 1;
$legacyTest = legacy_test();
$branchResults = $legacyTest->additionalPrimaryResult ?: null;
$fruitsResults = $legacyTest->additionalSecondaryResult ?: null;

if ($branchResults) {
    bump($branchResults);
}

if ($fruitsResults) {
    bump($fruitsResults);
}

\Legacy\LogicManager\TestLogic::setParameterCount($count)
    ->setTestSubmitFunction(
        function () {
            $branches = implode(',', $_POST['branch']);
            $fruits = implode(',', $_POST['fruit']);

            AdditionalResult::updateOrCreate(
                [
                    'studentId' => Auth::id(),
                    'testId' => testId(),
                ],
                [
                    'primaryResults' => $branches,
                    'secondaryResults' => $fruits,
                ]
            );

            return 100;
        }
    );
