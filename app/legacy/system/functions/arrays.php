<?php

function explode_and_pop($separator, $string) {
	$array = explode($separator, $string);
	return end($array);
}

function extract_subvalue(array $array, $subKey) {
	foreach ($array as $key => $values) {
		$array[$key] = $values[$subKey];
	}

	return $array;
}

function array_to_sql($array) {
	$sqlArray = is_array($array) ? "'" . implode("','", $array) . "'" : '';
	return $sqlArray;
}
