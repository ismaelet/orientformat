<?php

use App\Models\Activities\Section;
use App\Models\Activities\Test;
use App\Models\User\Administrator;
use App\Models\User\Student;
use App\Models\User\Teacher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Legacy\UserSystem\ActiveStudent;
use \Legacy\Activity\Test as LegacyTest;

function legacy_student() {
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
		return watchedlegacy_student()->isInMiddleSchool ? 'middleschool' : 'highschool';
	}

	if (is_teacher_or_administrator()) {
		return 'highschool';
	}

	if (is_student()) {
		return legacy_student()->isInMiddleSchool ? 'middleschool' : 'highschool';
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

function watchedlegacy_student(): Student|Teacher {
	if (!isSupervisor() || !is_teacher_or_administrator()) {
		return legacy_student();
	}

	teacher()->load('school_classes.students');

	if (is_teacher() && !in_array(watchedStudentId(), teacher()->studentIds())) {
		return legacy_student();
	}

	if (is_administrator() && !in_array(watchedStudentId(), administrator()->studentIds())) {
		return legacy_student();
	}

	return Student::find(watchedStudentId()) ?? legacy_student();
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

function sort_subvalue_desc(&$array, $key) {
	usort($array, function ($a, $b) use ($key) {
		if (is_numeric($a[$key]) && is_numeric($b[$key])) {
			return $b[$key] > $a[$key] ? 1 : -1;
		} else {
			return strcmp($b[$key], $a[$key]);
		}
	});
}


function title(?string $title = null, ?string $description = null) {
	$legacyTest = test();
	$title = $title ?: $legacyTest->title;
	$description = $description ?: $legacyTest->description;

	ob_start();
?>

	<section class="test__title-block">
		<p class="test__counter colored-title"><?= __('misc.section-progress', ['step' => $legacyTest->step, 'total' => $legacyTest->section->testCount]) ?></p>
		<h1 class="section-title colored-title"><?= $title ?></h1>
		<p class="test__description subsection-subtitle"><?= nl2br($description) ?></p>
	</section>

<?php

	return ob_get_clean();
}

function test_description(): string {
	return test()->description;
}

function submit(bool $progressiveButton = false) {
	$legacyTest = test();
	$section = Section::find($legacyTest->sectionId);
	$from = request()->query('from');

	if ($from) {
		$fromTest = Test::where('slug', $from)->first();
	}

	switch (true) {
		// supervisor view
		case $from:
			$label = __('Ritorna alle autovalutazioni');
			$name = null;
			break;

		// supervisor view
		case isSupervisor():
			$label = __('Return to the list of results');
			$name = null;
			break;

		// completed test and section
		case $legacyTest->completed && $legacyTest->section->completed:
			$label = __('Return to the summary');
			$name = null;
			break;

		// test that requires review
		case $legacyTest->reviewResult && !$legacyTest->completed:
			$label = __('Check your answer');
			$name = 'review';
			break;

		// uncompleted test, completed section
		case $legacyTest->section->completed:
			$label = __('Save the new result');
			$name = 'submit';
			break;

		// default button
		default:
			$label = __('Proceed');
			$name = 'submit';
	}

	ob_start();
?>

	<?php switch (true) {

		// supervisor go back button
		case $from && isSupervisor(): ?>

			<div class="fa-center">
				<a class="button button--secondary button--full-width js-submit-button" href="<?= route('class.students.autovalutazioni.show', ['class' => watchedlegacy_student()->school_class, 'student' => watchedlegacy_student()]) ?>"><?= $label ?></a>
			</div>

		<?php break;

		// supervisor go back button
		case $from: ?>

			<div class="fa-center">
				<a class="button button--secondary button--full-width js-submit-button" href="<?= $fromTest->url() ?>"><?= $label ?></a>
			</div>

		<?php break;

		// supervisor go back button
		case isSupervisor(): ?>

			<div class="fa-center">
				<a class="button button--secondary button--full-width js-submit-button" href="<?= route('class.students.results.show', ['class' => watchedlegacy_student()->school_class, 'student' => watchedlegacy_student()]) ?>"><?= $label ?></a>
			</div>

		<?php break;

		// go back button
		case $legacyTest->completed && $legacyTest->section->completed: ?>

			<div class="fa-center">
				<a class="button button--secondary button--full-width js-submit-button" href="<?= $section->url() ?>"><?= $label ?></a>
			</div>

		<?php break;

		// progressive button
		case $progressiveButton && !test()->completed: ?>

			<button type="submit" class="button button--filling button--full-width js-submit-button js-progressive-submit-button" name="<?= $name ?>" disabled><?= $label ?></button>

		<?php break;

		// normal button
		default: ?>

			<button type="submit" class="button button--full-width js-submit-button" name="<?= $name ?>"><?= $label ?></button>

		<?php break;
	}

	return ob_get_clean();
}

function skip() {
	$legacyTest = test();

	if (!$legacyTest->completed && !isSupervisor()) { ?>

		<button type="submit" name="skip" class="skip interactive" formnovalidate>
			<?= $legacyTest->everCompleted ? __('Continue at another time') : __('Skip this activity and resume it later') ?>
		</button>

	<?php }
}

function no_results() {
	$legacyTest = test();

	ob_start();

	if ((!$legacyTest->completed && !$legacyTest->hasRequiredTest && isSupervisor()) || ($legacyTest->hasRequiredTest && !$legacyTest->requiredTest->completed)) { ?>

		<div class="no-results mar-v-2">

			<?php if (isSupervisor()) { ?>

				<?php if ($legacyTest->hasRequiredTest) { ?>
					<p>Lo studente non ha ancora completato l'attività precedente, necessaria per mostrare i dati di questa pagina, oppure ha deciso di azzerare i propri risultati per ripeterla più tardi. Potrai tornare qui quando avrà completato l'attività per esaminare i risultati.</p>
				<?php  } else { ?>
					<p>Lo studente non ha ancora completato questa attività, oppure ha deciso di azzerare i propri risultati per ripetere l'attività più tardi. Potrai tornare qui quando l'avrà completata per esaminare i risultati.</p>
				<?php } ?>

			<?php } else { ?>

				<p><?= __('misc.required-test-warning', ['url' => $legacyTest->requiredTest->clientUrl]) ?></p>

			<?php } ?>

		</div>

	<?php

	}

	return ob_get_clean();
}

function renderRedoButton(bool $fullWith = true) {
	ob_start();

	if (test()->completed && test()->percentage != 100 && !isSupervisor()) { ?>

		<button type="submit" class="button button--secondary <?= $fullWith ? 'button--full-width' : '' ?>" name="redo" value="<?= testId() ?>"><?= __('Try again') ?></button>

	<?php }

	return ob_get_clean();
}

function renderSaveButton(bool $fullWith = false) {
	ob_start();

	if (test()->completed && !isSupervisor()) { ?>

		<button type="submit" class="button <?= $fullWith ? 'button--full-width' : '' ?>" name="submit"><?= __('Save changes') ?></button>

<?php }

	return ob_get_clean();
}

function extract_subvalue(array $array, $subKey) {
	foreach ($array as $key => $values) {
		$array[$key] = $values[$subKey];
	}

	return $array;
}
