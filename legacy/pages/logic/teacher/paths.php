<?php

$returnUrl = $_GET['return'] ?? false;
$areas = [];
$areaRows = \App\Legacy\LegacyDB::select('id FROM areas ORDER BY id ASC');

while ($areaRow = $areaRows->fetch_assoc()) {
	$area = new Area($areaRow['id']);
	$areas[$area->slug] = $area->name;
}

$paths = [
	[
		'name' => 'Percorso base',
		'info' => 'Vengono utilizzate solo le aree PROFILO PERSONALE e SCEGLIERE, soprattutto se l’utilizzo della piattaforma avverrà solo nel primo quadrimestre della terza. L’utilizzo ideale prevede la ripetizione delle attività a distanza di tempo, il coinvolgimento-confronto con i genitori e la problematizzazione in classe di alcune tematiche da parte del docente-orientatore.',
		'sections' => [
			'profile' => 'Tutte le attività',
			'skills' => '<span class="area_text--empty">Nessuna attività</span>',
			'knowledge' => '<span class="area_text--empty">Nessuna attività</span>',
			'choose' => 'Tutte le attività',
		],
	],
	[
		'name' => 'Percorso completo',
		'info' => 'Si utilizza la piattaforma per tutta la classe, a partire dal secondo quadrimestre della seconda classe oppure solo in terza. Si sperimentano le tre aree PROFILO PERSONALE, COMPETENZE DI BASE e SAPERI INFORMALI in quest’ordine, mentre l’area SCEGLIERE verrà proposta solo nel primo quadrimestre della terza. L’utilizzo ideale prevede la ripetizione delle attività a distanza di tempo, il coinvolgimento-confronto con i genitori e la problematizzazione in classe di alcune tematiche da parte del docente-orientatore.<br><br>
		Questo tipo di percorso può essere utilizzato anche in modo <strong>libero</strong>: in questo caso il docente-orientatore potrà scegliere quali sezioni utilizzare in base ai suoi bisogni-interessi, per tutta la classe oppure in modo mirato per alcuni studenti, oppure in modo <strong>autonomo</strong>: in questo caso non si presuppone la mediazione del docente-orientatore, ma viene lasciato all’utilizzo autonomo da parte dello studente anche successivamente al Consiglio orientativo, quindi nel secondo quadrimestre della terza.',
		'sections' => [
			'profile' => 'Tutte le attività',
			'skills' => 'Tutte le attività',
			'knowledge' => 'Tutte le attività',
			'choose' => 'Tutte le attività',
		],
	],
	[
		'name' => 'Percorso cognitivo',
		'info' => 'È un percorso con caratterizzazione prevalentemente cognitiva. Quindi si utilizzeranno, nel Profilo personale, le sezioni STILI COGNITIVI, RISOLVERE PROBLEMI, MOTIVAZIONI E AREE DI INTERESSE; si utilizzerà poi l’intera area COMPETENZE DI BASE, in Saperi informali la sezione CREATIVITÀ E AUTOIMPRENDITORIALITÀ e l’area SCEGLIERE.',
		'sections' => [
			'profile' => ['Stili Cognitivi', 'Risolvere Problemi', 'Motivazioni e aree di interesse'],
			'skills' => 'Tutte le attività',
			'knowledge' => 'Creatività e autoimprenditorialità',
			'choose' => 'Tutte le attività',
		],
	],
	[
		'name' => 'Percorso emotivo-identitario',
		'info' => 'In questo percorso si utilizzeranno, nel Profilo personale, le sezioni RESILIENZA, AUTOSTIMA, STILE ATTRIBUTIVO, TEMPERAMENTO, in Saperi informali la sezione L’ALBERO DEI SAPERI INFORMALI e l’intera area SCEGLIERE.',
		'sections' => [
			'profile' => ['Resilienza', 'Autostima', 'Stile attributivo', 'Temperamento'],
			'skills' => '<span class="area_text--empty">Nessuna attività</span>',
			'knowledge' => 'L\'albero dei saperi informali',
			'choose' => 'Tutte le attività',
		],
	],
];
