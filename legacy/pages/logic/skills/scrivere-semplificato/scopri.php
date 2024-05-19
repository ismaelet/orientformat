<?php

use LogicManager\TestLogic;

$text = [
	"Io pen",
	["z", "s", 1],
	"o ",
	["(e credo)", "", 3],
	" che la donna ",
	["deve", "debba", 4],
	" essere uguale ",
	["a l'", "all'", 1],
	"uomo, perché non è giusto che non ",
	["è", "sia", 4],
	" uguale. L'8 Marzo la donna deve essere uguale all'uomo! In quel giorno tutti gli uomini portano le mimose alle donne e anche agli altri uomini, però io conosco un uomo che l'8 Marzo a una donna ",
	["gli", "le", 3],
	" diede un calcio. ",
	["Melo", "Me lo", 1],
	" ha raccontato mio padre.<br>",
	"Mio padre ",
	["porta", "conduce", 3],
	" i tram adesso, ma una volta faceva il pompiere. Allora accadde che una donna ",
	["dell", "l'", 3],
	"8 Marzo si voleva buttare giù dal te",
	["r", "rr", 1],
	"a",
	["z", "zz", 1],
	"o", " e chiamarono i pompieri. Mio padre era quello che saliva sulle case per non fare gettare la gente dai palazzi. Lui salì, e quando si trovò faccia a faccia con la pazza ",
	["gli", "le", 3],
	" disse: «Ma tu perché ti vuoi buttare per farci passare un guaio a noi?». Allora quella un poco ",
	["s", "c", 1],
	"i pen",
	["z", "s", 1],
	"ò ancora se si voleva buttare o ritornare nel salotto, e pen",
	["z", "s", 1],
	"ò di buttarsi. Ma anche mio padre si buttò su di lei e la prese. Quando scesero giù, un amico di mio padre, che era pompiere (ma giù) diede un calcio alla pazza per la paura che s'era preso. Io se ",
	["ero", "fossi stato", 4],
	" quel signore il calcio non glielo ",
	["davo", "avrei dato", 4],
	" quel giorno ch'era l'8 Marzo, un altro giorno sì."
];

$count = 0;

foreach ($text as $textPart) {
	if (is_array($textPart)) {
		$count++;
	}
}

Test\Legacy\System\Classes\Logic::setParameterCount($count)
	->setTestSubmitFunction(function ($count) {
		$score = 0;

		foreach ($_POST['field'] as $result) {
			if ($result) {
				$score++;
			}
		}

		return round($score / $count * 100);
	});
