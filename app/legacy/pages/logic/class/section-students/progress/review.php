<?php

use LegacyModels\Reviews\ReviewResult;

$reviewResultId = $_GET['id'] ?? null;
$reviewResult = ReviewResult::find((int) $reviewResultId);
$student = $reviewResult->legacy_student();

if ($student->schoolClassId != schoolClassId()) {
	redirect_old('/class/students/progress/list');
}

$parsedResults = $reviewResult->parseResults();
