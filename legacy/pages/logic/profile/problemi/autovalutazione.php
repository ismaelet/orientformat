<?php

use LogicManager\TestLogic;

$legacyTest = test();

$graph_data = $graph_data ?? [
	['Mi rendo conto del problema', "I problemi è più facile evitarli che affrontarli, per questo spesso nessuno ne parla. Tu come reagisci?"],
	['Ho chiaro l’obiettivo', "Risolvere un problema significa ottenere un risultato. Tu quanto hai chiaro l’obiettivo da ottenere? "],
	['Accetto la sfida', "Per farsi carico di un problema, occorre controllare l’ansia e la paura di non farcela. Tu quanto ci riesci?"],
	['Utilizzo le risorse', "Per raggiungere uno scopo bisogna disporre dei mezzi necessari. Ti chiedi se li hai oppure no?"],
	['Rispetto i vincoli', "Non si può «fare il passo più lungo della gamba». Bisogna conoscere i limiti di ciò che si può fare. E rispettarli."],
	['Reagisco alle difficoltà', "Quando incontro un problema non mi scoraggio: mi dico che ce la posso fare."],
	['So chiedere aiuto', "Non sempre da soli si riesce. Allora occorre saper chiedere l’aiuto di qualcuno. Tu quanto ne sei capace? "],
	['Prendo delle decisioni', "A volte si sa che cosa si dovrebbe fare, ma non si ha la voglia o la forza per decidersi a farlo."],
	['Agisco ', "Prendere delle decisioni è necessario, ma non basta. Bisogna poi anche metterle in pratica. Quanto lo fai?"],
];

$count = count($graph_data);

\LogicManager\TestLogic::setParameterCount($count);
