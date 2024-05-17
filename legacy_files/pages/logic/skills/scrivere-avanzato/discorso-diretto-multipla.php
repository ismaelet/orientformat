<?php

use LogicManager\TestLogic;

$sentences = [
	[
		'original' => "Jonathan disse: “La storia è questa. Che ne pensate?”",
		'choices' => [
			"Jonathan disse che la storia è questa e chiese che cosa ne pensano.",
			"Jonathan disse che la storia era quella e che cosa ne pensassero.",
			"Jonathan disse che la storia era quella e chiese che cosa ne pensassero."
		]
	],
	[
		'original' => "Fred, rivolto a Jonathan, disse: “Io metto a disposizione il mio peschereccio”",
		'choices' => [
			"Fred disse che aveva messo a disposizione il suo peschereccio.",
			"Fred disse che metteva a disposizione il suo peschereccio.",
			"Fred disse che metteva a disposizione il mio peschereccio."
		]
	],
	[
		'original' => "Tom pensò: “Non si può abbandonare un vecchio amico!”",
		'choices' => [
			"Tom pensò che non si può abbandonare un vecchio amico.",
			"Tom pensò che non si era potuto abbandonare un vecchio amico.",
			"Tom pensò che non si poteva abbandonare un vecchio amico."
		]
	],
	[
		'original' => "L’oste chiese: “Va bene così o serve altro?”",
		'choices' => [
			"L’oste chiese se va bene così o serve altro.",
			"L’oste chiese se andasse bene così o servisse altro.",
			"L’oste chiese se sarebbe andato bene così o sarebbe servito altro."
		]
	],
];

$correctAnswers = [3, 2, 3, 2];

TestLogic::setParameterCount(count($sentences))
	::setTestSubmitFunction(function ($count) {
		$correctAnswers = ViewOld::get('correctAnswers');
		$correctAnswerCount = 0;

		foreach ($correctAnswers as $answerKey => $correctAnswer) {
			$answer = $_POST['field-' . $answerKey];

			if ($answer == $correctAnswer) {
				$correctAnswerCount++;
			}

			$_POST['field'][] = $answer;
		}

		return round($correctAnswerCount / $count * 100);
	});
