<?php

$debugger = false;

// setup page
$config = [
	'title' => 'Questionario studente',
	'stitle' => 'Per favore, prima di accedere alle attività proposte completa il seguente questionario.',
	'type' => 'start',
];

// setup variables
$areas = [

	[
		'title' => 'Dopo le scuole medie',
		'questions' => [
			[
				'id' => 1,
				'text' => 'Il prossimo anno dovrai scegliere cosa fare dopo le scuole medie. Quanto ti senti pronto a scegliere in quale scuola superiore iscriverti? Indica un numero tra 1 (per niente pronto) a 10 (molto pronto)',
				'type' => 'grid',
				'grid-header' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
				'grid-direction' => 'row',
				'grid-rows' => [
					[['cbx'], ['cbx'], ['cbx'], ['cbx'], ['cbx'], ['cbx'], ['cbx'], ['cbx'], ['cbx'], ['cbx']],
				],
			],

			[
				'id' => 2,
				'text' => 'Cosa stai pensando di fare dopo la scuola media? Indica se escludi, se stai valutando o se sei sicuro/a (o quasi sicuro/a) di scegliere le opzioni elencate.',
				'type' => 'grid',
				'grid-header' => ['', 'Lo escludo', 'Lo sto valutando', 'Ne sono sicuro/a o quasi sicuro/a'],
				'grid-direction' => 'row',
				'grid-rows' => [
					[['text', 'Liceo'], ['cbx', 1], ['cbx', 1], ['cbx', 1]],
					[['text', 'Istituto Tecnico'], ['cbx', 2], ['cbx', 2], ['cbx', 2]],
					[['text', 'Istruzione e Formazione Professionale'], ['cbx', 3], ['cbx', 3], ['cbx', 3]],
					[['text', 'Istituto Professionale (Istituto “Don Milani” e Istituto “I. De Carneri” Oxford)'], ['cbx', 4], ['cbx', 4], ['cbx', 4]],
				],
			],

			[
				'id' => '3a',
				'text' => 'Per quanto riguarda il liceo, quale indirizzo stai valutando o hai valutato? Se sei
					indeciso puoi indicare più opzioni.',
				'type' => 'list',
				'multiple' => true,
				'list-rows' => [
					"Non ci ho ancora pensato",
					"Liceo scientifico",
					"Liceo classico",
					"Liceo delle scienze umane",
					"Liceo linguistico",
					"Liceo artistico",
					"Liceo musicare e coreutico",
				],
			],

			[
				'id' => '3b',
				'text' => 'Per quanto riguarda l’istituto tecnico, quale indirizzo stai valutando o hai valutato? Se
sei indeciso puoi indicare più opzioni.',
				'type' => 'list',
				'multiple' => true,
				'list-rows' => [
					"Non ci ho ancora pensato",
					"Settore economico",
					"Settore tecnologico",
				],
			],

			[
				'id' => '3c',
				'type' => 'list',
				'text' => 'Per quanto riguarda l’istruzione e formazione professionale, quale indirizzo stai
valutando o hai valutato? Se sei indeciso puoi indicare più opzioni.',
				'multiple' => true,
				'list-rows' => [
					"Non ci ho ancora pensato",
					"Agricoltura e ambiente",
					"Industria e artigianato",
					"Servizi",
				],
			],

			[
				'id' => '3d',
				'type' => 'list',
				'text' => 'Per quanto riguarda l’istituto professionale, quale indirizzo stai valutando o hai
valutato? Se sei indeciso puoi indicare più opzioni.',
				'multiple' => true,
				'list-rows' => [
					"Non ci ho ancora pensato",
					"Arti ausiliari delle professioni sanitarie: odontotecnico",
					"Servizi per la sanità e l’assistenza sociale",
				],
			],

			[
				'id' => 4,
				'text' => 'Quale pensi possa essere la tua capacità nell’affrontare i seguenti tipi di scuola? Esprimilo su una scala da 0 che significa “Non ne sarei assolutamente capace” a 10 “Sarei assolutamente capace di portarlo a termine”.',
				'type' => 'grid',
				'grid-header' => ['', 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
				'grid-direction' => 'row',
				'grid-rows' => [
					[['text', 'Liceo'], ['cbx', 1], ['cbx', 1], ['cbx', 1], ['cbx', 1], ['cbx', 1], ['cbx', 1], ['cbx', 1], ['cbx', 1], ['cbx', 1], ['cbx', 1], ['cbx', 1]],
					[['text', 'Istituto Tecnico'], ['cbx', 2], ['cbx', 2], ['cbx', 2], ['cbx', 2], ['cbx', 2], ['cbx', 2], ['cbx', 2], ['cbx', 2], ['cbx', 2], ['cbx', 2], ['cbx', 2]],
					[['text', 'Istruzione e Formazione Professionale'], ['cbx', 3], ['cbx', 3], ['cbx', 3], ['cbx', 3], ['cbx', 3], ['cbx', 3], ['cbx', 3], ['cbx', 3], ['cbx', 3], ['cbx', 3], ['cbx', 3]],
					[['text', 'Istituto Professionale (Istituto “Don Milani” e Istituto “I. De Carneri” Oxford)'], ['cbx', 4], ['cbx', 4], ['cbx', 4], ['cbx', 4], ['cbx', 4], ['cbx', 4], ['cbx', 4], ['cbx', 4], ['cbx', 4], ['cbx', 4], ['cbx', 4]],
				],
			],

			[
				'id' => 5,
				'text' => 'Quale pensi sia il giudizio dei tuoi genitori sulla tua capacità nell’affrontare i seguenti tipi di scuola? Esprimilo su una scala da 0 che significa “Non credono che ne sarei capace” a 10 “Credono che sarei capace di portarlo a termine”.',
				'type' => 'grid',
				'grid-header' => ['', 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
				'grid-direction' => 'row',
				'grid-rows' => [
					[['text', 'Liceo'], ['cbx', 1], ['cbx', 1], ['cbx', 1], ['cbx', 1], ['cbx', 1], ['cbx', 1], ['cbx', 1], ['cbx', 1], ['cbx', 1], ['cbx', 1], ['cbx', 1]],
					[['text', 'Istituto Tecnico'], ['cbx', 2], ['cbx', 2], ['cbx', 2], ['cbx', 2], ['cbx', 2], ['cbx', 2], ['cbx', 2], ['cbx', 2], ['cbx', 2], ['cbx', 2], ['cbx', 2]],
					[['text', 'Istruzione e Formazione Professionale'], ['cbx', 3], ['cbx', 3], ['cbx', 3], ['cbx', 3], ['cbx', 3], ['cbx', 3], ['cbx', 3], ['cbx', 3], ['cbx', 3], ['cbx', 3], ['cbx', 3]],
					[['text', 'Istituto Professionale (Istituto “Don Milani” e Istituto “I. De Carneri” Oxford)'], ['cbx', 4], ['cbx', 4], ['cbx', 4], ['cbx', 4], ['cbx', 4], ['cbx', 4], ['cbx', 4], ['cbx', 4], ['cbx', 4], ['cbx', 4], ['cbx', 4]],
				],
			],

			[
				'id' => 6,
				'text' => 'Come definiresti la tua situazione attuale rispetto alla scelta da compiere?',
				'type' => 'list',
				'list-rows' => [
					"Mi sento pronto a prendere una decisione soddisfacente in autonomia",
					"Penso di aver bisogno di aiuto per prendere una decisione soddisfacente",
					"Non mi sento pronto a prendere la decisione",
				],
			],

			[
				'id' => 7,
				'text' => 'Quanto sei d’accordo o in disaccordo con le seguenti affermazioni',
				'type' => 'grid',
				'grid-header' => ['', 'Completamente in disaccordo', 'Abbastanza in disaccordo', 'Abbastanza d\'accordo', 'Completamente d\'accordo'],
				'grid-direction' => 'row',
				'grid-rows' => [
					[['text', 'Sono in grado di scegliere la scuola giusta per me'], ['cbx', 1], ['cbx', 1], ['cbx', 1], ['cbx', 1]],
					[['text', 'Ho le idee chiare sul mio futuro scolastico'], ['cbx', 2], ['cbx', 2], ['cbx', 2], ['cbx', 2]],
					[['text', 'So studiare abbastanza bene da poter scegliere la scuola che più mi piace'], ['cbx', 3], ['cbx', 3], ['cbx', 3], ['cbx', 3]],
					[['text', 'Penso che i miei genitori sappiano meglio di me quale sia la scuola giusta per me'], ['cbx', 4], ['cbx', 4], ['cbx', 4], ['cbx', 4]],
					[['text', 'Penso che i miei insegnanti sappiano meglio di me quale sia la scuola giusta per me'], ['cbx', 5], ['cbx', 5], ['cbx', 5], ['cbx', 5]],
					[['text', 'Sono in grado di scegliere la scuola che mi porterà a fare il lavoro che voglio'], ['cbx', 6], ['cbx', 6], ['cbx', 6], ['cbx', 6]],
					[['text', 'Sono in grado di scegliere una scuola che riuscirò a terminare con buoni risultati'], ['cbx', 7], ['cbx', 7], ['cbx', 7], ['cbx', 7]],
					[['text', 'Alla fine sceglierò la scuola che vogliono farmi frequentare i miei genitori'], ['cbx', 8], ['cbx', 8], ['cbx', 8], ['cbx', 8]],
					[['text', 'So dove cercare le informazioni che mi servono per scegliere la scuola secondaria di II grado (superiore)'], ['cbx', 9], ['cbx', 9], ['cbx', 9], ['cbx', 9]],
					[['text', 'Conosco bene gli indirizzi scolastici tra cui posso scegliere'], ['cbx', 10], ['cbx', 10], ['cbx', 10], ['cbx', 10]],
					[['text', 'Ho qualcuno di fidato con cui confrontarmi sulla scelta della scuola'], ['cbx', 11], ['cbx', 11], ['cbx', 11], ['cbx', 11]],
					[['text', 'Conosco le materie insegnate nelle scuole a cui sono interessato'], ['cbx', 12], ['cbx', 12], ['cbx', 12], ['cbx', 12]],
				],
			],

			[
				'id' => 8,
				'text' => 'Quanto sono importanti per te queste persone nell’aiutarti a scegliere il tipo di scuola che farai?',
				'type' => 'grid',
				'grid-header' => ['', 'Per niente importante', 'Poco importante', 'Abbastanza importante', 'Molto importante', 'Non presente'],
				'grid-direction' => 'row',
				'grid-rows' => [
					[['text', 'Mia madre'], ['cbx', 1], ['cbx', 1], ['cbx', 1], ['cbx', 1], ['cbx', 1]],
					[['text', 'Mio padre'], ['cbx', 2], ['cbx', 2], ['cbx', 2], ['cbx', 2], ['cbx', 2]],
					[['text', 'I miei fratelli/sorelle'], ['cbx', 3], ['cbx', 3], ['cbx', 3], ['cbx', 3], ['cbx', 3]],
					[['text', 'Altri parenti (nonni, zii)'], ['cbx', 4], ['cbx', 4], ['cbx', 4], ['cbx', 4], ['cbx', 4]],
					[['text', 'I miei amici'], ['cbx', 5], ['cbx', 5], ['cbx', 5], ['cbx', 5], ['cbx', 5]],
					[['text', 'Uno o due professori con chiacchierate informali'], ['cbx', 6], ['cbx', 6], ['cbx', 6], ['cbx', 6], ['cbx', 6]],
					[['text', 'Persone che conosco del mio paese o quartiere'], ['cbx', 7], ['cbx', 7], ['cbx', 7], ['cbx', 7], ['cbx', 7]],
					[['text', 'Conoscenti che frequentano la scuola che mi interessa'], ['cbx', 8], ['cbx', 8], ['cbx', 8], ['cbx', 8], ['cbx', 8]],
					[['text', 'Il consiglio di classe con il consiglio orientativo'], ['cbx', 9], ['cbx', 9], ['cbx', 9], ['cbx', 9], ['cbx', 9]],
				],
			],

			[
				'id' => 9,
				'text' => 'Quanto sono importanti per te questi motivi nello scegliere il tipo di scuola che farai dopo le medie?',
				'type' => 'grid',
				'grid-header' => ['', 'Per niente importante', 'Poco importante', 'Abbastanza importante', 'Molto importante'],
				'grid-direction' => 'row',
				'grid-rows' => [
					[['text', 'L’interesse per le materie insegnate'], ['cbx', 1], ['cbx', 1], ['cbx', 1], ['cbx', 1]],
					[['text', 'La possibilità di fare stage o tirocini lavorativi durante gli studi'], ['cbx', 2], ['cbx', 2], ['cbx', 2], ['cbx', 2]],
					[['text', 'La possibilità di trovare un buon lavoro con il diploma senza dover poi andare all’università'], ['cbx', 3], ['cbx', 3], ['cbx', 3], ['cbx', 3]],
					[['text', 'La possibilità di continuare a frequentare i miei amici a scuola'], ['cbx', 4], ['cbx', 4], ['cbx', 4], ['cbx', 4]],
					[['text', 'La possibilità di fare il lavoro che mi interessa'], ['cbx', 5], ['cbx', 5], ['cbx', 5], ['cbx', 5]],
					[['text', 'La vicinanza della scuola a casa'], ['cbx', 6], ['cbx', 6], ['cbx', 6], ['cbx', 6]],
					[['text', 'La possibilità di fare lo stesso lavoro dei miei genitori'], ['cbx', 7], ['cbx', 7], ['cbx', 7], ['cbx', 7]],
					[['text', 'La possibilità di fare una scuola non troppo difficile in cui sai che potrai riuscire'], ['cbx', 8], ['cbx', 8], ['cbx', 8], ['cbx', 8]],
					[['text', 'La possibilità di fare molte ore di lezione pratica'], ['cbx', 9], ['cbx', 9], ['cbx', 9], ['cbx', 9]],
					[['text', 'La possibilità di andare a lavorare il prima possibile'], ['cbx', 10], ['cbx', 10], ['cbx', 10], ['cbx', 10]],
					[['text', 'La possibilità di non dover studiare troppo per essere promossi'], ['cbx', 11], ['cbx', 11], ['cbx', 11], ['cbx', 11]],
				],
			],

		]
	],

	[
		'title' => 'I tuoi interessi e risultati scolastici',
		'questions' => [
			[
				'id' => 1,
				'text' => 'Quanto ti appassionano/piacciono le seguenti materie? Esprimilo su una scala che va da 0 (“Per niente”) a 10 (“Moltissimo”)',
				'type' => 'grid',
				'grid-header' => ['', 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
				'grid-direction' => 'row',
				'grid-rows' => [
					[['text', 'Matematica'], ['cbx', 1], ['cbx', 1], ['cbx', 1], ['cbx', 1], ['cbx', 1], ['cbx', 1], ['cbx', 1], ['cbx', 1], ['cbx', 1], ['cbx', 1], ['cbx', 1]],
					[['text', 'Scienze'], ['cbx', 2], ['cbx', 2], ['cbx', 2], ['cbx', 2], ['cbx', 2], ['cbx', 2], ['cbx', 2], ['cbx', 2], ['cbx', 2], ['cbx', 2], ['cbx', 2]],
					[['text', 'Italiano'], ['cbx', 3], ['cbx', 3], ['cbx', 3], ['cbx', 3], ['cbx', 3], ['cbx', 3], ['cbx', 3], ['cbx', 3], ['cbx', 3], ['cbx', 3], ['cbx', 3]],
					[['text', 'Storia'], ['cbx', 4], ['cbx', 4], ['cbx', 4], ['cbx', 4], ['cbx', 4], ['cbx', 4], ['cbx', 4], ['cbx', 4], ['cbx', 4], ['cbx', 4], ['cbx', 4]],
					[['text', 'Geografia'], ['cbx', 5], ['cbx', 5], ['cbx', 5], ['cbx', 5], ['cbx', 5], ['cbx', 5], ['cbx', 5], ['cbx', 5], ['cbx', 5], ['cbx', 5], ['cbx', 5]],
					[['text', 'Inglese'], ['cbx', 6], ['cbx', 6], ['cbx', 6], ['cbx', 6], ['cbx', 6], ['cbx', 6], ['cbx', 6], ['cbx', 6], ['cbx', 6], ['cbx', 6], ['cbx', 6]],
					[['text', 'Tedesco'], ['cbx', 7], ['cbx', 7], ['cbx', 7], ['cbx', 7], ['cbx', 7], ['cbx', 7], ['cbx', 7], ['cbx', 7], ['cbx', 7], ['cbx', 7], ['cbx', 7]],
					[['text', 'Tecnologia'], ['cbx', 8], ['cbx', 8], ['cbx', 8], ['cbx', 8], ['cbx', 8], ['cbx', 8], ['cbx', 8], ['cbx', 8], ['cbx', 8], ['cbx', 8], ['cbx', 8]],
					[['text', 'Arte e Immagine'], ['cbx', 9], ['cbx', 9], ['cbx', 9], ['cbx', 9], ['cbx', 9], ['cbx', 9], ['cbx', 9], ['cbx', 9], ['cbx', 9], ['cbx', 9], ['cbx', 9]],
					[['text', 'Educazione Fisica'], ['cbx', 10], ['cbx', 10], ['cbx', 10], ['cbx', 10], ['cbx', 10], ['cbx', 10], ['cbx', 10], ['cbx', 10], ['cbx', 10], ['cbx', 10], ['cbx', 10]],
					[['text', 'Musica'], ['cbx', 11], ['cbx', 11], ['cbx', 11], ['cbx', 11], ['cbx', 11], ['cbx', 11], ['cbx', 11], ['cbx', 11], ['cbx', 11], ['cbx', 11], ['cbx', 11]],
				],
			],

			[
				'id' => 2,
				'text' => 'Quanto ti senti bravo nelle seguenti materie? Esprimilo su una scala che va da 0 (“Per niente”) a 10 (“Moltissimo”)',
				'type' => 'grid',
				'grid-header' => ['', 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
				'grid-direction' => 'row',
				'grid-rows' => [
					[['text', 'Matematica'], ['cbx', 1], ['cbx', 1], ['cbx', 1], ['cbx', 1], ['cbx', 1], ['cbx', 1], ['cbx', 1], ['cbx', 1], ['cbx', 1], ['cbx', 1], ['cbx', 1]],
					[['text', 'Scienze'], ['cbx', 2], ['cbx', 2], ['cbx', 2], ['cbx', 2], ['cbx', 2], ['cbx', 2], ['cbx', 2], ['cbx', 2], ['cbx', 2], ['cbx', 2], ['cbx', 2]],
					[['text', 'Italiano'], ['cbx', 3], ['cbx', 3], ['cbx', 3], ['cbx', 3], ['cbx', 3], ['cbx', 3], ['cbx', 3], ['cbx', 3], ['cbx', 3], ['cbx', 3], ['cbx', 3]],
					[['text', 'Storia'], ['cbx', 4], ['cbx', 4], ['cbx', 4], ['cbx', 4], ['cbx', 4], ['cbx', 4], ['cbx', 4], ['cbx', 4], ['cbx', 4], ['cbx', 4], ['cbx', 4]],
					[['text', 'Geografia'], ['cbx', 5], ['cbx', 5], ['cbx', 5], ['cbx', 5], ['cbx', 5], ['cbx', 5], ['cbx', 5], ['cbx', 5], ['cbx', 5], ['cbx', 5], ['cbx', 5]],
					[['text', 'Inglese'], ['cbx', 6], ['cbx', 6], ['cbx', 6], ['cbx', 6], ['cbx', 6], ['cbx', 6], ['cbx', 6], ['cbx', 6], ['cbx', 6], ['cbx', 6], ['cbx', 6]],
					[['text', 'Tedesco'], ['cbx', 7], ['cbx', 7], ['cbx', 7], ['cbx', 7], ['cbx', 7], ['cbx', 7], ['cbx', 7], ['cbx', 7], ['cbx', 7], ['cbx', 7], ['cbx', 7]],
					[['text', 'Tecnologia'], ['cbx', 8], ['cbx', 8], ['cbx', 8], ['cbx', 8], ['cbx', 8], ['cbx', 8], ['cbx', 8], ['cbx', 8], ['cbx', 8], ['cbx', 8], ['cbx', 8]],
					[['text', 'Arte e Immagine'], ['cbx', 9], ['cbx', 9], ['cbx', 9], ['cbx', 9], ['cbx', 9], ['cbx', 9], ['cbx', 9], ['cbx', 9], ['cbx', 9], ['cbx', 9], ['cbx', 9]],
					[['text', 'Educazione Fisica'], ['cbx', 10], ['cbx', 10], ['cbx', 10], ['cbx', 10], ['cbx', 10], ['cbx', 10], ['cbx', 10], ['cbx', 10], ['cbx', 10], ['cbx', 10], ['cbx', 10]],
					[['text', 'Musica'], ['cbx', 11], ['cbx', 11], ['cbx', 11], ['cbx', 11], ['cbx', 11], ['cbx', 11], ['cbx', 11], ['cbx', 11], ['cbx', 11], ['cbx', 11], ['cbx', 11]],
				],
			],
		]
	],

	[
		'title' => 'La tua famiglia',
		'questions' => [
			[
				'id' => 1,
				'text' => 'Qual è il titolo di studio più alto conseguito dai tuoi genitori?',
				'type' => 'grid',
				'grid-header' => ['', 'Madre', 'Padre'],
				'grid-rows' => [
					[['text', 'Licenza elementare'], ['cbx', 'ma'], ['cbx', 'pa']],
					[['text', 'Licenza media'], ['cbx', 'ma'], ['cbx', 'pa']],
					[['text', 'Qualifica professionale triennale'], ['cbx', 'ma'], ['cbx', 'pa']],
					[['text', 'Diploma di istituto professionale (5 anni)'], ['cbx', 'ma'], ['cbx', 'pa']],
					[['text', 'Diploma di istituto tecnico'], ['cbx', 'ma'], ['cbx', 'pa']],
					[['text', 'Diploma di istituto magistrale'], ['cbx', 'ma'], ['cbx', 'pa']],
					[['text', 'Diploma di liceo'], ['cbx', 'ma'], ['cbx', 'pa']],
					[['text', 'Laurea (o più)'], ['cbx', 'ma'], ['cbx', 'pa']],
					[['text', 'Non riesco neanche approssimativamente ad indicare il titolo di studio'], ['cbx', 'ma'], ['cbx', 'pa']],
					[['text', 'Non presente'], ['cbx', 'ma'], ['cbx', 'pa']],
				],
			],

			[
				'id' => 2,
				'text' => 'Quanti libri ci sono a casa tua? (non considerare riviste, giornali o i tuoi libri di scuola)',
				'type' => 'list',
				'list-rows' => [
					"Nessuno o molto pochi (0-10 libri)",
					"Abbastanza da riempire una mensola (11-25 libri)",
					"Abbastanza da riempire uno scaffale (26-100 libri)",
					"Abbastanza da riempire due scaffali (101-200 libri)",
					"Abbastanza da riempire tre o più scaffali (più di 200 libri)",
				],
			],
			[
				'id' => 3,
				'text' => 'Quale lavoro fanno (o facevano in passato) tuo padre e tua madre?<br><br>(metti una risposta per colonna, una per la madre e una per il padre)<br><br>Anche se ora non lavorano, indica l’ultimo lavoro che hanno fatto. Se non hanno mai lavorato, barra la casella “Non ha mai lavorato”.',
				'type' => 'grid',
				'grid-header' => ['', 'Madre', 'Padre'],
				'grid-rows' => [
					[['text', 'Grande imprenditore (almeno 10 dipendenti)'], ['cbx', 'ma'], ['cbx', 'pa']],
					[['text', 'Piccolo imprenditore, commerciante, artigiano'], ['cbx', 'ma'], ['cbx', 'pa']],
					[['text', 'Professionista (es. avvocato, medico, commercialista)'], ['cbx', 'ma'], ['cbx', 'pa']],
					[['text', 'Dirigente, funzionario, capoufficio'], ['cbx', 'ma'], ['cbx', 'pa']],
					[['text', 'Tecnico, geometra, perito industriale'], ['cbx', 'ma'], ['cbx', 'pa']],
					[['text', 'Impiegato qualificato, insegnante, assistente sociale'], ['cbx', 'ma'], ['cbx', 'pa']],
					[['text', 'Centralinista, segretaria/o, cassiera/e'], ['cbx', 'ma'], ['cbx', 'pa']],
					[['text', 'Operaio, addetto ai servizi, socio di cooperativa (tecnico, infermiere, cameriere, commessa, ecc)'], ['cbx', 'ma'], ['cbx', 'pa']],
					[['text', 'Non ha mai lavorato'], ['cbx', 'ma'], ['cbx', 'pa']],
					[['text', 'Non riesco neanche approssimativamente ad indicare la professione'], ['cbx', 'ma'], ['cbx', 'pa']],
					[['text', 'Non presente'], ['cbx', 'ma'], ['cbx', 'pa']],
				],
			],
			[
				'id' => 4,
				'text' => 'Nel lavoro che i tuoi genitori fanno (o facevano), hanno un’attività in proprio oppure lavorano come dipendenti? (metti una risposta per colonna, una per la madre e una per il padre)',
				'type' => 'grid',
				'grid-header' => ['', 'Madre', 'Padre'],
				'grid-rows' => [
					[['text', 'Lavora in proprio'], ['cbx', 'ma'], ['cbx', 'pa']],
					[['text', 'Lavora come dipendente'], ['cbx', 'ma'], ['cbx', 'pa']],
					[['text', 'Non presenti'], ['cbx', 'ma'], ['cbx', 'pa']],
				],
			],
			[
				'id' => 5,
				'text' => 'Adesso ti chiediamo di essere più preciso: puoi descriverci esattamente che lavoro fanno (oppure facevano) tuo padre e madre? Ti raccomandiamo di evitare risposte generiche (es. impiegato, operaio): cerca di essere il più preciso possibile (es. impiegato amministrativo addetto alla contabilità; operaio metalmeccanico con ruolo di supervisore, insegnante di matematica alle scuole medie)',
				'type' => 'inputs',
				'inputs' => [
					['pholder' => 'Madre', 'name' => 'ma', 'max' => 150],
					['pholder' => 'Padre', 'name' => 'pa', 'max' => 150],
				],
			],
		]
	],

];

// load shared logic
include_once('survey.php');
