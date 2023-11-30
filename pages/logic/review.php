<?php

use Review\Review;

$debugger = false;
$reviewId = $_GET['id'] ?? 1;
$review = new Review($reviewId);

if (!admin()) {
	$debugger = false;
}

// save results
if (!empty($_POST)) {

	$results = [];

	foreach ($_POST as $questionSlug => $questionValue) {
		$results[] = $questionSlug . '=' . str_replace(['=', "'"], '', $questionValue);
	}

	$results = implode(',', $results);

	DB::delete('review_results WHERE studentId = ? AND reviewId = ?', [userId(), $review->id]);
	DB::add('review_results (studentId, reviewId, results)', [userId(), $review->id, $results]);

	redirect();
}
