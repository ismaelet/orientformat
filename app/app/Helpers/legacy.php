<?php

use App\Models\User\Administrator;
use App\Models\User\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Legacy\UserSystem\ActiveStudent;
use \Legacy\Activity\Test as LegacyTest;

function student() {
	return is_teacher() ? teacher() : ActiveStudent::getInstance();
}

function administrator() {
	return Auth::check() ? Administrator::where('user_id', Auth::id())->first() : false;
}

function userId() {
	if (Auth::id()) {
		\App\Legacy\ActiveUser::getInstance()->setId(Auth::id());
	}

	return \App\Legacy\ActiveUser::getInstance()->id;
}

function client_url(string $parcialUrl = '') {
	return '/' . env('APP_SUBDOMAIN') . $parcialUrl;
}

function server_path(string $relativePath): string {
	return base_path() . '/legacy' . $relativePath;
}

function sort_subvalue(&$array, $key) {
	usort($array, function ($a, $b) use ($key) {
		return strcmp($a[$key], $b[$key]);
	});
}

function server_root() {
	return base_path() . '/legacy';
}

function camel_case_to_kebab_case(string $string): string {
	$result = preg_replace_callback('/[A-Z]/', function ($matches) {
		return '-' . strtolower($matches[0]);
	}, $string);

	return ltrim($result, '-');
}

function test_config($testId, $field) {
	global $testsConfig;

	include_once(base_path() . '/legacy/app/config/tests.php');

	return $testsConfig[$testId][$field] ?? false;
}

function section_config($sectionId, $field) {
	global $sectionsConfig;

	include_once(base_path() . '/legacy/app/config/sections.php');

	if (isset($sectionsConfig[$sectionId][$field])) {
		$value = $sectionsConfig[$sectionId][$field];
	} else {
		switch ($field) {
			case 'tiers':
				$value = ['Molto basso', 'Basso', 'Normale', 'Alto', 'Molto alto'];
				break;
			default:
				$value = false;
				break;
		}
	}

	return $value;
}

function percent($currentVal, $maxVal) {
	return $maxVal ? round($currentVal / $maxVal * 100) : 0;
}


function rows_to_objects(\App\Legacy\Query_Result $rows = null, string $className) {
	$objects = [];

	while ($row = $rows->fetch_assoc()) {
		$objects[] = new $className($row[$className::INDEX]);
	}

	return $objects;
}

function test(): ?LegacyTest {
	return new LegacyTest(request()->route('test')?->id);
}

function testId() {
	return test()->id;
}

function legacy_explode_last($separator, $string) {
	$array = explode($separator, $string);
	return end($array);
}

function background_image($img) {
	return 'style="background-image: url(' . client_path($img) . ');"';
}

function client_path(?string $file = '') {
	$url = asset('' . file_time(generate_base_url($file)));

	return $url;
}

function file_time($file, bool $publicRoot = false) {
	$root = base_path() . '/public';

	if (!strpos($file, '?=') && file_exists($url = $root . $file)) {
		$file .= '?=' . filemtime($url);
	}

	return $file;
}

function generate_base_url(?string $file = '') {
	if (!strpos($file, '.')) {
		$file .= '.webp';
	}

	if ($file[0] == '/') {
		$url = $file;
	} else {
		$url = assets_directory(\App\Legacy\LegacyView::getInstance()->url) . $file;
	}

	return '/legacy' . $url;
}

function assets_directory(string $pagePath = null) {
	$path = null;

	if ($pagePath) {
		$path = substr($pagePath, strpos($pagePath, 'pages') - 1);
		$path = str_replace(['/views/', '.php'], ['/assets/', '/'], $path);
	}

	return $path;
}

function redirect_old($path = false) {
	if (empty($path)) {
		$url = $_SERVER['REQUEST_URI'];
	} else if ($path[0] == '?') {
		$url = explode('?', $_SERVER['REQUEST_URI'])[0] . $path;
	} else if ($path[0] == '#') {
		$url = explode('#', $_SERVER['REQUEST_URI'])[0] . $path;
	} else if ($path[0] == '&') {
		$url = $_SERVER['REQUEST_URI'] . $path;
	} else if ($path[0] == '/') {
		$url = client_url($path);
	} else {
		$url = $path;
	}

	\App\Legacy\ConnectionInterface::getInstance()->close();

	header('Location: ' . $url);

	exit();
}

/**
 * CSV download
 */
function download_csv($array, $title, $separator = ',', $download = true) {

	function generate_csv(array &$array, $separator) {

		if (!count($array)) return null;

		ob_start();

		$df = fopen("php://output", 'w');
		fputs($df, "\xEF\xBB\xBF");
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

function embed_icon($icon): string {
	$iconPath = base_path() . '/resources/svg/icons/' . $icon . '.svg';

	if (file_exists($iconPath)) {
		return str_replace('<svg ', '<svg class="icon-embed"', file_get_contents($iconPath));
	}

	Log::error("Icon file not found: {$iconPath}");

	return '';
}

function is_teacher_or_administrator(): bool {
	return is_teacher() || is_administrator();
}

function watchedStudentId() {
	return request()->student_id ?? \Illuminate\Support\Facades\Auth::id();
}

function isSupervisor() {
	return watchedStudentId() != \Illuminate\Support\Facades\Auth::id();
}

function get_grade_style() {
	if (isSupervisor()) {
		return watchedStudent()->isInMiddleSchool ? 'middleschool' : 'highschool';
	}

	if (is_teacher_or_administrator()) {
		return 'highschool';
	}

	if (is_student()) {
		return student()->isInMiddleSchool ? 'middleschool' : 'highschool';
	}
}

function hypens_to_camel_case(string $string, bool $capitalizeFirstCharacter = false) {
	$string = str_replace('-', '', ucwords($string, '-'));

	if (!$capitalizeFirstCharacter) {
		$string = lcfirst($string);
	}

	return $string;
}

function bump(&$array) {
	array_unshift($array, '');
	unset($array[0]);
}

function watchedStudent(): Student {
	if (!isSupervisor() || !is_teacher_or_administrator()) {
		return student();
	}

	teacher()->load('school_classes.students');

	if (is_teacher() && !in_array(watchedStudentId(), teacher()->studentIds())) {
		return student();
	}

	if (is_administrator() && !in_array(watchedStudentId(), administrator()->studentIds())) {
		return student();
	}

	return Student::find(watchedStudentId()) ?? student();
}


function snippet_binary_icon($value) {
	if ($value) {
		$snippet = '<div class="binary-icon binary-icon_yes">';
		$snippet .= embed_icon('correct');
	} else {
		$snippet = '<div class="binary-icon binary-icon_no">';
		$snippet .= embed_icon('close');
	}

	$snippet .= '</div>';

	return $snippet;
}
