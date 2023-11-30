<?php

use Review\Review;
use Student\Profile;

global $grade;

include_once(SERVER_ROOT . '/app/config/surveys.php');

$studentId = $_GET['id'];
$pageType = $_GET['type'];
$student = new UserSystem\Student($studentId);

if ($student->schoolClass->id != $grade->id) redirect('/class');

$profile = $pageType == 'start' ? $student->startingProfile : $student->endingProfile;

if ($profile->id) {
	$review = new Review($profile->reviewId);
	$results = $profile->results;
	$averages = Profile::getAverages();
}
