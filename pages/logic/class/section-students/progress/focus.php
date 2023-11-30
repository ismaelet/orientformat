<?php

use Activity\Area;
use Activity\Section;
use SchoolSystem\Grade;
use UserSystem\Student;

$watchedStudentId = $_GET['studentId'];
$watchedStudent = new Student($watchedStudentId);

if ($watchedStudent->schoolClassId != schoolClassId()) {
	redirect('/class');
}

// fetch areas and sections
$grades = [];
$sections = [];
$actions = [];
$areaObjects = rows_to_objects(DB::select('id, name FROM ' . Area::TABLE . ' ORDER BY id ASC'), Area::class);

for ($i = schoolClass()->currentGrade; $i >= schoolClass()->minimumGrade; $i--) {
	$grade = new Grade($i, schoolClass());
	$areas = [];

	foreach ($areaObjects as $areaObject) {
		$area['id'] = $areaObject->id;
		$area['name'] = $areaObject->name;
		$area['sections'] = [];

		$sections = DB::select('id FROM ' . Section::TABLE . ' WHERE ' . Section::INDEX . ' IN (' . $grade->doableSectionIdsString . ') AND ' . Section::AREA_INDEX . ' = ? ORDER BY id ASC', [$areaObject->id]);

		while ($sectionData = $sections->fetch_assoc()) {
			$section = new Section($sectionData['id']);
			$urlTemplate = $section->area->slug . '/section?id=' . $section->id . '&studentId=' . $watchedStudentId . '&test-id=';

			switch ($section->id) {
					// Stili
				case 1:
					$actions[$section->id] = [
						['Mappa degli stili', 31, $urlTemplate],
					];
					break;
				case 37:
					$actions[$section->id] = [
						['Mappa degli stili', 113, $urlTemplate],
					];
					break;




				case 3:
					$actions[$section->id] = [
						['Vedi risultato', 50, $urlTemplate],
					];
					break;

					// Autostima
				case 4:
					$actions[$section->id] = [
						['Grafico dei risultati', 15, $urlTemplate],
					];
					break;
				case 41:
					$actions[$section->id] = [
						['Grafico dei risultati', 146, $urlTemplate],
					];
					break;

					// Risolvere i problemi
				case 5:
					$actions[$section->id] = [
						['Risultati dell\'autovalutazione', 94, $urlTemplate],
						['Risultati di "Anagramma indovinello"', 123, $urlTemplate],
						['Risultati di "Scopri il personaggio"', 124, $urlTemplate],
					];
					break;
				case 38:
					$actions[$section->id] = [
						['Risultati dell\'autovalutazione', 162, $urlTemplate],
						['Risultati di "Somma numerica"', 4, $urlTemplate],
						['Risultati di "Unisci i punti"', 5, $urlTemplate],
						['Risultati di "Sagome"', 13, $urlTemplate],
						['Risultati di "La ruota di scorta"', 161, $urlTemplate],
					];
					break;
				case 42:
					$actions[$section->id] = [
						['Risultati di "Completamento numerico"', 3, $urlTemplate],
						['Risultati di "Cerchi"', 148, $urlTemplate],
						['Risultati di "I Criptogrammi"', 169, $urlTemplate],
					];
					break;


				case 6:
					$actions[$section->id] = [
						['Risultati del questionario', 47, $urlTemplate],
						['Risultati elaborati', 48, $urlTemplate],
					];
					break;
				case 7:
					$actions[$section->id] = [
						['Mappa degli interessi', 20, $urlTemplate],
						['Risultati del confronto', 24, $urlTemplate],
					];
					break;
				case 8:
					$actions[$section->id] = [
						['Risultati delle autovalutazioni', 46, $urlTemplate],
					];
					break;
				case 9:
					$actions[$section->id] = [
						['Risultati della mappa', 16, $urlTemplate],
						['Risultati dell\'autovalutazione', 21, $urlTemplate],
					];
					break;

					// Ricordare
				case 10:
					$actions[$section->id] = [
						['Risultati dell\'autovalutazione', 52, $urlTemplate],
						['Risultati di "Figure astratte"', 54, $urlTemplate],
					];
					break;
				case 49:
					$actions[$section->id] = [
						['Risultati dell\'autovalutazione', 160, $urlTemplate],
						['Risultati di "Concetti"', 55, $urlTemplate],
					];
					break;

					// Ascoltare
				case 11:
					$actions[$section->id] = [
						['Risultati dell\'autovalutazione', 27, $urlTemplate],
						['Risultati del racconto', 96, $urlTemplate],
					];
					break;
				case 48:
					$actions[$section->id] = [
						['Risultati dell\'autovalutazione', 157, $urlTemplate],
						['Risultati del racconto', 158, $urlTemplate],
					];
					break;

					// Parlare
				case 12:
					$actions[$section->id] = [
						['Risultati dell\'autovalutazione', 59, $urlTemplate],
						['Risultato dell\'esposizione', 65, $urlTemplate],
					];
					break;
				case 50:
					$actions[$section->id] = [
						['Risultati dell\'autovalutazione', 165, $urlTemplate],
						['Risultati della relazione', 166, $urlTemplate],
					];
					break;

					// Leggere
				case 13:
					$actions[$section->id] = [
						['Risultati dell\'autovalutazione', 98, $urlTemplate],
						['Risultati dall\'attività "L\'Intreccio"', 69, $urlTemplate],
						['Risultati dall\'attività "Analisi dei personaggi"', 71, $urlTemplate],
					];
					break;

					// Scrivere
				case 14:
					$actions[$section->id] = [
						['Risultati dell\'autovalutazione', 61, $urlTemplate],
						['Risultati di "La punteggiatura nelle frasi"', 139, $urlTemplate],
					];
					break;
				case 51:
					$actions[$section->id] = [
						['Risultati dell\'autovalutazione', 170, $urlTemplate],
						['Mappa dei tipi di scrittura', 168, $urlTemplate],
					];
					break;
				case 55:
					$actions[$section->id] = [
						['Risultati dell\'autovalutazione', 180, $urlTemplate],
						['Risultati di "Da discorso diretto a indiretto"', 183, $urlTemplate],
						['Risultati di "Da discorso indiretto a diretto"', 184, $urlTemplate],
						['Risultati di "La punteggiatura nel testo"', 182, $urlTemplate],
					];
					break;
				case 57:
					$actions[$section->id] = [
						['Risultati dell\'autovalutazione', 195, $urlTemplate],
						['Risultati di "La punteggiatura - 1"', 196, $urlTemplate],
						['Risultati di "La punteggiatura - 2"', 197, $urlTemplate],
					];
					break;


				case 15:
					$actions[$section->id] = [
						['Risultati dell\'autovalutazione', 35, $urlTemplate],
						['Risultati dall\'attività "Schematizzare"', 38, $urlTemplate],
						['Risultati dall\'attività "Riassumere"', 39, $urlTemplate],
					];
					break;
				case 17:
					$actions[$section->id] = [
						['Risultati delle autovalutazioni', 81, $urlTemplate],
					];
					break;
				case 18:
					$actions[$section->id] = [
						['Esamina l\'albero', 82, $urlTemplate],
					];
					break;
				case 24:
					$actions[$section->id] = [
						['Vedi i risultati', 92, $urlTemplate],
					];
					break;
				case 25:
					$actions[$section->id] = [
						['Vedi i risultati', 100, $urlTemplate],
					];
					break;
				case 26:
					$actions[$section->id] = [
						['Vedi i risultati', 101, $urlTemplate],
					];
					break;
				case 27:
					$actions[$section->id] = [
						['Vedi i risultati', 116, $urlTemplate],
					];
					break;
				case 28:
					$actions[$section->id] = [
						['Mappa degli stili', 109, $urlTemplate],
						['Risultato visivo o uditivo', 114, $urlTemplate],
					];
					break;
				case 29:
					$actions[$section->id] = [
						['Grafico dei risultati', 107, $urlTemplate],
					];
					break;
				case 30:
					$actions[$section->id] = [
						['Risultati dell\'autovalutazione', 119, $urlTemplate],
						['Risultati di "Le Sagome"', 120, $urlTemplate],
						['Risultati di "I Quadrati"', 121, $urlTemplate],
						['Risultati di "I Topi"', 122, $urlTemplate],
					];
					break;
				case 31:
					$actions[$section->id] = [
						['Risultati dell\'autovalutazione', 117, $urlTemplate],
						['Risultati di "Trova le combinazioni"', 118, $urlTemplate],
					];
					break;
				case 32:
					$actions[$section->id] = [
						['Risultati dell\'autovalutazione', 126, $urlTemplate],
					];
					break;
				case 33:
					$actions[$section->id] = [
						['Risultati dell\'autovalutazione', 137, $urlTemplate],
						['Risultati del racconto', 138, $urlTemplate],
					];
					break;
				case 34:
					$actions[$section->id] = [
						['Mappa dei tipi di scrittura', 63, $urlTemplate],
						['Risultati di "Scopri gli errori"', 135, $urlTemplate],
					];
					break;
				case 36:
					$actions[$section->id] = [
						['Mappa degli stili', 111, $urlTemplate],
					];
					break;
				case 39:
					$actions[$section->id] = [
						['Risultati dell\'autovalutazione', 130, $urlTemplate],
						['Risultati di "Analizzare"', 37, $urlTemplate],
						['Risultati di "Schematizzare"', 38, $urlTemplate],
						['Risultati di "Riassumere"', 39, $urlTemplate],
					];
					break;
				case 40:
					$actions[$section->id] = [
						['Risultati dell\'autovalutazione', 131, $urlTemplate],
						['Risultati di "Analizzare"', 132, $urlTemplate],
						['Risultati di "Schematizzare"', 133, $urlTemplate],
					];
					break;
				case 45:
					$actions[$section->id] = [
						['Vedi i risultati', 151, $urlTemplate],
					];
					break;
				case 47:
					$actions[$section->id] = [
						['Risultati dell\'autovalutazione', 154, $urlTemplate],
						['Risultati di "Il Racconto - Nemesi"', 155, $urlTemplate],
					];
					break;
			}

			$area['sections'][] = $section;
		}

		if ($sections->num_rows) {
			$areas[] = $area;
		}
	}

	$grades[] = [
		'title' => 'Attività del ' . $grade->adjective . ' anno',
		'areas' => $areas,
	];
}

$infos = [
	1 => "Un’attenzione particolare dovrebbe essere dedicata agli stili polarizzati, ad esempio
	molto VISIVO e poco o niente UDITIVO, molto ANALITICO e poco o niente GLOBALE, e
	così via. In questi casi, i dati emersi dal test dovrebbero essere corroborati anche
	dall’osservazione diretta e dovrebbero essere segnalati in Consiglio di classe, perché
	si potrebbero creare delle incompatibilità di stile docente-studente, con esiti dannosi
	per la relazione educativa, se non se ne prende consapevolezza. Inoltre nelle
	valutazioni si dovrebbe tenere conto del fatto che certi compiti, come ad esempio le
	prove di comprensione Invalsi, premiano particolari stili e puniscono, o non
	valorizzano adeguatamente, gli stili opposti.",
	3 => "Se emergono dei punteggi significativamente bassi e, soprattutto, se pensiamo di
	avere a che fare con alunni isolati, che non hanno avuto modo di condividere con
	qualcuno la loro autovalutazione, è opportuno approfondire per un certo tempo
	l’osservazione in modo distaccato e informale. Se le percezioni che ne ricaviamo
	confermano i dati del test, si può pensare, con le opportune cautele, di interloquire
	direttamente col soggetto oppure, se possibile, con qualche familiare o amico/a, per
	verificare se ci sono stati eventi particolari che possano giustificare una maggiore
	fragilità emotiva.",
	4 => "Dovrebbero richiamare la nostra attenzione dei risultati molto bassi,
	significativamente al di sotto della media della classe, sia dal punto di vista globale sia
	in qualche area in particolare, ad esempio “Come mi sento” o “I rapporti con gli altri”.
	I dati del test forniscono solo la spinta iniziale a un’osservazione più sistematica. Se i
	dati indiziari dovessero confermare l’autovalutazione dello studente, allora si
	dovrebbe pensare a qualche forma di intervento. Anche un’autostima
	irrealisticamente alta, in base alla nostra percezione del soggetto, potrebbe segnalare
	o un ritardo e un’immaturità rilevanti nella costruzione del sé oppure uno stato di
	disagio che si vuole esorcizzare con una fuga dalla realtà.",
	5 => "Particolarmente significative sono le risposte agli insuccessi, perché segnalano il
	grado di tollerabilità alle frustrazioni, i livelli d’ansia, la fiducia/sfiducia nelle proprie
	capacità, il particolare stile attributivo. È interessante notare, se possibile, la quantità
	di impegno manifestata, pur in assenza, come nel nostro caso, di una gratificazione
	valutativa come avviene nelle prestazioni scolastiche. Una scarsa disponibilità a
	mettersi in gioco e a tollerare gli insuccessi, se confermata nel tempo, dovrebbe
	dissuadere dall’affrontare studi particolarmente impegnativi.",
	6 => "Studenti con obiettivi di conferma attraverso la prestazione, quindi con uno stile
	attributivo che abbiamo definito “abilità”, i quali riferiscono alla propria intrinseca
	capacità o incapacità le ragioni fondamentali del successo o dell’insuccesso,
	dovrebbero farci scattare un campanello di allarme: in caso di insuccesso, prima o poi
	inevitabile per chiunque, è probabile l’innesco di quel circolo vizioso che viene
	definito “impotenza appresa”. La tematica dello stile attributivo, in particolare lo stile
	“esterno”, particolarmente insidioso, più di altre tematiche si presta e richiede,
	magari partendo da casi particolari, una riflessione e una discussione aperta con tutta
	la classe.",
	7 => "In quest’area si evidenziano in modo più generico le propensioni di fondo, le diverse
	“intelligenze”, mentre nell’area Scegliere emergerà un profilo degli interessi più
	preciso. In molti casi si riscontrerà una scarsa differenziazione fra le diverse aree
	motivazionali. Ciò potrebbe significare sia una notevole molteplicità di interessi sia
	una permanente immaturità, del tutto comprensibile in questa fase di sviluppo.",
	8 => "I dati che ricaviamo da questa sezione non ci danno uno spaccato della personalità del
	soggetto, ma ci forniscono un quadro di ipotesi che l’alunno/a sta elaborando su di sé
	e che faciliteranno certamente il percorso di auto-scoperta e auto-identificazione.
	Particolarmente significativi i dati che segnalano instabilità emotiva o rifiuto delle
	novità, perché potrebbero indicare una fase di difficoltà e disagio, per fronteggiare i
	quali viene richiesto un aiuto all’adulto. Invece le dimensioni dell’estroversione-
	socievolezza e coscienziosità si prestano efficacemente a riflessioni e discussioni in
	classe, per far emergere la relatività di modelli acriticamente assunti come universali
	(vedi l’estroversione) e l’opportunità, negli studi e nella vita, di incrementare i livelli di
	coscienziosità, che spesso si coniuga con affidabilità.",
	9 => "I problemi di attenzione si manifestano, e spesso si originano, in un contesto
	interattivo come è la classe. La variabile ambientale – il setting, i compagni, il tipo di
	lezione, il livello di difficoltà del compito –, si collega alla predisposizione individuale
	nell’affrontare i problemi. Pertanto i dati di questa sezione acquistano maggiore
	rilievo se utilizzati comparativamente a livello di classe. Sarà utile, in alcuni casi,
	sottoporre l’autovalutazione del singolo studente su attenzione e iperattività ai
	diversi docenti del Consiglio di classe, per verificare convergenze o divergenze
	valutative. In ogni caso, l’avvio di una presa di consapevolezza da parte del soggetto,
	possibilmente condivisa con altre figure, l’orientatore in primis, è già la prima tappa di
	un lento ma progressivo recupero.",
	10 => "I dati che emergono in questa sezione possono essere utilmente correlati con il test
	sugli stili cognitivi, per verificare eventuali convergenze con stili polari. È importante
	quanto ci dice lo studente sulla presenza/assenza di strategie di memorizzazione. Ad
	esempio, se al quesito 8 dell’autovalutazione (“So quando ripetere per non
	dimenticare”) abbiamo una risposta negativa, si pone evidentemente un problema di
	intervento e di supporto da parte del docente. Interrogarsi sul proprio modo di
	ricordare è già l’avvio di una strategia metacognitiva che col tempo non può non
	produrre risultati.",
	11 => "L’ascolto di un racconto, che abbiamo proposto in questa sezione, è un’attività molto
	comune nell’ambito della disciplina Italiano. Tuttavia in questo caso l’esercizio serve
	solo allo studente perché si renda conto se la sua valutazione è fondata e veritiera
	oppure no. L’ascoltare è una competenza che attraversa tutte le discipline e i più
	svariati contesti di vita. Se dovesse emergere una discordanza fra l’autovalutazione
	dello studente e la percezione delle sue prestazioni da parte dei docenti segnalerebbe
	la necessità di un’osservazione più approfondita e di un confronto insegnante-
	studente.",
	12 => "Parlare è una competenza complessa nella quale convergono molte funzioni diverse,
	che variano in base alle situazioni, agli interlocutori e agli scopi. Non è facile in classe
	creare le condizioni perché tali funzioni si possano dispiegare e incrementare. Per
	questo sono forniti dei descrittori autovalutativi che lo studente possa attivare in
	autonomia anche in contesti diversi da quello scolastico. I risultati complessivi dei
	questionari dovrebbero fornire ai docenti un quadro delle funzioni che sono state
	maggiormente trascurate e, implicitamente, suggerire delle attività per porvi rimedio.",
	13 => "Questa sezione presuppone acquisita la lettura di tipo strumentale. Per lo studente
	dislessico si renderà necessaria una mediazione da parte di un adulto, in classe o a
	casa, o quanto meno la possibilità di usare consuetamente un sintetizzatore vocale. I
	descrittori di competenza invitano l’alunno/a ad un’autovalutazione a diversi livelli di
	complessità corrispondenti a diverse tipologie di lettura: esplorativa, analitica e
	critica. Il livello di padronanza al quale lo studente si collocherà per ogni descrittore,
	se troverà conferma da parte del docente, sarà indicativo per l’orientamento verso
	studi più teorici o più pratici.",
	14 => "La competenza di scrittura è trasversale a tutte le discipline e a diversi contesti di vita.
	È di fondamentale importanza far acquisire una conoscenza metacognitiva e una
	consapevolezza autovalutativa dei processi che governano la scrittura (o le scritture).
	I dati che emergeranno dai questionari dovrebbero fornire utili indicazioni per la
	progettazione di laboratori di scrittura a ciò finalizzati.",
	15 => "L’imparare come si impara è certamente una delle competenze più fondamentali per
	lo studio e per la vita. Il confronto fra i dati dei singoli studenti con i dati aggregati
	della classe e dell’intera comunità coinvolta nel progetto potrà fornire l’occasione,
	per l’orientatore, di farne oggetto di riflessione comune con i colleghi. Dal punto di
	vista del singolo studente, il possesso di un efficace metodo di studio è una
	condizione necessaria e una garanzia per il prosieguo degli studi. In caso di carenze, si
	renderà necessario un intervento educativo, a livello di individui o di gruppi.",
	17 => "Sappiamo che ci sono diversi alunni, più numerosi di quanto si immagini, che hanno
	una dotazione cognitiva che non trova modi di realizzarsi nella scuola. Sono studenti
	che si annoiano, sprecando risorse che risulterebbero preziose se adeguatamente
	riconosciute e convogliate. Il fiore della creatività, che viene proposto come riepilogo
	in questa sezione, può far emergere quelle competenze, acquisite fuori dalla scuola, e
	debordanti dai confini strettamente disciplinari, che potrebbero innescare progetti,
	far inventare lavori, trovare sbocchi promettenti per l’autorealizzazione personale.",
	18 => "È importante acquisire consapevolezza di ciò che si sa fare o che si vorrebbe
	perfezionare, alimentare passioni, condividerle con altri. Non si nasce esperti, ma lo si
	diviene quanto più forte è la richiesta da parte degli altri; i quali, a loro volta, devono
	essere nella condizione di sapere quali richieste rivolgere. È improbabile – ma non
	impossibile - che i rami dell’albero abbiano un grande sviluppo. Qualche sapere
	informale inatteso potrebbe aprire delle prospettive interessanti nella conoscenza
	dell’alunno/a, non solo da parte dei docenti, ma anche dei compagni di classe.",
	25 => "Questa sezione serve a conoscersi e a conoscere i compagni di classe. L’utilizzo avviene in due momenti: prima la riflessione personale e poi la condivisione in classe. È uno strumento non solo di auto-orientamento, ma anche di conoscenza reciproca per creare coesione, per formare gruppo.",
	26 => "Nella presentazione della sezione va ribadito che le figure sull’albero non rappresentano un’identità, un destino, ma un momento particolare soggetto a mutamento. Tuttavia deve essere dedicata particolare attenzione ai casi problematici (figurine tristi, rassegnate, minacciate), che potrebbero segnalare una forte richiesta di aiuto.",
	27 => "Questa sezione, oltre alla focalizzazione sulla propria sfera affettiva da parte dell’alunno, fornisce la base e lo spunto per attivare percorsi di educazione all’affettività che possono incrociare diverse discipline: italiano (narrativa, poesia), musica, artistica, scienze. Importante è sottolineare il fatto che le emozioni si presentano con diversi livelli di intensità (ad esempio: apprensione-paura-terrore, irritazione-collera-furia) e che sono, almeno in parte, controllabili razionalmente.   ",
];

$infos[36] = $infos[1];
$infos[37] = $infos[1];
