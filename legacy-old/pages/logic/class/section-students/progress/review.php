<?php

use App\Models\Reviews\ReviewResult;

$reviewResultId = $_GET['id'] ?? null;
$reviewResult = ReviewResult::find((int) $reviewResultId);
$student = $reviewResult->student();

if ($student->schoolClassId != schoolClassId()) {
	redirect('/class/students/progress/list');
}

$parsedResults = $reviewResult->parseResults();
