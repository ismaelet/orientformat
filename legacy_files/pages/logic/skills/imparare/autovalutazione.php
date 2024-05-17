<?php

use LogicManager\TestLogic;

$test = test();

$graph_data = [
	['Ho chiari i miei obiettivi', 'Ci sono obiettivi a breve termine, come ottenere un buon voto, e obiettivi
	di più lunga durata, come diventare più esperto/a in un determinato campo.'],
	['So programmare gli impegni', 'Non basta sapere dove si vuole arrivare, ma occorre anche sapere
	come arrivarci, con quali mezzi, anche rinunciando a qualcosa.'],
	['Rispetto i limiti di tempo a disposizione', 'Evitare due errori opposti: obiettivi troppo ambiziosi per
	tempi troppo brevi e tempi troppo lunghi per obiettivi molto facili.'],
	['So prendere appunti durante le lezioni', 'Scrivere richiede più tempo che parlare, quindi bisogna
	scegliere, abbreviare e organizzare le informazioni più importanti.'],
	['Pianifico  le ripetizioni di ciò che ho studiato', 'Per trattenere e consolidare ciò che si è appreso
	bisogna imparare a ripetere, per il tempo e il numero di volte necessari.'],
	['Faccio collegamenti fra ciò che  studio e ciò che vivo', 'Le conoscenze che non vengono applicate
	sfumano rapidamente: sono saperi inerti.'],
	['Nelle verifiche ho spesso buoni risultati', 'I risultati positivi sono una certificazione di efficacia, però
	anche i risultati negativi servono: si cresce sugli insuccessi, se si comprende perché si è sbagliato.'],
	['Applico  delle strategie per capire  ciò che leggo', 'Rendersi conto di non capire è il primo passo, dopo
	bisogna chiedersi che cosa fare per sciogliere i nodi.'],
];

$count = count($graph_data);

TestLogic::setParameterCount($count);
