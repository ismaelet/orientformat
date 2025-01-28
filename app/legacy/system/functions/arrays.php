<?php

function explode_and_pop($separator, $string) {
	$array = explode($separator, $string);
	return end($array);
}

function sort_subvalue_desc(&$array, $key) {
	usort($array, function ($a, $b) use ($key) {
		if (is_numeric($a[$key]) && is_numeric($b[$key])) {
			return $b[$key] > $a[$key] ? 1 : -1;
		} else {
			return strcmp($b[$key], $a[$key]);
		}
	});
}

function extract_subvalue(array $array, $subKey) {
	foreach ($array as $key => $values) {
		$array[$key] = $values[$subKey];
	}

	return $array;
}

function bump(&$array) {
	array_unshift($array, '');
	unset($array[0]);
}

function array_to_sql($array) {
	$sqlArray = is_array($array) ? "'" . implode("','", $array) . "'" : '';
	return $sqlArray;
}
