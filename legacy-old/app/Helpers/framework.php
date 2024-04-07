<?php

/**
 * Get an environment variable
 */
function env(string $variableName) {
	$variableName = strtoupper($variableName);


	if (isset($_ENV[$variableName])) {
		$value = $_ENV[$variableName];
		$value = $value === strtolower('true') ? true : $value;
		$value = $value === strtolower('false') ? false : $value;

		return $value;
	} else {
		return null;
	}
}

/**
 * Get a config parameter
 */
function config(string $request): string {
	$request = explode('.', $request, 2);
	$configFile = $request[0];
	$configParameter = $request[1];

	$configData = require(server_path('/config/' . $configFile . '.php'));

	return $configData[$configParameter] ?? null;
}

/**
 * Debug any type of content
 */
function debug($content): void {
	exit('<pre>' . print_r($content, true) . '</pre>');
}

/**
 * Debug any type of content, without stopping the script
 */
function soft_debug($content): void {
	print('<pre>' . print_r($content, true) . '</pre>');
}
