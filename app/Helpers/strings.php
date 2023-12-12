<?php

/**
 * Transforms a string from camelCase to kebab-case
 * 
 * @param string $string
 * @return string
 */
function camel_case_to_kebab_case(string $string): string {
	$result = preg_replace_callback('/[A-Z]/', function ($matches) {
		return '-' . strtolower($matches[0]);
	}, $string);

	return ltrim($result, '-');
}

/**
 * Transforms a string from camelCase to snake_case
 * 
 * @param string $string
 * @return string
 */
function camel_case_to_snake_case(string $string): string {
	$pattern = '/([a-z])([A-Z])/';
	$replacement = '$1_$2';

	$snakeCase = strtolower(preg_replace($pattern, $replacement, $string));

	return $snakeCase;
}
