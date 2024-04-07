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

$sentences = [
	'Si alza di buonumore{{selector}} con la testa leggera{{selector}} ha voglia di una colazione sostanziosa{{selector}}',
	'Però{{selector}} durante il giorno{{selector}} continuano a riaffiorare interrogativi{{selector}} che genere di monete erano quelle{{selector}}',
	'Il cane{{selector}} che lo vede assorto e distante{{selector}} vorrebbe dirgli{{selector}}  {{selector}}Andiamo a passeggiare{{selector}}{{selector}}',
	'Ora basta{{selector}} Prende una decisione{{selector}} domani andrà in paese{{selector}} parlerà con qualcuno{{selector}} chiederà consiglio{{selector}}',
	'E  già studiava la frase con cui sarebbe entrato in argomento{{selector}}  qualcosa come{{selector}} {{selector}}Sai{{selector}}  giusto stanotte{{selector}}{{selector}}',
	'L’uomo{{selector}} mentre si stiracchia e sbadiglia{{selector}} ride di sé stesso{{selector}} è incredibile come una sciocchezza lo abbia suggestionato{{selector}}',
	'Sulla pagina è scritto{{selector}}  {{selector}}Non possiamo decidere niente per ora{{selector}} quando e se torneremo a prenderlo{{selector}} tutto dipenderà da ciò che ci verrà offerto{{selector}}{{selector}}',
	'Il bambino notò allora che per terra{{selector}} in un angolo{{selector}} c’erano delle macchinine{{selector}} e da un’altra parte dei Lego{{selector}} allora la sua ospite aveva probabilmente un nipotino{{selector}}',
	'Presa  la decisione{{selector}}  anche se si sente  un po’ ridicolo{{selector}}  è più tranquillo  e  rimanda al giorno dopo  la decisione{{selector}}  pazienza  se gli diranno  che  è  un  ingenuo{{selector}}',
];

$correctAnswers = [1, 3, 2, 1, 1, 3, 7, 1, 1, 3, 8, 6, 9, 6, 3, 1, 1, 2, 1, 3, 8, 1, 5, 9, 1, 1, 3, 6, 3, 8, 4, 1, 9, 2, 1, 1, 1, 3, 6, 1, 1, 3, 6];
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
$sentencesHtml = [];
$placeholder = '{{selector}}';

foreach ($sentences as $sentence) {
	while (strpos($sentence, $placeholder) !== false) {
		$correctResult = test()->completed && test()->rawResults[$selectorKey] == $correctAnswers[$selectorKey];

		$selector = $selectors[$selectorKey];
		$selectorHtml = '<select class="js-field ' . (test()->completed ? ($correctResult ? 'right' : 'wrong') : null) . '" name="field[]" ' . (test()->completed || isSupervisor() ? 'disabled' : '') . '>' . $selector . '</select>';
		$position = strpos($sentence, $placeholder);
		$sentence = substr_replace($sentence, $selectorHtml, $position, strlen($placeholder));

		$selectorKey++;
	}

	$sentencesHtml[] = $sentence;
}

// submit
TestLogic::setParameterCount($count)
	->setTestSubmitFunction(function ($count) {
		$correctAnswers = View::get('correctAnswers');
		$correctAnswerCount = 0;

		foreach ($_POST['field'] as $answerKey => $answer) {
			if ($answer == $correctAnswers[$answerKey]) {
				$correctAnswerCount++;
			}
		}

		return ($correctAnswerCount / $count * 100);
	});
