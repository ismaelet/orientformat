<?php

// ini_set('error_log', 'logs/error.log');

if (in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'])) {
	define('DEBUG', false);
} else {
	define('DEBUG', false);
}

if (DEBUG) {
	ini_set('display_errors', '1');
	ini_set('display_startup_errors', '1');
	error_reporting(E_ALL ^ E_DEPRECATED);
}

require_once('system/setup/setup.php');
