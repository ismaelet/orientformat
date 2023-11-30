<?php



global $sectionsConfig;


$sectionsConfig = [
	// Stili cognitivi
	1 => [
		'type' => 'parameters',
		'recap-name-grade' => 'Stile prevalente nella classe',
		'recap-name-student' => 'Stile prevalente',
		'desc' => "Qui puoi controllare i risultati delle autovalutazioni relative agli stili cognitivi. Per ogni stile è indicata la media della classe.<br>Puoi passare il mouse sopra alle singole colonne per visualizzare i valori esatti.",
		'grade-average-name' => 'Stile predominante nella classe',
		'platform-average-name' => 'Stile predominante nei partecipanti',
	],
	36 => [

		'type' => 'parameters',
		'recap-name-grade' => 'Stile prevalente nella classe',
		'recap-name-student' => 'Stile prevalente',
		'desc' => "Qui puoi controllare i risultati delle autovalutazioni relative agli stili cognitivi. Per ogni stile è indicata la media della classe.<br>Puoi passare il mouse sopra alle singole colonne per visualizzare i valori esatti.",
		'grade-average-name' => 'Stile predominante nella classe',
		'platform-average-name' => 'Stile predominante nei partecipanti',
	],


	// Resilienza
	3 => [
		'type' => 'tiers',
		'recap-name-grade' => 'Tasso di resilienza medio',
		'recap-name-student' => 'Tasso di resilienza',
		'desc' => "Qui puoi controllare i risultati delle autovalutazioni relative alla resilienza.<br>Compariranno solo gli studenti che hanno completato l'autovalutazione.",
		'average' => true,
	],
	29 => [
		'type' => 'parameters',
		'recap-name-grade' => 'Livello medio di autostima',
		'recap-name-student' => 'Livello medio di autostima',
		'desc' => "Qui puoi controllare i risultati delle autovalutazioni relative all'autostima. Per ogni aspetto dell'autostima è indicata la media della classe.<br>Puoi passare il mouse sopra alle singole colonne per visualizzare i valori esatti.",
		'average' => true,
	],

	// Autostima
	4 => [
		'type' => 'parameters',
		'recap-name-grade' => 'Livello medio di autostima',
		'recap-name-student' => 'Livello medio di autostima',
		'desc' => "Qui puoi controllare i risultati delle autovalutazioni relative all'autostima. Per ogni aspetto dell'autostima è indicata la media della classe.<br>Puoi passare il mouse sopra alle singole colonne per visualizzare i valori esatti.",
		'average' => true,
	],
	41 => [
		'type' => 'parameters',
		'recap-name-grade' => 'Livello medio di autostima',
		'recap-name-student' => 'Livello medio di autostima',
		'desc' => "Qui puoi controllare i risultati delle autovalutazioni relative all'autostima. Per ogni aspetto dell'autostima è indicata la media della classe.<br>Puoi passare il mouse sopra alle singole colonne per visualizzare i valori esatti.",
		'average' => true,
	],

	// Risolvere i problemi
	5 => [
		'type' => 'parameters',
		'recap-name-grade' => 'Risultato medio delle attività',
		'recap-name-student' => 'Risultato medio delle attività',
		'tiers' => ['Molto basso', 'Basso', 'Sufficiente', 'Buono', 'Eccellente'],
		'desc' => "Qui puoi controllare i risultati delle attività relative alla risoluzione di problemi. Per ogni attività è indicata la media della classe.<br>Puoi passare il mouse sopra alle singole colonne per visualizzare i valori esatti.",
		'average' => true,
	],
	30 => [
		'type' => 'parameters',
		'recap-name-grade' => 'Risultato medio delle attività',
		'recap-name-student' => 'Risultato medio delle attività',
		'tiers' => ['Molto basso', 'Basso', 'Sufficiente', 'Buono', 'Eccellente'],
		'desc' => "Qui puoi controllare i risultati delle attività relative alla risoluzione di problemi. Per ogni attività è indicata la media della classe.<br>Puoi passare il mouse sopra alle singole colonne per visualizzare i valori esatti.",
		'average' => true,
	],
	38 => [
		'type' => 'parameters',
		'recap-name-grade' => 'Risultato medio delle attività',
		'recap-name-student' => 'Risultato medio delle attività',
		'tiers' => ['Molto basso', 'Basso', 'Sufficiente', 'Buono', 'Eccellente'],
		'desc' => "Qui puoi controllare i risultati delle attività relative alla risoluzione di problemi. Per ogni attività è indicata la media della classe.<br>Puoi passare il mouse sopra alle singole colonne per visualizzare i valori esatti.",
		'average' => true,
	],
	42 => [
		'type' => 'parameters',
		'recap-name-grade' => 'Risultato medio delle attività',
		'recap-name-student' => 'Risultato medio delle attività',
		'tiers' => ['Molto basso', 'Basso', 'Sufficiente', 'Buono', 'Eccellente'],
		'desc' => "Qui puoi controllare i risultati delle attività relative alla risoluzione di problemi. Per ogni attività è indicata la media della classe.<br>Puoi passare il mouse sopra alle singole colonne per visualizzare i valori esatti.",
		'average' => true,
	],

	// Stile attributivo
	6 => [
		'type' => 'parameters',
		'recap-name-grade' => 'Principalmente attribuiscono successi e fallimenti a',
		'recap-name-student' => 'Principalmente attribuisce successi e fallimenti a',
		'desc' => "Qui puoi controllare i risultati delle autovalutazioni relative allo stile attributivo. Per ogni stile è indicato quanto mediamente è predominante nella classe.<br>Puoi passare il mouse sopra alle singole colonne per visualizzare i valori esatti.",
		'max' => 'dynamic',
	],
	7 => [
		'type' => 'parameters',
		'recap-name-grade' => 'Area di interesse prevalente',
		'recap-name-student' => 'Area di interesse prevalente',
		'desc' => "Qui puoi controllare i risultati delle autovalutazioni relative alla motivazione e alle aree di interesse. Per ogni area principale è indicata la media della classe.<br>Puoi passare il mouse sopra alle singole colonne per visualizzare i valori esatti.",
		'grade-average-name' => 'Area di interesse prevalente nella classe',
		'platform-average-name' => 'Area di interesse prevalente nei partecipanti',
		'max' => 'dynamic',
	],
	8 => [
		'type' => 'parameters',
		'recap-name-grade' => 'Temperamento più pronunciato',
		'recap-name-student' => 'Temperamento più pronunciato',
		'desc' => "Qui puoi controllare i risultati delle autovalutazioni relative al temperamento. Per ogni aspetto del temperamento è indicata la media della classe.<br>Puoi passare il mouse sopra alle singole colonne per visualizzare i valori esatti.",
	],
	31 => [

		'type' => 'parameters',
		'recap-name-grade' => 'Risultato medio delle attività',
		'recap-name-student' => 'Risultato medio delle attività',
		'desc' => "Qui puoi controllare i risultati dell'autovalutazione relativa alla capacità di mantenere l'attenzione. I risultati sono stati divisi in tasso di distrazione e tasso di iperattività.<br>Puoi passare il mouse sopra alle singole colonne per visualizzare i valori esatti.",
		'average' => true,
	],
	9 => [

		'type' => 'parameters',
		'recap-name-grade' => 'Risultato medio delle autovalutazioni',
		'recap-name-student' => 'Risultato medio delle autovalutazioni',
		'desc' => "Qui puoi controllare i risultati dell'autovalutazione relativa alla capacità di mantenere l'attenzione. I risultati sono stati divisi in tasso di distrazione e tasso di iperattività.<br>Puoi passare il mouse sopra alle singole colonne per visualizzare i valori esatti.",
		'average' => true,
	],
	32 => [
		'type' => 'tiers',
		'recap-name-grade' => 'Risultato medio dell\'autovalutazione e attività',
		'recap-name-student' => 'Risultato medio dell\'autovalutazione e attività',
		'grade-average-name' => 'Risultato medio della classe',
		'platform-average-name' => 'Risultato medio dei partecipanti',
		'desc' => "Qui puoi controllare i risultati delle attività relative alla capacità di ricordare. Per ogni attività è indicata la media della classe.<br>Puoi passare il mouse sopra alle singole colonne per visualizzare i valori esatti.",
		'average' => true,
	],
	10 => [

		'type' => 'tiers',
		'recap-name-grade' => 'Risultato medio delle autovalutazioni e degli esercizi',
		'recap-name-student' => 'Risultato medio dell\'autovalutazione e degli esercizi',
		'grade-average-name' => 'Risultato medio della classe',
		'platform-average-name' => 'Risultato medio dei partecipanti',
		'desc' => "Qui puoi controllare i risultati delle attività relative alla capacità di ricordare. Per ogni attività è indicata la media della classe.<br>Puoi passare il mouse sopra alle singole colonne per visualizzare i valori esatti.",
		'average' => true,
	],
	33 => [

		'type' => 'tiers',
		'recap-name-grade' => 'Risultato medio delle attività',
		'recap-name-student' => 'Risultato medio delle attività',
		'desc' => "Qui puoi controllare i risultati delle attività relative alla capacità di ascoltare. Per ogni attività è indicata la media della classe.<br>Puoi passare il mouse sopra alle singole colonne per visualizzare i valori esatti.",
		'average' => true,
	],
	11 => [

		'type' => 'tiers',
		'recap-name-grade' => 'Risultato medio delle attività',
		'recap-name-student' => 'Risultato medio delle attività',
		'desc' => "Qui puoi controllare i risultati delle attività relative alla capacità di ascoltare. Per ogni attività è indicata la media della classe.<br>Puoi passare il mouse sopra alle singole colonne per visualizzare i valori esatti.",
		'average' => true,
	],

	// Parlare
	12 => [

		'type' => 'tiers',
		'recap-name-grade' => 'Risultato medio delle attività',
		'recap-name-student' => 'Risultato medio delle attività',
		'desc' => "Qui puoi controllare i risultati delle attività relative alla capacità di parlare. Per ogni attività è indicata la media della classe.<br>Puoi passare il mouse sopra alle singole colonne per visualizzare i valori esatti.",
		'average' => true,
	],
	50 => [
		'type' => 'parameters',
		'recap-name-grade' => 'Risultato medio delle attività',
		'recap-name-student' => 'Risultato medio delle attività',
		'tiers' => ['Uso molto basso', 'Uso basso', 'Uso medio', 'Uso alto', 'Uso molto alto'],
		'desc' => "Qui puoi controllare i risultati del questionario relativo ai tipi di scrittura più usati. Per ogni tipo è indicato quando mediamente è usanto dagli studenti della classe.<br>Puoi passare il mouse sopra alle singole colonne per visualizzare i valori esatti.",
		'average' => true
	],

	// Leggere
	13 => [
		'recap-name-grade' => 'Risultato medio delle attività',
		'recap-name-student' => 'Risultato medio delle attività',
		'type' => 'tiers',
		'desc' => "Qui puoi controllare i risultati delle attività relative alla capacità di lettura. Per ogni attività è indicata la media della classe.<br>Puoi passare il mouse sopra alle singole colonne per visualizzare i valori esatti.",
		'average' => true,
	],

	// Scrivere
	14 => [
		'type' => 'parameters',
		'recap-name-grade' => 'Risultato medio delle attività',
		'recap-name-student' => 'Risultato medio delle attività',
		'tiers' => ['Uso molto basso', 'Uso basso', 'Uso medio', 'Uso alto', 'Uso molto alto'],
		'desc' => "Qui puoi controllare i risultati del questionario relativo ai tipi di scrittura più usati. Per ogni tipo è indicato quando mediamente è usanto dagli studenti della classe.<br>Puoi passare il mouse sopra alle singole colonne per visualizzare i valori esatti.",
		'average' => true
	],
	51 => [
		'type' => 'parameters',
		'recap-name-grade' => 'Risultato medio delle attività',
		'recap-name-student' => 'Risultato medio delle attività',
		'tiers' => ['Uso molto basso', 'Uso basso', 'Uso medio', 'Uso alto', 'Uso molto alto'],
		'desc' => "Qui puoi controllare i risultati del questionario relativo ai tipi di scrittura più usati. Per ogni tipo è indicato quando mediamente è usanto dagli studenti della classe.<br>Puoi passare il mouse sopra alle singole colonne per visualizzare i valori esatti.",
		'average' => true
	],
	55 => [
		'type' => 'parameters',
		'recap-name-grade' => 'Risultato medio delle attività',
		'recap-name-student' => 'Risultato medio delle attività',
		'tiers' => ['Uso molto basso', 'Uso basso', 'Uso medio', 'Uso alto', 'Uso molto alto'],
		'desc' => "Qui puoi controllare i risultati del questionario relativo ai tipi di scrittura più usati. Per ogni tipo è indicato quando mediamente è usanto dagli studenti della classe.<br>Puoi passare il mouse sopra alle singole colonne per visualizzare i valori esatti.",
		'average' => true
	],
	57 => [
		'type' => 'parameters',
		'recap-name-grade' => 'Risultato medio delle attività',
		'recap-name-student' => 'Risultato medio delle attività',
		'tiers' => ['Uso molto basso', 'Uso basso', 'Uso medio', 'Uso alto', 'Uso molto alto'],
		'desc' => "Qui puoi controllare i risultati del questionario relativo ai tipi di scrittura più usati. Per ogni tipo è indicato quando mediamente è usanto dagli studenti della classe.<br>Puoi passare il mouse sopra alle singole colonne per visualizzare i valori esatti.",
		'average' => true
	],

	// I miei interessi
	24 => [
		'type' => 'parameters',
		'recap-name-grade' => 'Interesse prevalente',
		'recap-name-student' => 'Interesse prevalente',
	],
	45 => [
		'type' => 'parameters',
		'recap-name-grade' => 'Interesse prevalente',
		'recap-name-student' => 'Interesse prevalente',
	],


	39 => [
		'recap-name-grade' => 'Risultato medio delle attività',
		'recap-name-student' => 'Risultato medio delle attività',
	],
	34 => [
		'type' => 'parameters',
		'recap-name-grade' => 'Risultato medio delle attività',
		'recap-name-student' => 'Risultato medio delle attività',
		'grade-average-name' => 'Uso medio dei vari tipi di scritttura nella classe',
		'platform-average-name' => 'Uso medio dei vari tipi di scritttura tra i partecipanti',
		'tiers' => ['Uso molto basso', 'Uso basso', 'Uso medio', 'Uso alto', 'Uso molto alto'],
		'desc' => "Qui puoi controllare i risultati del questionario relativo ai tipi di scrittura più usati. Per ogni tipo è indicato quando mediamente è usanto dagli studenti della classe.<br>Puoi passare il mouse sopra alle singole colonne per visualizzare i valori esatti.",
		'average' => true

	],
	15 => [

		'type' => 'tiers',
		'desc' => "Qui puoi controllare i risultati delle attività relative alla capacità di imparare. Per ogni attività è indicata la media della classe.<br>Puoi passare il mouse sopra alle singole colonne per visualizzare i valori esatti.",
		'average' => true,
	],
	40 => [
		'recap-name-grade' => 'Risultato medio delle attività',
		'recap-name-student' => 'Risultato medio delle attività',
	],
	17 => [
		'type' => 'parameters',
		'desc' => "Qui puoi controllare i risultati delle autovalutazioni relative alla creatività e autoimprenditorialità. Per ogni aspetto è indicata la media della classe.<br>Puoi passare il mouse sopra alle singole colonne per visualizzare i valori esatti.",
		'average' => true,
	],
	18 => [
		'recap-name-grade' => 'Stato',
		'recap-name-student' => 'Stato',
	],
	47 => [
		'recap-name-grade' => 'Risultato medio delle attività',
		'recap-name-student' => 'Risultato medio delle attività',
	],
];
