<?php

use LogicManager\TestLogic;

$punctuations = [
	1 => ',',
	2 => '.',
	3 => ':',
	4 => ';',
	5 => '...',
	6 => '!',
	7 => '?',
	8 => '«',
	9 => '»',
];

$text =
	'Francesca aveva gironzolato tutto il pomeriggio per casa senza riuscire ad impegnarsi in niente. Aveva fatto in fretta un po’ di compiti e poi si era stesa sul letto con un giornalino{{selector}} ma lo aveva sfogliato senza interesse. Era la fine di novembre e faceva buio presto. D’estate almeno stava fino a sera in cortile{{selector}} non era un granché{{selector}} senza un albero{{selector}} con tutte quelle finestre che ci si affacciavano{{selector}} senza un posto dove stare veramente in pace. Ma comunque all’aperto era meglio. In casa la mamma da un po’ di tempo era sempre nervosa{{selector}} andava di continuo intorno a pulire{{selector}} riordinare{{selector}} e ogni tanto{{selector}} proprio quando lei aveva appena iniziato un gioco o un libro interessante{{selector}} la chiamava con tono duro{{selector}} irritato{{selector}} e le chiedeva di aiutarla{{selector}} {{selector}}Invece di star lì a perdere tempo{{selector}} almeno facessi qualcosa per la scuola{{selector}} ormai sei grande{{selector}} e così via.';

$correctAnswers = [1, 3, 1, 1, 1, 4, 1, 1, 1, 1, 1, 1, 3, 8, 1, 1, 9];
$count = count($correctAnswers);

// options
$selectors = [];

for ($i = 1; $i <= $count; $i++) {
	$correctAnswer = $correctAnswers[$i - 1];
	$options = !test()->completed ? ['<option value="0" disabled selected></option>'] : [];

	foreach ($punctuations as $punctcuationKey => $punctcuation) {
		$result = test()->rawResults[$i - 1] ?? null;
		$selected = $result && $result == $punctcuationKey;
		$options[] = '<option value="' . $punctcuationKey . '" ' . ($selected ? 'selected' : null) . '>' . $punctcuation . '</option>';
	}

	$selectors[] = implode(PHP_EOL, $options);
}

// sentences
$selectorKey = 0;
$textHtml = $text;
$placeholder = '{{selector}}';

while (strpos($textHtml, $placeholder) !== false) {
	$correctResult = test()->completed && test()->rawResults[$selectorKey] == $correctAnswers[$selectorKey];

	$selector = $selectors[$selectorKey];
	$selectorHtml = '<select class="js-field ' . (test()->completed ? ($correctResult ? 'right' : 'wrong') : null) . '" name="field[]" ' . (test()->completed || isSupervisor() ? 'disabled' : '') . '>' . $selector . '</select>';
	$position = strpos($textHtml, $placeholder);
	$textHtml = substr_replace($textHtml, $selectorHtml, $position, strlen($placeholder));

	$selectorKey++;
}

// submit
\LogicManager\TestLogic::setParameterCount($count)
	->setTestSubmitFunction(function ($count) {
		$correctAnswers = \App\Legacy\LegacyView::get('correctAnswers');
		$correctAnswerCount = 0;

		foreach ($_POST['field'] as $answerKey => $answer) {
			if ($answer == $correctAnswers[$answerKey]) {
				$correctAnswerCount++;
			}
		}

		return ($correctAnswerCount / $count * 100);
	});
