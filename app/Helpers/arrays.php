<?php

/**
 * Extract the content of a markup from an html string
 */
function extract_markup(string $markup, string $content): string {
	if (strpos($content, '<' . $markup . '>') !== false) {
		return explode('</' . $markup . '>', explode('<' . $markup . '>', $content, 2)[1], 2)[0];
	} else {
		return null;
	}
}

/**
 * Condense a variable number of arrays, to avoid using the spread operator in PHP < 7.4
 */
function condense_array(array ...$arrays): array {
	$result = [];

	foreach ($arrays as $array) {
		$result = array_merge($result, $array);
	}

	return $result;
}
