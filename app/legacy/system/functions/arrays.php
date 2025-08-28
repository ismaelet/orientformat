<?php

function explode_and_pop($separator, $string) {
	$array = explode($separator, $string);
	return end($array);
}

function array_to_sql($array) {
	$sqlArray = is_array($array) ? "'" . implode("','", $array) . "'" : '';
	return $sqlArray;
}
