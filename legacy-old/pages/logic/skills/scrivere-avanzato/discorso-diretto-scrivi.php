<?php

use LogicManager\TestLogic;

$sentences = [
	['Jonathan pensò che quelli erano davvero dei grandi amici.', 'Jonathan pensò'],
	['Tom disse che lui avrebbe provveduto ai rifornimenti di cibo.', 'Tom disse'],
	['Fred pensò a che cosa avrebbe raccontato a sua moglie.', 'Fred pensò'],
	['L’annunciatore radiofonico comunicò che stavano per trasmettere le ultime	informazioni metereologiche.', 'L’annunciatore radiofonico comunicò'],
	['L’ oste disse che per quella sera la radio prevedeva nebbia.', 'L’ oste disse'],
];

$correctAnswers = [
	"Questi sono davvero dei grandi amici",
	"Provvederò io ai rifornimenti di cibo",
	"Che cosa racconterò a mia moglie?",
	"Stiamo per trasmettere le ultime informazioni meteorologiche",
	"Per questa sera la radio prevede nebbia",
];

TestLogic::setParameterCount(count($correctAnswers))
	::setTestSubmitFunction(function ($count) {
		$correctCount = 0;
		$correctAnswers = View::get('correctAnswers');

		foreach ($_POST['field'] as $answerKey => $answer) {
			if (strtolower($answer) == strtolower($correctAnswers[$answerKey])) {
				$correctCount++;
			}
		}

		return round($correctCount / $count * 100);
	});
