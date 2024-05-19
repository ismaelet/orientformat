<?php

use LogicManager\TestLogic;

$legacyTest = test();

// results
$results = ['subantartiche', 'fedeltà', 'incubazione', 'carezze', 'legame', 'nove mesi', 'due anni'];

// text
$text = "L’albatro è un grande uccello che vive nelle regioni {inp}. È noto per la grande {inp} nei rapporti di coppia, che tuttavia ha una spiegazione naturale. La loro riproduzione infatti avviene attraverso un solo uovo, molto grosso, che richiede 80 giorni di {inp}, per cui i genitori si devono dare il cambio a covare. Mentre uno arriva e l’altro parte per andare a rifocillarsi, c’è un breve scambio di {inp}, che servono a rafforzare il loro {inp}. C’è un’altra ragione che spiega un legame così stabile: il piccolo uscito dall’uovo richiede infatti cure per {inp} prima che diventi autosufficiente. Se invece l’uovo viene distrutto o il piccolo muore, la riproduzione, che di solito avviene ogni {inp}, si ripete l’anno immediatamente successivo.<br>In questo modo la loro unione diviene permanente. 
";

$text = explode('{inp}', $text);

$count = count($text) - 1;

foreach ($text as $key => &$part) {
	if ($key) {
		if ($legacyTest->completed) {
			$inp = '<span class="text-inp fa-center ';
			$inp .= $legacyTest->rawResults[$key - 1] == $results[$key - 1] ? 'right' : 'wrong';
			$inp .= '">';
			$inp .=  $legacyTest->rawResults[$key - 1];
			$inp .= '</span>';
		} else {
			$inp = '<input type="text" class="inp text-inp filler-inp" name="field[]" value="';
			if ($legacyTest->result && isset($legacyTest->rawResults[$key - 1])) $inp .= $legacyTest->rawResults[$key - 1];
			$inp .= '" ' . (test()->completed || isSupervisor() ? 'readonly' : null) . '>';
		}

		$part = $inp . $part;
	}
}

$text = implode('', $text);

\LogicManager\TestLogic::setParameterCount($count)
	->setTestSubmitFunction(
		function ($count) {
			$results = \App\Legacy\LegacyView::getInstance()->get('results');
			$rightN = 0;

			foreach ($_POST['field'] as $key => $result) {
				if ($result == $results[$key]) {
					$rightN++;
				}
			}

			return round($rightN / $count * 100);
		}
	);
