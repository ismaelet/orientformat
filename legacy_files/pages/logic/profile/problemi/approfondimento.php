<?php

//get subsection data
$questions = [
	["Mi rendo conto quando c'è un problema", "Quanto ti risulta facile avvertire che c'è un problema di qualsiasi tipo?"],
	["Accetto la sfida", "In genere, quanto ti senti in grado di affrontare un problema, per quanto difficile possa essere?"],
	["Identifico il problema:", "Percepita e accettata l'esistenza di un problema, quanto ti riesce facile descriverlo a parole?"],
	["Controllo le risposte impulsive:", "Di solito, di fronte ai problemi, reagisci valutandoli attentamente e da diverse prospettive?"],
	["Scopro e controllo emozioni negative:", "Nel fronteggiare i problemi, riesci a controllare l'ansia, la sfiducia o la rabbia?"],
	["Analizzo e collego i dati:", "Quando affronti un problema, tieni ben presenti tutti i dati importanti e cerchi di collegarli in modo convincente e razionale?"],
	["Piano d'azione:", "Hai ben chiaro dove vuoi arrivare, qual è il tuo obiettivo, e le azioni che devi compiere per raggiungerlo?"],
	["Vincoli e risorse:", "Tieni sempre presenti, nell'affrontare un problema, quali sono i vincoli da rispettare e le risorse di cui puoi disporre?"],
	["Valuto i risultati:", "Quando stai affrontando un problema, continui a chiederti come stai procedendo e se sei nella direzione giusta?"],
	["Previsioni, cambio piano:", "Ti chiedi sempre quali conseguenze possano derivare dalle azioni progettate e, se nececessario, sei disposto a cambiare strategia?"],
	["Agisco:", "Quanto ti risulta facile, una volta che sei convinto del tuo piano, passare poi all'azione pratica?"],
];

$questions = array_reverse($questions);

$count = count($questions);

if ($test->result) {

	$result = array_filter(array_reverse($test->result));

	end($result);

	$pos = empty($result) ? 1 : key($result) + 2;

	if ($pos > $count) $pos = $count;

} else $pos = 1;

$this->set('questions', $questions);
$this->set('pos', $pos);