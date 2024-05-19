<?php

$categoryId = $_GET['category'] ?? null;
$topicId = $_GET['topic'] ?? null;
$topicText = '';

// fetch categories
$categories = \Legacy\System\Classes\LegacyDB::select('* FROM support_categories ORDER BY id ASC');

// fetch topics
if ($categoryId) {
	$categoryData = \Legacy\System\Classes\LegacyDB::row('* FROM support_categories WHERE id = ?', [$categoryId]);
	$topics = \Legacy\System\Classes\LegacyDB::select('* FROM support_topics WHERE categoryId = ? ORDER BY id ASC', [$categoryId]);
}

function _fill_text($text, $topicId) {
	// place counters
	$counterId = 0;

	while (strpos($text, $needle = '{{ counter }}') !== false) {
		$counterId++;

		$text = preg_replace('/' . $needle . '/', '<br><strong>' . $counterId . '.</strong> ', $text, 1);
	}

	// place quotes
	while (strpos($text, $needle = '{q ') !== false) {
		$text = preg_replace('/' . $needle . '/', '"<strong>', $text, 1);
	}

	while (strpos($text, $needle = ' q}') !== false) {
		$text = preg_replace('/' . $needle . '/', '</strong>"', $text, 1);
	}

	// place images
	$imgId = 0;

	while (strpos($text, $needle = '{{ img }}') !== false) {
		$imgId++;

		$text = preg_replace('/' . $needle . '/', '<br><br><img class="topic_img js-open-modal" src="' . client_path($topicId . '-' . $imgId . '.jpg') . '" loading="lazy" data-target="img-modal"><br>', $text, 1);
	}

	return $text;
}
