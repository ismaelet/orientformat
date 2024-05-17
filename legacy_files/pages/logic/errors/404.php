<?php

// store error
$validEntry = true;
$url = $_SERVER['REQUEST_URI'] ?? false;
$src = $_SERVER['HTTP_REFERER'] ?? '';

$appExceptions = [];

if ($validEntry) {
	//error_log('Error 404: destination: ' . $url . ' source: ' . $src);
}
