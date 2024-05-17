<?php

use Review\Review;

$debugger = false;
$reviewId = $_GET['id'] ?? 1;
$review = new Review($reviewId);

// save results
if (!empty($_POST)) {

	$results = [];

	foreach ($_POST as $questionSlug => $questionValue) {
		$results[] = $questionSlug . '=' . str_replace(['=', "'"], '', $questionValue);
	}

	$results = implode(',', $results);

	\System\Classes\DBOld::delete('review_results WHERE studentId = ? AND reviewId = ?', [userId(), $review->id]);
	\System\Classes\DBOld::add('review_results (studentId, reviewId, results)', [userId(), $review->id, $results]);

	redirect_old();
}
