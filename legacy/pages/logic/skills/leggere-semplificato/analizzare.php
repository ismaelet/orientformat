<?php

use LogicManager\TestLogic;

$text = [
	['Esemplare ', 0],
	['la fedeltà coniugale degli albatri', 'argomento'],
	[', i grandi uccelli che veleggiano ad ali spiegate soprattutto ', 0],
	['nelle regioni subantartiche.', 'dove'],
	[' E se ne comprende facilmente il motivo. Il loro uovo, uno solo, che pesa circa mezzo chilo, richiede ', 0],
	["un periodo d'incubazione lunghissimo", 'causa'],
	[", il più lungo che si conosca nel mondo degli uccelli: circa 80 giorni. In questo periodo i genitori si danno il cambio una volta alla settimana. Mentre l'uno cova, l'altro vola in mare a rifocillarsi. Nel momento in cui l'uno arriva dall’oceano e l'altro sta per involarsi, avviene un breve intermezzo di carezze ", 0],
	["volto a rinforzare il legame di coppia.", 'scopo'],
	[" Si lisciano reciprocamente le penne e lanciano acute grida quasi per infondersi coraggio reciprocamente. \"Ci vuol pazienza. Abbiamo un figlio da allevare\". Quando, infine, il piccolo sguscia dall’uovo,", 0],
	["debbono passare ancora nove lunghi mesi prima che diventi autosufficiente", 'causa'],
	[". Nessun pulcino necessita di cure parentali così protratte nel tempo.<br>E non basta. Di regola gli albatri si riproducono ogni due anni. Ma", 0],
	["se per disgrazia l'uovo va distrutto o il piccolo muore, la coppia fa uno strappo alla regola e si riproduce", 'causa'],
	[" l'anno successivo. Così il tempo passa e ", 0],
	[" l'unione diventa permanente.", 'argomento'],
];

$results = test()->completed ? test()->rawResults : null;

$count = 7;

Test\Legacy\System\Classes\Logic::setParameterCount($count)
	->setTestSubmitFunction(
		function () {
			if (isset($_POST['skip-cbx'])) {
				return 0;
			} else {
				return 100;
			}
		}
	);
