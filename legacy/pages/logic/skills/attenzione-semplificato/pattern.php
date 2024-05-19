<?php

use LogicManager\TestLogic;

$pattern = 'FZB';

$letters = 'VFZOHNIKLFZDSFEJSFZBGAVQCBFWQRFZBTEJZSPXDZTAFZBEWUDGLFZBFPFZFZBKGLRFZKMBXIOWFZBHYJFZBPCYFATSAFZWVIFEHOXQDFZGLSCAGNHNGSOCFZYLFJDBFZBZHBVFZWFEIJSWEQUFZBXUFWRSDVLFZBRPBTRVAFZMKTYFZBAQXSXCGUVNFZBCIKFZVFOTPDFZBFUDFZYLSHGPHFZBUHOFZJLIRFQZTNAIGMKGYJGSKYFZBOBSOSEWXNSKFZBPQPCQIBCVFZFTWMJAFDHFZBOFZOUXDEWFZBP';

$count = substr_count($letters, $pattern);
$letters = str_replace($pattern, '<span class="is-pattern js-pattern">FZ<span>B</span></span>', $letters);

Test\Legacy\System\Classes\Logic::setParameterCount($count)
	->setTestSubmitFunction(function ($count) {
		$score = $_POST['field'][0];

		return round($score / $count * 100);
	});
