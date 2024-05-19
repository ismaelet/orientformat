<?php

use Illuminate\Support\Facades\Auth;

// parse colors
function parse_rgba($hex, $alpha = 1) {
	$rgba = [];
	$hex = str_replace('#', '', $hex);

	for ($i = 0; $i < 3; $i++) $rgba[] = hexdec(substr($hex, $i * 2, 2));

	$rgba[] = $alpha;

	return $rgba;
}

/**
 * User functions
 */
function user() {
	if (Auth::id()) {
		\Legacy\System\Classes\ActiveUser::getInstance()->setId(Auth::id());
	}

	return \Legacy\System\Classes\ActiveUser::getInstance();
}

function userId() {
	if (Auth::id()) {
		\Legacy\System\Classes\ActiveUser::getInstance()->setId(Auth::id());
	}

	return \Legacy\System\Classes\ActiveUser::getInstance()->id;
}

function logged() {
	return Auth::check();
}

function guest() {
	return !logged();
}

function admin() {
	return \Legacy\System\Classes\ActiveUser::getInstance()->isAdmin;
}

function manager() {
	return \Legacy\System\Classes\ActiveUser::getInstance()->isManager;
}

/**
 * CSV download
 */
function download_csv($array, $title, $separator = ',', $download = true) {

	function generate_csv(array &$array, $separator) {

		if (!count($array)) return null;

		ob_start();

		$df = fopen("php://output", 'w');
		fputcsv($df, array_keys(reset($array)), $separator);
		foreach ($array as $row) fputcsv($df, $row, $separator);

		fclose($df);

		return ob_get_clean();
	}

	function send_headers($filename, $download) {

		// disable caching
		$now = gmdate("D, d M Y H:i:s");
		header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
		header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
		header("Last-Modified: {$now} GMT");

		// force download
		if ($download) {
			header("Content-Type: application/force-download");
			header("Content-Type: application/octet-stream");
			header("Content-Type: application/download");
		}

		// disposition / encoding on response body
		header("Content-Disposition: attachment;filename={$filename}");
		header("Content-Transfer-Encoding: binary");
	}

	send_headers($title . '.csv', $download);
	echo generate_csv($array, $separator);
	die();
}
