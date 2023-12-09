<?php

use app\Models\Activities\Test;

$test = Test::newFromStep(10, 3);
$test->prepare('description', "La figura qui sotto è il modello. Cerca di ricordarti le forme che la compongono. Dopo aver cliccato su <strong>Comincia</strong> compariranno, una dopo l'altra, per alcuni secondi sei altre figure. Cerca di identificare quale di queste è identica al modello e segnati il numero corrispondente. A fine attività ti verrà richiesto di inserire il numero della figura uguale.")
	->post();
