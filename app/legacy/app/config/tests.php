<?php

global $testsConfig;

$testsConfig = [
	// motivazione e aree di interesse > mappa
	20 => [
		'questions' => [
			["Mi piace lavorare manualmente", 1],
			["Mi piace pianificare le mie attività", 1],
			["Mi piace usare arnesi e attrezzi", 1],
			["Mi piace conoscere piante e animali", 2],
			["Mi piace osservare i fenomeni naturali e pormi delle domande", 2],
			["Mi piace svolgere attività a contatto con la natura", 2],
			["Mi piace disegnare", 3],
			["Mi piace collegare sempre le idee astratte a situazioni concrete", 3],
			["Mi piace organizzare incontri o attività con amici/amiche", 1],
			["Mi piace proteggere la natura e stare attento/a a non inquinare", 2],
			["Mi piace affrontare e risolvere problemi", 4],
			["Mi piace risolvere indovinelli o altri giochi enigmistici", 4],
			["Mi piace soffermarmi a guardare immagini (quadri, foto, statue ecc.)", 3],
			["Mi piace fotografare", 3],
			["Mi piace ordinare e classificare", 4],
			["Mi piace fare calcoli e risolvere problemi matematici", 4],
			["Mi piace pormi delle domande sull’esistenza e il senso delle cose", 5],
			["Mi piace osservare il cielo e pormi domande sull’universo", 5],
			["Mi piace ascoltare musica", 6],
			["Mi piace ricordare a memoria le parole delle canzoni", 6],
			["Mi piace perdermi a fantasticare", 5],
			["Mi piace ascoltare storie o vedere dei film", 5],
			["Mi piace conversare o discutere", 7],
			["Mi piace ballare", 8],
			["Mi piace suonare uno strumento musicale", 6],
			["Mi piace studiare con una musica di sottofondo", 6],
			["Mi piace studiare insieme con un compagno o una compagna", 7],
			["Mi piace lavorare o fare attività in gruppo", 7],
			["Mi piace chiedermi come si sentono gli altri e cosa pensano", 7],
			["Mi piace praticare sport", 8],
			["Mi piace stare spesso in attività", 8],
			["Mi piace mettermi alla prova su abilità fisiche o osservare altri che lo fanno", 8],
		],

		'areas' => [
			['Area tecnico-organizzativa', 'top'],
			['Area naturalistica', 'top'],
			['Area figurativo-spaziale', 'lef'],
			['Area logico-matematica', 'rig'],
			['Area esistenziale', 'lef'],
			['Area musicale', 'rig'],
			['Area verbale-interpersonale', 'bot'],
			['Area motoria', 'bot'],
		],

		'categories' => [
			['Pratica', 'top'],
			['Introspettiva', 'lef'],
			['Analitica', 'rig'],
			['Interattiva', 'bot'],
		]
	],

	// stili cognitivi > mappa
	31 => [
		'groups' => [
			1 => [
				'name' => 'Visivo',
				'info' => "apprende e ricorda attraverso immagini",
				'questionIds' => [3, 9, 13],
			],
			2 => [
				'name' => 'Uditivo',
				'info' => "è a suo agio quando può ascoltare",
				'questionIds' => [1, 18, 23],
			],
			3 => [
				'name' => 'Globale',
				'info' => "ricerca l’insieme, la totalità, trascurando i dettagli",
				'questionIds' => [5, 11, 16],
			],
			4 => [
				'name' => 'Analitico',
				'info' => "si concentra sui particolari, perdendo di vista l’insieme",
				'questionIds' => [2, 4, 17],
			],
			5 => [
				'name' => 'Collaborativo',
				'info' => "lavora meglio in gruppo, mentre da solo si annoia",
				'questionIds' => [6, 10, 19],
			],
			6 => [
				'name' => 'Autonomo',
				'info' => "preferisce lavorare da solo, è a disagio nei lavori di gruppo",
				'questionIds' => [0, 12, 21],
			],
			7 => [
				'name' => 'Sistematico',
				'info' => "predilige la precisione e la completezza, a costo di risultare dispersivo",
				'questionIds' => [8, 14, 20],
			],
			8 => [
				'name' => 'Intuitivo',
				'info' => "vuole arrivare subito alla conclusione, rischiando soluzioni avventate",
				'questionIds' => [7, 15, 22],
			],
		]
	],

	// stile attributivo > riepilogo
	46 => [
		'sections' => [
			__('tests.46-section-1'),
			__('tests.46-section-2'),
			__('tests.46-section-3'),
			__('tests.46-section-4'),
			__('tests.46-section-5'),
		]
	],

	// stile attributivo > riepilogo
	48 => [
		'styles' => ['Tenacia', 'Pregiudizio', 'Abilità', 'Destino', 'Strategia', 'Dipendenza', 'Emozione', 'Caso']
	],

	// scrivere > mappa
	63 => [
		'types' => [
			__('tests.63-type-1'),
			__('tests.63-type-2'),
			__('tests.63-type-3'),
			__('tests.63-type-4'),
			__('tests.63-type-5'),
			__('tests.63-type-6'),
			__('tests.63-type-7'),
			__('tests.63-type-8'),
			__('tests.63-type-9'),
			__('tests.63-type-10'),
			__('tests.63-type-11'),
			__('tests.63-type-12'),
			__('tests.63-type-13'),
			__('tests.63-type-14'),
			__('tests.63-type-15'),
			__('tests.63-type-16'),
		]
	],

	168 => [
		'types' => [
			'Esposizione',
			'Post',
			'Poesia pubblica',
			'Racconto',
			'Riassunto pubblico',
			'Istruzioni',
			'E-mail',
			'Diario',
			'Riassunto privato',
			'Poesia privata',
			'Schema pubblico',
			'Brainstorming',
			'Schema privato',
			'Mappa',
			'Promemoria',
			'Appunti',
		]
	],

	// stili cognitivi semplificato > mappa
	109 => [
		'groups' => [
			1 => [
				'name' => 'Visivo',
				'translated_name' => __('tests.109-1-name'),
				'info' => __('tests.109-1-info'),
				'questionIds' => [2, 4, 7],
			],
			2 => [
				'name' => 'Uditivo',
				'translated_name' => __('tests.109-2-name'),
				'info' => __('tests.109-2-info'),
				'questionIds' => [1, 8, 11],
			],
			3 => [
				'name' => 'Collaborativo',
				'translated_name' => __('tests.109-3-name'),
				'info' => __('tests.109-3-info'),
				'questionIds' => [3, 5, 9],
			],
			4 => [
				'name' => 'Autonomo',
				'translated_name' => __('tests.109-4-name'),
				'info' => __('tests.109-4-info'),
				'questionIds' => [0, 6, 10],
			],
		]
	],

	// stili agire > mappa
	111 => [
		'groups' => [
			1 => [
				'name' => 'Riflessivo',
				'info' => "portato a vagliare a fondo i pro e i contro, rischia di restare invischiato nelle proprie
				congetture",
				'questionIds' => [5, 14, 21],
			],
			2 => [
				'name' => 'Pragmatico',
				'info' => "dotato di senso pratico e orientato ai risultati, è poco propenso all’esplorazione e al
				rischio",
				'questionIds' => [12, 16, 18],
			],
			3 => [
				'name' => 'Livellatore',
				'info' => "bisognoso di sicurezza, fatica a cogliere le differenze e le sfumature",
				'questionIds' => [0, 8, 15],
			],
			4 => [
				'name' => 'Acutizzatore',
				'info' => "orientato al cambiamento, è portato a rimarcare gli elementi di novità e di diversità",
				'questionIds' => [3, 11, 17],
			],
			5 => [
				'name' => 'Impulsivo',
				'info' => "è rapido nel decidere ma spesso precipitoso e approssimativo",
				'questionIds' => [2, 8, 23],
			],
			6 => [
				'name' => 'Metodico',
				'info' => "è prudente e preciso ma perlopiù lento e insicuro nelle decisioni",
				'questionIds' => [1, 7, 9],
			],
			7 => [
				'name' => 'Correttore',
				'info' => "aperto al caso, all’imprevisto, aggiusta in corso d’opera i suoi progetti",
				'questionIds' => [10, 19, 22],
			],
			8 => [
				'name' => 'Pianificatore',
				'info' => "progetta con cura, temendo gli imprevisti, anche se possono risultare utili e
				promettenti",
				'questionIds' => [4, 13, 20],
			],
		]
	],

	// stili essere > mappa
	113 => [
		'groups' => [
			1 => [
				'name' => 'Semplicità',
				'info' => "spaventato dall’incertezza e dal rischio, rimane ancorato a ciò che è solido e sicuro",
				'questionIds' => [2, 17, 22],
			],
			2 => [
				'name' => 'Complessità',
				'info' => "nonostante i rischi, si sente sfidato dalle difficoltà e dall’incertezza dei risultati",
				'questionIds' => [5, 11, 14],
			],
			3 => [
				'name' => 'Giocoso',
				'info' => "ciò che conta non è il risultato, ma il piacere di svolgere l’attività",
				'questionIds' => [3, 12, 19],
			],
			4 => [
				'name' => 'Finalistico',
				'info' => "nelle diverse attività ciò che interessa veramente è il risultato",
				'questionIds' => [0, 15, 21],
			],
			5 => [
				'name' => 'Divergente',
				'info' => "portato all’innovazione, all’apertura mentale e alla diversità, può risultare   litigioso, arrogante o inconcludente",
				'questionIds' => [6, 8, 16],
			],
			6 => [
				'name' => 'Convergente',
				'info' => "orientato in un’unica direzione, può risultare efficace e determinato ma con prospettive anguste",
				'questionIds' => [1, 10, 18],
			],
			7 => [
				'name' => 'Esplorativo',
				'info' => "curioso e indagatore, è portato verso le novità, esponendosi anche a dei rischi",
				'questionIds' => [9, 20, 23],
			],
			8 => [
				'name' => 'Evitante',
				'info' => "teme ciò che è nuovo e incerto, cercando di restare attaccato a luoghi e persone rassicuranti",
				'questionIds' => [4, 7, 13],
			],
		]
	],

	// interessi > questionario
	91 => [
		'questions' => [
			'Conoscere ed essere aggiornato sui metodi per allevare il bestiame',
			'Studiare la storia dell’arte',
			'Tenere la contabilità di un’azienda',
			'Conoscere e valorizzare le caratteristiche del territorio in cui si opera',
			'Fare la guida alpina',
			'Preparare composti chimici ad uso farmaceutico',
			'Leggere uno spartito musicale',
			'Integrare la meccanica con nozioni di elettronica ed informatica finalizzate all\'automazione industriale',
			'Eseguire trattamenti estetici o curativi',
			'Realizzare e collaudare impianti elettrici in case e uffici',
			'Occuparsi delle forniture e redigere il listino dei prezzi',
			'Conoscere e utilizzare i linguaggi di programmazione',
			'Ricevere le ordinazioni dei clienti in un ristorante o in un bar',
			'Praticare il balletto o la danza in modo dilettantesco o professionistico',
			'Progettare e realizzare prodotti grafici su supporto cartaceo e digitale',
			'Studiare a applicare la matematica ai diversi ambiti scientifici',
			'Guidare mezzi di trasporto come furgoni o camion',
			'Organizzare convegni e manifestazioni',
			'Gestire gli adempimenti di natura fiscale',
			'Gestire o lavorare in un’azienda agricola',
			'Manovrare gru o macchinari per l’edilizia',
			'Approfondire temi storici e filosofici, anche nella prospettiva dell’insegnamento',
			'Studiare le leggi fisiche che permettono a un motore di funzionare',
			'Sapere come funziona una centrale elettrica',
			'Analizzare gli elementi chimici delle sostanze nutrizionali e inquinanti',
			'Sostenere la conversazione con cittadini stranieri',
			'Monitorare le consegne e l’integrità delle merci',
			'Seguire l’andamento dei prezzi di mercato e programmare vendite e sconti',
			'Illustrare libri, opuscoli o siti web',
			'Interagire con pazienza e gentilezza anche con persone che vivono disagi',
			'Fare attività di laboratorio',
			'Progettare o sovrintendere alla costruzione di un edificio',
			'Studiare le varie tecniche per la conservazione degli alimenti',
			'Accompagnare gruppi di persone nei tour turistici',
			'Programmare siti Internet',
			'Allenare una squadra',
			'Essere interessati ai problemi economici',
			'Esibirsi in pubblico nell’esecuzione di un brano musicale',
			'Studiare al microscopio la struttura delle cellule',
			'Fare l’interprete nei congressi, nelle fiere e negli incontri internazionali',
			'Controllare e ottimizzare i flussi energetici nel rispetto delle normative di sicurezza e di tutela dell’ambiente',
			'Costruire alleanze tra soggetti diversi per aiutare persone in difficoltà, come disabili o immigrati',
			'Consigliare l’abbinamento di cibi e bevande',
			'Cimentarsi nella scrittura di articoli, racconti o poesie',
			'Progettare oggetti di arredamento o arredare case e appartamenti',
			'Diventare maestro di sci',
			'Accogliere i clienti di un albergo, interagendo in diverse lingue',
			'Lavorare con persone anziane o bisognose di cura',
			'Saper leggere schemi di circuiti elettrici ed elettronici',
			'Organizzare la disposizione delle merci in un negozio o in un supermercato',
			'Riconoscere le malattie delle piante e applicare tecniche di prevenzione e cura',
			'Fare la guida in un museo o in una città, comunicando anche con una lingua	straniera',
			'Progettare reti informatiche per le aziende',
			'Documentarsi su riviste, giornali e nel web su importanti sviluppi scientifici',
			'Controllare uno scalo ferroviario, marittimo o aereo',
			'Utilizzare apparecchiature per la diagnosi e la cura delle malattie',
			'Suonare uno strumento',
			'Progettare e collaudare impianti termici e idraulici',
			'Proporre e sviluppare iniziative educative e culturale per i giovani nei quartieri	disagiati',
			'Viaggiare all’estero',
			'Approfondire le problematiche sociali attraverso studi e ricerche',
			'Praticare forme d’arte come la pittura, la scultura, la fotografia, la grafica',
			'Partecipare a competizioni sportive',
			'Fornire assistenza per problemi di hardware e software',
			'Fare animazione in una colonia o nel doposcuola',
			'Installare e riparare apparecchiature telefoniche e televisive.',
			'Riconoscere i diversi modelli organizzativi aziendali e ricercare soluzioni efficaci',
			'Interpretare testi classici in lingua italiana e tradurre dal latino e dal greco',
			'Registrare incassi, fatture, spese e fare versamenti in banca',
			'Fare studi approfonditi di botanica e zoologia',
			'Essere documentati sui metodi e sui prodotti per la cura e l’estetica della persona',
			'Gestire le prenotazioni per aerei, treni e alberghi',
			'Usare strumenti manuali per realizzare disegni tecnici',
			'Leggere testi di vario tipo in lingua originale.',
			'Gestire gli stipendi del personale e archiviare fatture commerciali',
			'Porsi domande su aspetti fondamentali come la materia, la vita, l’universo',
			'Conoscere le norme igieniche per la conservazione e la manipolazione dei cibi',
			'Condurre analisi batteriologiche',
			'Organizzare e aggiornare il sistema informatizzato degli ordini',
			'Studiare storia della musica, solfeggio e composizione',
			'Montare impianti stereo e antifurti in case e automobili',
			'Insegnare ginnastica o educazione motoria in una scuola o in una palestra',
			'Installare e gestire impianti industriali',
			'Reclamizzare nuovi prodotti',
			'Creare disegni per tessuti e ideare modelli di vestiario',
			'Saper cogliere le potenzialità estetiche di una persona',
			'Fornire assistenza e manutenzione nelle aule di informatica',
			'Analizzare e valutare le caratteristiche dei terreni edificabili',
			'Studiare e applicare le regole grammaticali (fonologia, morfologia e sintassi)',
			'Pilotare aerei o elicotteri',
			'Seguire nei diversi media i dibattiti e le controversie fra scienziati',
			'Saper servire ai tavoli in modo rapido e discreto',
			'Conoscere i vantaggi e gli svantaggi delle coltivazioni biologiche',
			'Utilizzare tecnologie e software applicativi per la gestione integrata di un’azienda',
			'Conoscere le leggi dell’elettricità, utilizzando batterie e trasformatori',
			'Dirigere un grande magazzino o un ipermercato',
			'Effettuare collegamenti e confronti fra diverse forme letterarie e artistiche,	italiane e straniere',
			'Montare o smontare impalcature, edificare muri, fare gettate di cemento',
			'Mettersi da punto di vista di chi manifesta sofferenza o disagio',
			'Partecipare a concerti e manifestazioni musicali',
			'Mettere in connessione le strutture di elaborazione dati in reti di computer',
			'Supportare i docenti nella gestione di classi difficili e di casi problematici',
			'Occuparsi della prevenzione e della gestione di situazioni a rischio ambientale e sanitario',
			'Conoscere e combinare gli ingredienti di cibi dolci o salati',
			'Approfondire le problematiche collegate alla conversione ed utilizzazione delle diverse fonti di energia',
			'Insegnare lingua e letteratura straniera',
			'Seguire gli sviluppi di una scienza dalle origini ad oggi',
			'Conoscere usi e costumi di paesi diversi dal nostro',
			'Conoscere i linguaggi, le metodologie e le tecniche di indagine nel campo delle scienze umane, in particolare psicologia, sociologia, antropologia',
			'Insegnare educazione musicale',
			'Risolvere i problemi relativi al trasporto delle merci',
			'Insegnare materie letterarie nella scuola',
			'Predisporre la sala di un ristorante o di una mensa aziendale',
			'Fare misurazioni di terre per la costruzione di strade, case, ponti, gallerie',
		]
	],

	150 => [
		'questions' => [
			'Conoscere ed essere aggiornato sui metodi per allevare il bestiame',
			'Studiare la storia dell’arte',
			'Tenere la contabilità di un’azienda',
			'Conoscere e valorizzare le caratteristiche del territorio in cui si opera',
			'Ideare prodotti audiovisivi e fotografici',
			'Fare la guida alpina',
			'Preparare composti chimici ad uso farmaceutico',
			'Praticare la danza in modo professionale',
			'Integrare la meccanica con nozioni di elettronica ed informatica finalizzate all\'automazione industriale',
			'Eseguire trattamenti estetici o curativi',
			'Realizzare e collaudare impianti elettrici in case e uffici',
			'Occuparsi delle forniture e redigere il listino dei prezzi',
			'Conoscere e utilizzare i linguaggi di programmazione',
			'Ricevere le ordinazioni dei clienti in un ristorante o in un bar',
			'Praticare il balletto o la danza in modo dilettantesco o professionistico',
			'Progettare, realizzare e lanciare prodotti nei vari settori della moda',
			'Studiare a applicare la matematica ai diversi ambiti scientifici',
			'Guidare mezzi di trasporto come furgoni o camion',
			'Progettare e produrre nel settore dei new media',
			'Organizzare convegni e manifestazioni',
			'Gestire gli adempimenti di natura fiscale',
			'Gestire o lavorare in un’azienda agricola',
			'Manovrare gru o macchinari per l’edilizia',
			'Approfondire temi storici e filosofici, anche nella prospettiva dell’insegnamento',
			'Studiare le leggi fisiche che permettono a un motore di funzionare',
			'Sapere come funziona una centrale elettrica',
			'Analizzare gli elementi chimici delle sostanze nutrizionali e inquinanti',
			'Progettare e realizzare scenografie e impianti luminosi e sonori',
			'Sostenere la conversazione con cittadini stranieri',
			'Monitorare le consegne e l’integrità delle merci',
			'Seguire l’andamento dei prezzi di mercato e programmare vendite e sconti',
			'Studiare in modo approfondito il clima e la sua incidenza sulla navigazione',
			'Illustrare libri, opuscoli o siti web',
			'Interagire con pazienza e gentilezza anche con persone che vivono disagi',
			'Fare attività di laboratorio',
			'Progettare o sovrintendere alla costruzione di un edificio',
			'Progettare e gestire gli ambienti del sistema agro-alimentare',
			'Accompagnare gruppi di persone nei tour turistici',
			'Programmare siti Internet',
			'Allenare una squadra',
			'Essere interessati ai problemi economici',
			'Esibirsi in pubblico nell’esecuzione di un brano musicale',
			'Studiare al microscopio la struttura delle cellule',
			'Fare l’interprete nei congressi, nelle fiere e negli incontri internazionali',
			'Controllare e ottimizzare i flussi energetici nel rispetto delle normative di sicurezza e di tutela dell’ambiente',
			'Costruire alleanze tra soggetti diversi per aiutare persone in difficoltà, come disabili o immigrati',
			'Consigliare l’abbinamento di cibi e bevande',
			'Organizzare festival, rassegne teatrali, cinematografiche o di danza',
			'Cimentarsi nella scrittura di articoli, racconti o poesie',
			'Progettare oggetti di arredamento o arredare case e appartamenti',
			'Diventare maestro di sci',
			'Accogliere i clienti di un albergo, interagendo in diverse lingue',
			'Lavorare con persone anziane o bisognose di cura',
			'Saper leggere schemi di circuiti elettrici ed elettronici',
			'Organizzare la disposizione delle merci in un negozio o in un supermercato',
			'Riconoscere le malattie delle piante e applicare tecniche di prevenzione e cura',
			'Fare la guida in un museo o in una città, comunicando anche con una lingua	straniera',
			'Progettare reti informatiche per le aziende',
			'Documentarsi su riviste, giornali e nel web su importanti sviluppi scientifici',
			'Controllare uno scalo ferroviario, marittimo o aereo',
			'Utilizzare apparecchiature per la diagnosi e la cura delle malattie',
			'Dirigere un’orchestra',
			'Progettare e collaudare impianti termici e idraulici',
			'Proporre e sviluppare iniziative educative e culturale per i giovani nei quartieri	disagiati',
			'Viaggiare all’estero',
			'Approfondire le problematiche sociali attraverso studi e ricerche',
			'Praticare forme d’arte come la pittura, la scultura, la fotografia, la grafica',
			'Partecipare a competizioni sportive',
			'Fornire assistenza per problemi di hardware e software',
			'Fare animazione in una colonia o nel doposcuola',
			'Installare e riparare apparecchiature telefoniche e televisive.',
			'Conoscere a fondo la fisica dell’atmosfera, dei mari e del clima',
			'Riconoscere i diversi modelli organizzativi aziendali e ricercare soluzioni efficaci',
			'Interpretare testi classici in lingua italiana e tradurre dal latino e dal greco',
			'Registrare incassi, fatture, spese e fare versamenti in banca',
			'Fare studi approfonditi di botanica e zoologia',
			'Essere documentati sui metodi e sui prodotti per la cura e l’estetica della persona',
			'Gestire le prenotazioni per aerei, treni e alberghi',
			'Usare strumenti manuali per realizzare disegni tecnici',
			'Imparare a gestire la prevenzione, la sicurezza e l’emergenza nella navigazione',
			'Leggere testi di vario tipo in lingua originale.',
			'Gestire gli stipendi del personale e archiviare fatture commerciali',
			'Porsi domande su aspetti fondamentali come la materia, la vita, l’universo',
			'Conoscere le norme igieniche per la conservazione e la manipolazione dei cibi',
			'Condurre analisi batteriologiche',
			'Organizzare e aggiornare il sistema informatizzato degli ordini',
			'Intraprendere la carriera di attore nel cinema',
			'Collaborare alla realizzazione di  spettacoli dal vivo, utilizzando diversi mezzi di comunicazione e canali di fruizione',
			'Montare impianti stereo e antifurti in case e automobili',
			'Insegnare ginnastica o educazione motoria in una scuola o in una palestra',
			'Installare e gestire impianti industriali',
			'Reclamizzare nuovi prodotti',
			'Creare disegni per tessuti e ideare modelli di vestiario',
			'Saper cogliere le potenzialità estetiche di una persona',
			'Fornire assistenza e manutenzione nelle aule di informatica',
			'Analizzare e valutare le caratteristiche dei terreni edificabili',
			'Studiare e applicare le regole grammaticali (fonologia, morfologia e sintassi)',
			'Pilotare aerei o elicotteri',
			'Seguire nei diversi media i dibattiti e le controversie fra scienziati',
			'Saper servire ai tavoli in modo rapido e discreto',
			'Conoscere i vantaggi e gli svantaggi delle coltivazioni biologiche',
			'Utilizzare tecnologie e software applicativi per la gestione integrata di un’azienda',
			'Conoscere le leggi dell’elettricità, utilizzando batterie e trasformatori',
			'Studiare come si governa una nave e quali regolamenti si devono conoscere e rispettare',
			'Dirigere un grande magazzino o un ipermercato',
			'Effettuare collegamenti e confronti fra diverse forme letterarie e artistiche,	italiane e straniere',
			'Montare o smontare impalcature, edificare muri, fare gettate di cemento',
			'Mettersi da punto di vista di chi manifesta sofferenza o disagio',
			'Recitare in teatro',
			'Mettere in connessione le strutture di elaborazione dati in reti di computer',
			'Supportare i docenti nella gestione di classi difficili e di casi problematici',
			'Occuparsi della prevenzione e della gestione di situazioni a rischio ambientale e sanitario',
			'Conoscere e valorizzare la produzione, trasformazione, conservazione e presentazione dei prodotti enogastronomici',
			'Approfondire le problematiche collegate alla conversione ed utilizzazione delle diverse fonti di energia',
			'Insegnare lingua e letteratura straniera',
			'Seguire gli sviluppi di una scienza dalle origini ad oggi',
			'Vivere a stretto contatto col mare',
			'Conoscere usi e costumi di paesi diversi dal nostro',
			'Conoscere i linguaggi, le metodologie e le tecniche di indagine nel campo delle scienze umane, in particolare psicologia, sociologia, antropologia',
			'Allestire delle scenografie',
			'Risolvere i problemi relativi al trasporto delle merci',
			'Insegnare materie letterarie nella scuola',
			'Predisporre la sala di un ristorante o di una mensa aziendale',
			'Fare misurazioni di terre per la costruzione di strade, case, ponti, gallerie',
			'Lavorare nei settori dell’industria culturale e dello spettacolo',
			'Conoscere il funzionamento dei motori delle barche e delle navi'
		]
	],

	// interessi > risultato
	92 => [
		'groups' => [
			1 => [
				'name' => 'Agricoltura e ambiente',
				'info' => 'L’Operatore agricolo può svolgere diverse attività: ara,
				pianta, zappa, semina, concima, innesta, pota, tratta le
				piante con anticrittogamici per proteggerle da malattie e
				insetti, miete, coltiva piante da semina e da frutto,
				raccoglie frutta e ortaggi, provvedere alla manutenzione,
				alla messa a punto e a piccole riparazioni di macchinari
				agricoli. La sua attività può comprendere anche
				l’allevamento di animali di bassa corte e/o di bestiame di
				grande taglia.',
				'questionIds' => [1, 20, 33, 51, 70, 93],
			],
			2 => [
				'name' => 'Amministrazione, finanza e marketing',
				'info' => 'Chi opera in quest’area ha competenze generali nel campo
				dei fenomeni economici, si occupa dei processi aziendali
				(organizzazione, pianificazione, programmazione,
				amministrazione, finanza e controllo). Integra queste
				competenze specifiche con quelle linguistiche e
				informatiche, per favorire le relazioni dell’impresa nel
				contesto nazionale e internazionale.',
				'questionIds' => [3, 19, 37, 67, 75, 94],
			],
			3 => [
				'name' => 'Arti visive e moda',
				'info' => 'Nel campo delle arti visive troviamo molte figure
				professionali: pittori, scultori, grafici, fumettisti,
				pubblicitari, arredatori, designer, scenografi, insegnanti di
				educazione artistica, fotografi artistici, architetti,
				costumisti, stilisti. Ciò che accomuna queste diverse
				professioni è l’interesse ad esprimersi in modo personale
				e creativo ma attento alle richieste di chi acquista i prodotti
				realizzati. ',
				'questionIds' => [2, 15, 29, 45, 62, 85],
			],
			4 => [
				'name' => 'Benessere e cura',
				'info' => 'Applica metodologie mirate al benessere psicofisico della
				persona. Il suo obiettivo primario è di favorire il
				mantenimento o il miglioramento della forma del cliente,
				dando i consigli migliori per la tutela della salute e della
				bellezza. In quest’area operano estetiste, parrucchieri,
				badanti, personale delle case di riposo, infermieri,
				fisioterapisti, ottici, odontotecnici.',
				'questionIds' => [9, 30, 48, 71, 86, 99],
			],
			5 => [
				'name' => 'Chimica, materiali e biotecnologie',
				'info' => 'Sono numerose le professioni relative a quest’area:
				genetisti. analisti degli ospedali, ricercatori in chimica e
				biologia, chimici delle industrie, tecnici farmaceutici,
				insegnanti di chimica e biologia nelle scuole e nelle
				università. IL diplomato in quest’area ha competenze
				specifiche nel campo delle analisi strumentali chimicobiologiche, dei materiali, nei processi di produzione negli
				ambiti chimico, merceologico, biologico, farmaceutico,
				tintorio e conciario. Inoltre è competente nel settore della
				prevenzione e della gestione di situazioni a rischio
				ambientale e sanitario.',
				'questionIds' => [6, 25, 39, 56, 78, 103],
			],
			6 => [
				'name' => 'Commercio e vendita',
				'info' => 'Gestisce acquisti e vendite, occupandosi delle forniture di
				un negozio, redigendo e archiviando fatture commerciali,
				compilando listini dei prezzi, presentando o diffondendo
				nuovi prodotti, registrando gli incassi. Operano in
				quest’area i negozianti, gli agenti di commercio, gli
				ambulanti, i commessi, il personale dei grandi magazzini,
				gli studiosi del mercato e delle esigenze dei clienti.',
				'questionIds' => [11, 28, 50, 69, 84, 96],
			],
			7 => [
				'name' => 'Corpo, movimento e sport',
				'info' => 'Gli interessa il movimento per il benessere e l’efficienza
				fisica propria o altrui. Partecipa direttamente, o prepara
				altri, a competizioni sportive oppure ad attività che
				coinvolgono il corpo in modo armonioso, come ad esempio
				la danza. In quest’area troviamo atleti, allenatori, ballerini
				e danzatori professionisti, insegnanti di educazione
				motoria.',
				'questionIds' => [5, 14, 36, 46, 63, 82],
			],
			8 => [
				'name' => 'Edilizia e costruzioni',
				'info' => 'L’Operatore edile si occupa della progettazione,
				costruzione e manutenzione di edifici residenziali e non
				residenziali, utilizza macchine operatrici edili, esegue
				lavori generali di scavo e movimentazione di materiali, è
				esperto nel disegno tecnico (architettonico, strutturale,
				impiantistico) e nel calcolo di pendenze, altezze e quote.
				È interessato alla trasformazione e conservazione di
				immobili, alla tutela del territorio e alla valorizzazione
				dell’ambiente. Progetta spazi abitativi e urbani, arredo di
				interni ed esterni. Progetta opere speciali di
				contenimento, opere idrauliche e di consolidamento del
				suolo. In quest’area troviamo vari tipi di lavoro: operai
				edili, conduttori di macchinari per il movimento terra, per
				la perforazione in edilizia, di apparecchi di sollevamento;
				esperti per la salvaguardia del territorio e la prevenzione
				dei rischi ambientali; geometri, architetti, ingegneri edili,
				capi cantiere.',
				'questionIds' => [21, 32, 73, 98, 88, 114],
			],
			9 => [
				'name' => 'Elettronica e elettrotecnica',
				'info' => 'Collabora nella progettazione, costruzione e collaudo di
				sistemi elettrici, elettronici e di automazione. Integra
				conoscenze di elettrotecnica, di elettronica e di informatica
				per intervenire nell’automazione industriale e nel
				controllo dei processi produttivi. Contribuisce al
				mantenimento della sicurezza sul lavoro e nella tutela
				ambientale. In quest’area troviamo elettricisti, riparatori di
				radio, televisioni e telefoni, ingegneri elettrici ed
				elettronici, elettrauto.',
				'questionIds' => [10, 24, 49, 66, 81, 95],
			],
			10 => [
				'name' => 'Informatica e telecomunicazioni',
				'info' => 'La figura dell’informatico si distingue in diverse professioni
				in base all’informazione trattata e alla modalità con la
				quale si tratta: si passa dall’interconnessione di computer
				e server al mondo del web marketing, fino ad arrivare
				all’analisi di grandi quantità di dati o alla creazione di siti
				web. In quest’area troviamo programmatori, addetti alle
				comunicazioni, riparatori di sistemi informatici, tecnici nei
				laboratori delle scuole, insegnanti di matematica e
				informatica nelle scuole e nelle università.',
				'questionIds' => [12, 35, 53, 64, 87, 101],
			],
			11 => [
				'name' => 'Letteraria e umanistica',
				'info' => 'Studia e trasmette i valori della civiltà classica e della
				cultura umanistica. Con la sua educazione letteraria,
				storica e filosofica, può contribuire direttamente allo
				sviluppo della cultura contemporanea attraverso la
				scrittura di racconti, romanzi, opere teatrali, poesie, saggi
				o articoli per giornali e riviste specializzate oppure,
				attraverso l’insegnamento, favorisce l’accesso delle nuove
				generazioni a questo mondo culturale.',
				'questionIds' => [22, 44, 68, 89, 97, 112],
			],
			12 => [
				'name' => 'Linguistica',
				'info' => 'È attratto dalle culture, dalle lingue e dai modi di vita di
				popoli diversi dal suo.
				Ama viaggiare e interagire con i cittadini di un paese
				straniero, sia per motivi di lavoro che di svago. Pratica
				diverse lingue straniere sia in forma orale che scritta.
				Conosce le strutture grammaticali delle lingue per farne un
				uso corretto. La padronanza delle lingue apre la strada a
				diverse professioni: interpreti, traduttori, guide turistiche,
				responsabili dei rapporti internazionali delle ditte,
				insegnanti di lingua e letteratura straniera nelle scuole e
				all’università.',
				'questionIds' => [26, 40, 60, 74, 106, 108],
			],
			13 => [
				'name' => 'Meccanica, meccatronica, energia',
				'info' => 'Si occupa della progettazione e costruzione di sistemi
				meccanici ed elettro-meccanici. È interessato ai processi
				produttivi e segue la fabbricazione e il monitoraggio di
				componenti meccanici. Conosce il funzionamento delle
				macchine di un’officina e sa individuare eventuali guasti.
				Opera nel campo delle diverse fonti di energia e del
				risparmio nei consumi energetici. Diverse sono le
				professioni che riguardano quest’area: progettisti di
				impianti, operai e tecnici che collaudano e controllano le
				macchine di una fabbrica, ingegneri, insegnanti in istituti
				tecnici, professionali o all’università.',
				'questionIds' => [8, 23, 41, 58, 83, 105],
			],
			14 => [
				'name' => 'Musicale',
				'info' => 'Presenta talento e interessi per la musica in tutte le sue
				varie forme ed espressioni, come suonare uno strumento,
				leggere musica, cantare, assistere a spettacoli musicali,
				comporre. Sono molte le professioni di chi opera in questo
				campo: strumentisti, cantanti, compositori, direttori
				d’orchestra, arrangiatori, critici musicali, insegnanti di
				musica nelle scuole e nei conservatori.',
				'questionIds' => [7, 38, 57, 80, 100, 110],
			],
			15 => [
				'name' => 'Ristorazione',
				'info' => 'Consente alle persone che si trovano fuori casa di bere e
				mangiare, cucinando o servendo cibi caldi o freddi, preparando
				la sala di un ristorante, consigliando vini o altre bevande,
				prendendo le ordinazioni dei clienti, conoscendo le norme
				igieniche per la conservazione dei cibi. In quest’area operano
				camerieri, cuochi, pasticcieri, sommelier, maitre.',
				'questionIds' => [13, 43, 77, 92, 104, 113],
			],
			16 => [
				'name' => 'Scientifica',
				'info' => 'Conosciamo la realtà che ci circonda e noi stessi attraverso
				teorie che si sviluppano nel tempo e si trasformano
				quando emergono nuovi dati che le mettono in
				discussione. Anche se non possiamo avere certezze
				assolute, l’approccio scientifico è il solo che ci permette di
				sperimentare ipotesi e comunicare risultati in modo
				rigoroso. La scienza, nei suoi svariati campi, si avvale di
				strumentazioni tecniche che permettono a ricercatori di
				rimediare alle debolezze dei nostri apparati sensoriali.',
				'questionIds' => [16, 31, 54, 76, 91, 107],
			],
			17 => [
				'name' => 'Scienze umane',
				'info' => 'È interessato alla formazione e alla socializzazione, in
				particolare delle persone in difficoltà. Conosce i vari
				sistemi educativi e ha le competenze per operare su
				diverse fasce d’età, dai bambini delle materne agli
				adolescenti delle scuole superiori. Lavorano in
				quest’ambito insegnanti, educatori, assistenti sociali,
				animatori, pedagogisti, orientatori.',
				'questionIds' => [42, 59, 61, 65, 102, 109],
			],
			18 => [
				'name' => 'Trasporti e logistica',
				'info' => 'In un mondo sempre più globalizzato, il trasporto di merci
				e persone diventa sempre più importante. Perché il
				trasferimento di merci da un luogo all’altro avvenga nei
				tempi previsti, in modo efficiente e al minor costo
				possibile, ci devono essere degli esperti che organizzano al
				meglio lo smistamento, la movimentazione e lo
				stoccaggio. In quest’area troviamo diverse mansioni, che
				vanno dall’autista di camion all’ingegnere, dal pilota di
				aereo al controllore di scali ferroviari.',
				'questionIds' => [17, 27, 55, 79, 90, 111],
			],
			19 => [
				'name' => 'Turismo',
				'info' => 'Conosce il patrimonio culturale, artistico, artigianale,
				enogastronomico, paesaggistico ed ambientale del
				territorio, contribuendo alla sua valorizzazione e al suo
				sviluppo turistico. Dovendo interagire anche con ospiti
				stranieri, riesce a comunicare agevolmente in inglese o
				nella lingua straniera prevalentemente usata dalla
				clientela. Lavorano in questo campo gli addetti delle
				agenzie turistiche, gli steward e le hostess degli aerei, i
				portieri d’albergo, le guide turistiche, gli animatori dei
				villaggi turistici.',
				'questionIds' => [4, 18, 34, 47, 52, 72],
			],
		]
	],

	// interessi > risultato
	151 => [
		'groups' => [
			1 => [
				'name' => 'Agricoltura e ambiente',
				'info' => 'L’Operatore agricolo può svolgere diverse attività: ara, pianta, zappa, semina, concima, innesta, pota, tratta le piante con anticrittogamici per proteggerle da malattie e insetti, miete, coltiva piante da semina e da frutto, raccoglie frutta e ortaggi, provvedere alla manutenzione, alla messa a punto e a piccole riparazioni di macchinari agricoli. La sua attività può comprendere anche l’allevamento di animali di bassa corte e/o di bestiame di grande taglia. Tra le figure professionali in quest’area troviamo allevatori, esperti per il controllo, la valorizzazione e il marketing delle produzioni agrarie, agro-alimentari e agro-industriali, veterinari, tecnici per la gestione dell’ambiente nel sistema agro-alimentare, responsabili delle produzioni e delle trasformazioni agrarie, agro-alimentari e agro-industriali.',
				'questionIds' => [1, 22, 37, 56, 76, 101],
			],
			2 => [
				'name' => 'Arti visive e moda',
				'info' => 'Nel campo delle arti visive troviamo molte figure professionali: pittori, scultori, grafici, fumettisti, pubblicitari, arredatori, designer, scenografi, insegnanti di educazione artistica, fotografi artistici, architetti, costumisti, stilisti. Ciò che accomuna queste diverse professioni è l’interesse ad esprimersi in modo personale e creativo ma attento alle richieste di chi acquista i prodotti realizzati. Nell’ambito del sistema moda, troviamo diverse figure professionali, quali i tecnici superiori di processo e prodotto per la nobilitazione degli articoli tessili e di abbigliamento, tecnici di processo, prodotto, comunicazione e marketing per il settore calzaturiero, tessile e dell’abbigliamento, tecnici per il coordinamento dei processi di progettazione, comunicazione e marketing del prodotto moda.',
				'questionIds' => [2, 16, 33, 50, 67, 93],
			],
			3 => [
				'name' => 'Amministrazione, finanza e marketing',
				'info' => 'Chi opera in quest’area ha competenze generali nel campo
				dei fenomeni economici, si occupa dei processi aziendali
				(organizzazione, pianificazione, programmazione,
				amministrazione, finanza e controllo). Integra queste
				competenze specifiche con quelle linguistiche e
				informatiche, per favorire le relazioni dell’impresa nel
				contesto nazionale e internazionale.',
				'questionIds' => [3, 21, 41, 73, 82, 102],
			],
			4 => [
				'name' => 'Turismo, Beni e Attività culturali e ricreative',
				'info' => 'Conosce il patrimonio culturale, artistico, artigianale, enogastronomico, paesaggistico ed ambientale del territorio, contribuendo alla sua valorizzazione e al suo sviluppo turistico. Dovendo interagire anche con ospiti stranieri, riesce a comunicare agevolmente in inglese o nella lingua straniera prevalentemente usata dalla clientela. Lavorano in questo campo gli addetti delle agenzie turistiche, gli steward e le hostess degli aerei, i portieri d’albergo, le guide turistiche, gli animatori dei villaggi turistici, i tecnici per la comunicazione e la valorizzazione di luoghi e territori con l’utilizzo di nuove tecnologie, per la conduzione del cantiere di restauro architettonico, per la gestione di strutture turistico-ricettive, per la produzione/riproduzione di artefatti artistici, per la promozione e il marketing delle filiere turistiche e delle attività culturali.',
				'questionIds' => [4, 20, 38, 52, 57, 78],
			],
			5 => [
				'name' => 'Servizi culturali e dello spettacolo',
				'info' => 'Interviene nei processi di ideazione, progettazione, produzione e distribuzione dei prodotti audiovisivi e fotografici nei settori dell’industria culturale e dello spettacolo e dei new media, con riferimento all\'ambito locale, nazionale e internazionale. È capace di attivare e gestire processi applicativi e tecnico-espressivi, valutandone criticità e punti di forza. Produce, edita e diffonde in maniera autonoma immagini e suoni, adattandoli ai diversi mezzi di comunicazione e canali di fruizione: dal cinema alla televisione, dallo smartphone al web, dai social all\'editoria e agli spettacoli dal vivo e ogni altro evento di divulgazione culturale. Lavorano in questo ambito scenotecnici, tecnici del suono, tecnici delle luci, tecnici degli effetti speciali, organizzatori di festival, rassegne cinematografiche, teatrali, di danza.',
				'questionIds' => [5, 19, 28, 48, 88, 125],
			],
			6 => [
				'name' => 'Corpo, movimento e sport',
				'info' => 'Gli interessa il movimento per il benessere e l’efficienza fisica propria o altrui. Partecipa direttamente, o prepara altri, a competizioni sportive oppure ad attività che coinvolgono il corpo in modo armonioso, come ad esempio la danza. In quest’area troviamo atleti, allenatori, ballerini e danzatori professionisti, insegnanti di educazione motoria.',
				'questionIds' => [6, 15, 40, 51, 68, 90],
			],
			7 => [
				'name' => 'Chimica, materiali e biotecnologie',
				'info' => 'Sono numerose le professioni relative a quest’area: genetisti, analisti degli ospedali, ricercatori in chimica e biologia, chimici delle industrie, tecnici farmaceutici, insegnanti di chimica e biologia nelle scuole e nelle università. Il professionista in quest’area ha competenze specifiche nel campo delle analisi strumentali chimico-biologiche, dei materiali, nei processi di produzione negli ambiti chimico, merceologico, biologico, farmaceutico, tintorio e conciario. Inoltre è competente nel settore della prevenzione e della gestione di situazioni a rischio ambientale e sanitario.',
				'questionIds' => [7, 27, 43, 61, 85, 112],
			],
			8 => [
				'name' => 'Alta Formazione Artistica, Musicale e Coreutica',
				'info' => 'In quest’area si formano tutte quelle figure professionali che uniscono competenze tecnico-specialistiche alla produzione e all’esecuzione creative.  Sono interessate tutte quelle istituzioni che hanno nel tempo operato per la formazione a livello di eccellenza nell\'ambito di varie discipline: per le arti figurative, plastiche, sceniche, per la decorazione e la grafica, per la musica, con riferimento al mondo degli interpreti, della composizione, della direzione, e ancora per lo spettacolo nelle sue molteplici declinazioni, dal teatro di prosa al cinema e alla televisione, dalla danza alle arti visive. Tutte queste professioni sono formate all’interno di un sistema, l’AFAM (Alta Formazione Artistica Musicale e Coreutica), che raggruppa al suo interno le Accademie di Belle Arti (statali e legalmente riconosciute), le Accademie Nazionali (Accademia Nazionale di Arte Drammatica e Accademia Nazionale di Danza), gli ISIA (Istituti Superiori per le Industrie Artistiche), i Conservatori e gli Istituti Musicali Pareggiati. ',
				'questionIds' => [8, 42, 62, 87, 109, 120],
			],
			9 => [
				'name' => 'Meccanica, meccatronica, energia',
				'info' => 'Si occupa della progettazione e costruzione di sistemi
				meccanici ed elettro-meccanici. È interessato ai processi
				produttivi e segue la fabbricazione e il monitoraggio di
				componenti meccanici. Conosce il funzionamento delle
				macchine di un’officina e sa individuare eventuali guasti.
				Opera nel campo delle diverse fonti di energia e del
				risparmio nei consumi energetici. Diverse sono le
				professioni che riguardano quest’area: progettisti di
				impianti, operai e tecnici che collaudano e controllano le
				macchine di una fabbrica, ingegneri, insegnanti in istituti
				tecnici, professionali o all’università.',
				'questionIds' => [9, 25, 45, 63, 91, 114],
			],
			10 => [
				'name' => 'Benessere e cura',
				'info' => 'Applica metodologie mirate al benessere psicofisico e sociale della persona. Il suo obiettivo primario è di favorire il mantenimento o il miglioramento della forma del cliente, dando i consigli migliori per la tutela della salute e della bellezza. Rientrano in quest’area i servizi per la sanità e l’assistenza Sociale. All’operatore che acquisisce competenze in campo sanitario, psicologico, sociologico e giuridico–economico si richiede di programmare e realizzare interventi mirati alle esigenze delle utenze tradizionali, come famiglie, minori, anziani, disabili, ma anche delle nuove e più problematiche emergenze, come immigrati e altre categorie di disagio sociale.  In quest’area operano assistenti sociali, estetiste, parrucchieri, badanti, personale delle case di riposo, infermieri, fisioterapisti, meccanici ortopedici, ottici, odontotecnici. ',
				'questionIds' => [10, 34, 53, 77, 94, 108],
			],
			11 => [
				'name' => 'Elettronica e elettrotecnica',
				'info' => 'Collabora nella progettazione, costruzione e collaudo di
				sistemi elettrici, elettronici e di automazione. Integra
				conoscenze di elettrotecnica, di elettronica e di informatica
				per intervenire nell’automazione industriale e nel
				controllo dei processi produttivi. Contribuisce al
				mantenimento della sicurezza sul lavoro e nella tutela
				ambientale. In quest’area troviamo elettricisti, riparatori di
				radio, televisioni e telefoni, ingegneri elettrici ed
				elettronici, elettrauto.',
				'questionIds' => [11, 26, 54, 71, 89, 103],
			],
			12 => [
				'name' => 'Commercio e vendita',
				'info' => 'Gestisce acquisti e vendite, occupandosi delle forniture di un negozio, redigendo e archiviando fatture commerciali, compilando listini dei prezzi, presentando o diffondendo nuovi prodotti, registrando gli incassi. L’esperto in servizi commerciali ha come obiettivo quello di inserirsi all’interno di un’azienda, in un ambito socioeconomico significativo del territorio, operando nella gestione commerciale in relazione al mercato e alla soddisfazione del cliente. Ciò significa essere coinvolto nei processi di promozione dell’immagine aziendale attraverso l’utilizzo delle diverse tipologie di strumenti di comunicazione. Operano in quest’area i negozianti, gli agenti di commercio, gli ambulanti, i commessi, il personale dei grandi magazzini, gli studiosi del mercato e delle esigenze dei clienti.',
				'questionIds' => [12, 31, 55, 75, 92, 105],
			],
			13 => [
				'name' => 'Informatica e telecomunicazioni',
				'info' => 'La figura dell’informatico si distingue in diverse professioni
				in base all’informazione trattata e alla modalità con la
				quale si tratta: si passa dall’interconnessione di computer
				e server al mondo del web marketing, fino ad arrivare
				all’analisi di grandi quantità di dati o alla creazione di siti
				web. In quest’area troviamo programmatori, addetti alle
				comunicazioni, riparatori di sistemi informatici, tecnici nei
				laboratori delle scuole, insegnanti di matematica e
				informatica nelle scuole e nelle università.',
				'questionIds' => [13, 39, 58, 69, 95, 110],
			],
			14 => [
				'name' => 'Ristorazione, enogastronomia e ospitalità alberghiera',
				'info' => 'Consente alle persone che si trovano fuori casa di bere e mangiare, cucinando o servendo cibi caldi o freddi, preparando la sala di un ristorante, consigliando vini o altre bevande, prendendo le ordinazioni dei clienti, conoscendo le norme igieniche per la conservazione dei cibi. Il professionista in enogastronomia ha competenze per intervenire nella valorizzazione, produzione, trasformazione, conservazione e presentazione dei prodotti enogastronomici, di operare nel sistema produttivo promuovendo la tipicità delle tradizioni locali, nazionali e internazionali. Nelle attività legate ai servizi di sala e di vendita si svolgono attività operative e gestionali in relazione all\'amministrazione, produzione, organizzazione, erogazione e vendita di prodotti e servizi enogastronomici, si valorizzano i prodotti tipici locali, interagendo con i clienti per trasformare il momento della ristorazione e della degustazione in un evento culturale. Per quanto riguarda l’accoglienza alberghiera, si interviene nell\'organizzazione e nella gestione delle attività di ricevimento, in relazione alla domanda stagionale e alle diverse esigenze della clientela. In quest’area operano camerieri, cuochi, pasticcieri, sommelier, maitre, operatori in alberghi, ristoranti, strutture di accoglienza turistica, nelle attività di catering e ristorazione collettiva, nelle agenzie di viaggio e nei centri congressuali ',
				'questionIds' => [14, 47, 84, 100, 113, 123],
			],
			15 => [
				'name' => 'Scienze fisiche, matematiche e della terra',
				'info' => 'La fisica è la scienza che studia i fenomeni naturali, riproducendoli, quando possibile, con esperimenti, osservandoli e misurando le grandezze che li determinano, allo scopo di individuare le relazioni tra queste e le leggi che li governano. Alle sue basi stanno il metodo sperimentale e osservativo e la formalizzazione di tali leggi tramite il linguaggio matematico. Ci sono molte branche della fisica: Fisica matematica, Fisica atomica, Fisica della materia condensata o fisica della materia, Fisica nucleare e sub-nucleare, Fisica delle particelle elementari, Astrofisica, Fisica cibernetica, Fisica medica, Geofisica, a sua volta suddivisa Sismologia e il Geomagnetismo.  Il percorso di studi è stimolante ma impegnativo. Lo scienziato che si forma in quest’area può fare il ricercatore nei laboratori specializzati oppure dedicarsi all’insegnamento nella scuola o nell’università.<br>
				La geologia è la scienza che analizza la conformazione della crosta terrestre, monitorando le mutazioni alle quali le sue componenti chimiche e fisiche sono soggette. Il geologo ha il compito fondamentale di analizzare i processi evolutivi tipici del sistema geologico terrestre, al fine di prevederne trasformazioni di sorta. Quando necessario, ha inoltre il compito di proporre metodi applicativi per contrastare danneggiamenti e squilibri strutturali. Le sue competenze trovano applicazione nella valutazione dei rischi legati all’esecuzione di  di trafori, costruzione di dighe, ponti, acquedotti ecc.',
				'questionIds' => [17, 35, 59, 83, 99, 116],
			],
			16 => [
				'name' => 'Trasporti e logistica',
				'info' => 'In un mondo sempre più globalizzato, il trasporto di merci
				e persone diventa sempre più importante. Perché il
				trasferimento di merci da un luogo all’altro avvenga nei
				tempi previsti, in modo efficiente e al minor costo
				possibile, ci devono essere degli esperti che organizzano al
				meglio lo smistamento, la movimentazione e lo
				stoccaggio. In quest’area troviamo diverse mansioni, che
				vanno dall’autista di camion all’ingegnere, dal pilota di
				aereo al controllore di scali ferroviari.',
				'questionIds' => [18, 30, 60, 86, 98, 121],
			],
			17 => [
				'name' => 'Edilizia, costruzioni e ambiente',
				'info' => 'L’Operatore edile si occupa della progettazione, costruzione e manutenzione di edifici residenziali e non residenziali, utilizza macchine operatrici edili, esegue lavori generali di scavo e movimentazione di materiali, è esperto nel disegno tecnico (architettonico, strutturale, impiantistico) e nel calcolo di pendenze, altezze e quote. In quest’area troviamo vari tipi di lavoro: operai edili, conduttori di macchinari per il movimento terra, per la perforazione in edilizia, di apparecchi di sollevamento; geometri, architetti, ingegneri edili, capi cantiere.',
				'questionIds' => [23, 36, 79, 96, 107, 124],
			],
			18 => [
				'name' => 'Area letteraria e umanistica',
				'info' => 'Studia e trasmette i valori della civiltà classica e della
				cultura umanistica. Con la sua educazione letteraria,
				storica e filosofica, può contribuire direttamente allo
				sviluppo della cultura contemporanea attraverso la
				scrittura di racconti, romanzi, opere teatrali, poesie, saggi
				o articoli per giornali e riviste specializzate oppure,
				attraverso l’insegnamento, favorisce l’accesso delle nuove
				generazioni a questo mondo culturale.',
				'questionIds' => [24, 49, 74, 97, 106, 122],
			],
			19 => [
				'name' => 'Area linguistica',
				'info' => 'È attratto dalle culture, dalle lingue e dai modi di vita di
				popoli diversi dal suo.
				Ama viaggiare e interagire con i cittadini di un paese
				straniero, sia per motivi di lavoro che di svago. Pratica
				diverse lingue straniere sia in forma orale che scritta.
				Conosce le strutture grammaticali delle lingue per farne un
				uso corretto. La padronanza delle lingue apre la strada a
				diverse professioni: interpreti, traduttori, guide turistiche,
				responsabili dei rapporti internazionali delle ditte,
				insegnanti di lingua e letteratura straniera nelle scuole e
				all’università.',
				'questionIds' => [29, 44, 65, 81, 115, 118],
			],
			20 => [
				'name' => 'Scienze umane e della Formazione',
				'info' => 'In quest’area troviamo diverse professioni: sociologi, antropologi, psicologi ed insegnanti di diverse discipline e in diversi cicli di studi. Il sociologo studia, analizza, comprende e monitora i fenomeni sociali. Per fare questo, il professionista si serve di diversi strumenti, competenze e conoscenze, così da poter elaborare teorie e modelli in modo da spiegare la molteplicità delle interazioni sociali, mettere in relazione i dati ottenuti dalle varie analisi con metodi statistici, fare consulenza su tematiche socio-politiche/economiche/culturali. L\'antropologo studia l\'essere umano nelle sue caratteristiche storiche, culturali, linguistiche, sociali, economiche, geografiche ed etnologiche e applica i risultati delle sue analisi in svariati ambiti, evidenziando linee evolutive, strutture sociali, comportamenti, modalità di agire collettivo. Lo psicologo si occupa di interventi di prevenzione, diagnosi e cura del disagio psicologico ed emotivo. La sua attività comprende lo studio e l\'analisi dei processi psichici, mentali e cognitivi (consci e inconsci), ed è mirata a fornire sostegno psicologico a individui, coppie, gruppi, comunità. La finalità dello psicologo è miglioramento del benessere relazionale e sociale e la crescita personale dei pazienti, per un miglioramento della qualità della vita in tutti i contesti (famiglia, scuola, lavoro, società). L’educatore è interessato alla formazione e alla socializzazione, in particolare delle persone in difficoltà. Conosce i vari sistemi educativi e ha le competenze per operare su diverse fasce d’età, dai bambini delle materne agli adolescenti delle scuole superiori. Lavorano in quest’ambito insegnanti, educatori, assistenti sociali, animatori, pedagogisti, orientatori.',
				'questionIds' => [46, 64, 66, 70, 111, 119],
			],
			21 => [
				'name' => 'Navigazione',
				'info' => 'L’esperto in quest’area conosce e utilizza le metodologie, le tecniche, gli strumenti per la navigazione e per studiare il clima. Studiare come si governa una nave nelle diverse situazioni climatiche e ambientali.  Approfondire conoscenze riguardanti la fisica atmosferica, l’oceano e il clima, l’assistenza delle strutture tecnico-commerciali, la gestione della sicurezza in fase di prevenzione ed emergenza, nell’ambito della navigazione.',
				'questionIds' => [32, 72, 80, 104, 117, 126],
			],
		]
	],

	// 101 L'albero della vita
	101 => ['characters' => [
		__("tests.101-choice-1"),
		__("tests.101-choice-2"),
		__("tests.101-choice-3"),
		__("tests.101-choice-4"),
		__("tests.101-choice-5"),
		__("tests.101-choice-6"),
		__("tests.101-choice-7"),
		__("tests.101-choice-8"),
		__("tests.101-choice-9"),
		__("tests.101-choice-10"),
		__("tests.101-choice-11"),
		__("tests.101-choice-12"),
		__("tests.101-choice-13"),
		__("tests.101-choice-14"),
		__("tests.101-choice-15"),
		__("tests.101-choice-16"),
		__("tests.101-choice-17"),
		__("tests.101-choice-18"),
		__("tests.101-choice-19"),
		__("tests.101-choice-20"),
	]],

	// 116 la ruota delle emozioni
	116 => ['emotions' => ['paura', 'spavento', 'sorpresa', 'delusione', 'tristezza', 'rimorso', 'schifo', 'disprezzo', 'collera', 'aggressività', 'aspettativa', 'ottimismo', 'gioia', 'amore', 'accettazione', 'sottomissione']],
];
