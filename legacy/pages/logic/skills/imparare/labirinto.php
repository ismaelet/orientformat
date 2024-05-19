<?php

//questions

use LogicManager\TestLogic;

$questions = [
	[['Mi chiedo: quali sono le mie aspettative e i miei obiettivi?', 'Trascrivo il titolo', 'Leggo per intero il primo paragrafo per farmi un’idea'], 1],
	[['Leggo in modo approfondito il primo e l’ultimo paragrafo', 'Leggo rapidamente per farmi un’idea globale', 'Cerco le parole difficili sul dizionario'], 2],
	[['Leggo attentamente una  frase alla volta e la ripeto mentalmente', 'Leggo mentalmente tutto il testo finché non me lo ricordo', 'Leggo in modo concentrato un intero blocco di informazioni'], 3],
	[['Leggo ad alta voce e poi faccio uno schema di ciò che ricordo', 'Rileggo i punti più difficili, sottolineo le parole-chiave e do un titolo alle unità', 'Esploro rapidamente il testo per farmi un’idea globale'], 2],
	[['Comincio a ripetere solo dopo che ho  letto tutto il testo', 'Dopo un po’ di tempo, rileggo tutto il testo almeno due volte', 'Dopo ogni unità di lettura, provo a ripetere i concetti più importanti'], 3],
	[['Provo a raffigurare schematicamente il contenuto del testo', 'Scrivo il riassunto del testo e lo rileggo più volte', 'Trascrivo sul quaderno le frasi più importanti e le imparo a memoria'], 1],
];

$titles = [
	['A', 'c4'],
	['B', 'c5'],
	['C', 'c2'],
];

$count = count($questions);

Test\Legacy\System\Classes\Logic::setParameterCount($count)
	->setTestSubmitFunction(function () {
		if (isset($_POST['skip-cbx'])) {
			return 0;
		} else {
			return 100;
		}
	});
