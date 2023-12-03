<?php

function explode_and_pop($separator, $string) {
	$array = explode($separator, $string);
	return end($array);
}

function sort_subvalue(&$array, $key) {
	usort($array, function ($a, $b) use ($key) {
		return strcmp($a[$key], $b[$key]);
	});
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

function explode_last($separator, $string) {
	$array = explode($separator, $string);
	return end($array);
}

function bump(&$array) {
	array_unshift($array, '');
	unset($array[0]);
}

function array_to_sql($array) {
	$sqlArray = is_array($array) ? "'" . implode("','", $array) . "'" : '';
	return $sqlArray;
}

function rows_to_objects(Query_Result $rows = null, string $className) {
	$objects = [];

	while ($row = $rows->fetch_assoc()) {
		$objects[] = new $className($row[$className::INDEX]);
	}

	return $objects;
}

function debug($array) {
	print('<pre>' . print_r($array, true) . '</pre>');
}
