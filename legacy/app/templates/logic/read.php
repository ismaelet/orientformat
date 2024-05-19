<?php

//setup page
\App\Legacy\LegacyView::setTitle('Approfondisci');

//setup variables
$glossary = [
	['A', [
		['Atteggiamento', 'atteggiamento'],
		['Attenzione', 'attenzione'],
		['Automonitoraggio', 'automonitoraggio'],
		['Autorappresentazione', 'autorappresentazione'],
		['Autoregolazione fine', 'autoregolazione'],
		['Autostima', 'autostima'],
	]],
	['C', [
		['Carattere', 'carattere'],
		['Competenza', 'competenza'],
		['Conscio-Inconscio-Preconscio', 'conscio'],
		['Coscienziosità', 'coscienziosita'],
		['Costituzione', 'costituzione'],
	]],
	['E', [
		['Emozione (o Stato d’animo)', 'emozione'],
		['Estroverso-Introverso', 'estroverso'],
	]],
	['I', [
		['Identità personale', 'identita'],
		['Intelligenza/e', 'intelligenza'],
		['Interesse', 'interesse'],
		['Iperattività', 'iperattivita'],
	]],
	['M', [
		['Memoria', 'memoria'],
		['Metacognizione', 'metacognizione'],
		['Metodo', 'metodo'],
		['Motivazione', 'motivazione'],
	]],
	['N', [
		['Nevrosi', 'nevrosi'],
		['Nevroticismo', 'nevroticismo'],
	]],
	['O', [
		['Originalità', 'originalita'],
	]],
	['P', [
		['Persona', 'persona'],
		['Personalità', 'personalita'],
		['Problema', 'problema'],
	]],
	['R', [
		['Rappresentazione', 'rappresentazione'],
		['Resilienza', 'resilienza'],
		['Rete neurale', 'rete'],
	]],
	['S', [
		['Socievolezza (o “Amicalità”)', 'socievolezza'],
		['Stabilità emotiva', 'stabilità'],
		['Stato d\'animo', 'stato'],
		['Stile', 'stile'],
		['Stile attributivo', 'attributivo'],
		['Strategia', 'strategia'],
	]],
	['T', [
		['Temperamento', 'temperamento'],
		['Teoria', 'teoria'],
	]],
];

$entries = [
	[
		'title' => 'Atteggiamento',
		'tag' => 'atteggiamento',
		'text' => "È un orientamento profondo, solo in parte consapevole, che si manifesta in comportamenti non sempre lineari. Alcuni comportamenti infatti tendono più a coprire e a dissimulare l’atteggiamento più che a svelarlo. Così possiamo avere dei comportamenti apparentemente cordiali che nascondono un’ostilità di fondo,  oppure una discordanza, che si manifesta solo in modo sintomatico, tra opinioni chiaramente espresse (ad esempio predicare la fratellanza e la solidarietà) ed emozioni o stati d’animo provati in modo latente (ad esempio diffidenza ed ostilità). Nell’atteggiamento quindi si mescolano, spesso inestricabilmente, idee, giudizi, sentimenti, percezioni e pregiudizi.",
	],
	[
		'title' => 'Attenzione',
		'tag' => 'attenzione',
		'text' => "L’attenzione è, insieme con la <a href='#g-memoria' class='link'>memoria</a>, un’abilità di base: se all’attenzione compete la funzione di selezionare gli stimoli ritenuti più rilevanti, alla memoria spetterà il compito do conservarli per tempi variabili, dalla frazione di secondo a molti anni. 
	   La nostra capacità attenzionale è limitata. Se l’elaborazione non lavora in automatico (sistema attenzionale di base), il mantenimento degli stimoli filtrati consapevolmente è regolato da una competizione selettiva, che ne facilita alcuni e ne inibisce altri. L’attenzione volontaria è legata all’interesse e alla motivazione e risente fortemente degli <a href='#g-stile' class='link'>stili cognitivi</a> del soggetto e dall’immagine di sé (v. <a href='#g-autorappresentazione' class='link'>autorappresentazione</a>): pur di tutelare tale immagine, si seguono vie antieconomiche di conferma delle proprie ipotesi piuttosto che seguire strategie più comode e rapide di smentita.",
	],
	[
		'title' => 'Automonitoraggio',
		'tag' => 'automonitoraggio',
		'text' => "Un grado elevato di automonitoraggio è la condizione necessaria perché ci possa essere un’ <a href='#g-autorappresentazione' class='link'>autorappresentazione</a> sufficientemente ricca e consapevole, la quale, a sua volta, consente un’alta variabilità trans-situazionale, ossia un efficace adeguamento alle diverse situazioni sociali. Viceversa, un automonitoraggio scarso coincide con una presentazione di sé incerta, stereotipa, inefficace e facilmente prevedibile, che prelude ad un adattamento inefficace e rigido a contesti diversi e mutevoli.",
	],
	[
		'title' => 'Autorappresentazione',
		'tag' => 'autorappresentazione',
		'text' => "La rappresentazione di sé è il risultato di un lungo processo autoconoscitivo. Per costruire un’immagine articolata, complessa e coerente di sé, il soggetto utilizza una gran mole di dati, tra i quali acquistano un’importanza primaria quelli provenienti dalle relazioni con le figure più importanti, prime fra tutte quelle  genitoriali. Attraverso lo specchio degli altri, le loro reazioni e narrazioni esplicite su di lui, l’individuo è in grado di elaborare e consolidare una sua autopresentazione o autonarrazione.",
	],
	[
		'title' => 'Autoregolazione fine',
		'tag' => 'autoregolazione',
		'text' => "È uno dei fattori che entrano in gioco nella <a href='#g-metacognizione' class='link'>metacognizione</a>.  Consiste nel fatto di accorgersi per tempo che si sta entrando in una situazione di difficoltà, di reagire a ciò, di identificare le fonti di disagio, di eliminarle e di prevenire problemi simili in futuro.",
	],
	[
		'title' => 'Autostima',
		'tag' => 'autostima',
		'text' => "È la valutazione delle informazioni possedute da un individuo su se stesso, una valutazione del concetto di sé (v, <a href='#g-autorappresentazione' class='link'>autorappresentazione</a>). Nell’autostima entrano in gioco, come protagonisti fondamentali, il sé percepito e il sé ideale. L’autostima è la misura della discrepanza fra queste due variabili: discrepanza elevata significa bassa autostima, discrepanza bassa significa autostima alta.",
	],

	[
		'title' => 'Carattere',
		'tag' => 'carattere',
		'text' => "Termine che indica la particolare indole di una <a href='#g-persona' class='link'>persona</a>, che si manifesta attraverso particolari schemi di condotta. È spesso associato, fino ad essere quasi indistinguibile, ai termini <a href='#g-costituzione' class='link'>costituzione</a>” e <a href='#g-temperamento' class='link'>temperamento</a>”. Eysenck (1947) ne enfatizza l’aspetto conativo, vale a dire la tendenza ad agire in modo finalizzato sulla base dell’ istinto e  del desiderio.",
	],
	[
		'title' => 'Competenza',
		'tag' => 'competenza',
		'text' => "Occorre distinguere “competenza” da “abilità”, termine col quale viene spesso confuso. Mentre il secondo fa parte  della sfera dell’avere, da cui deriva anche etimologicamente, il primo, la competenza, fa parte dell’essere: si ha un’abilità, si è competenti. L’abilità, il saper fare, è solo uno degli elementi costitutivi di una competenza. Si devono infatti introdurre almeno altri due aspetti oltre all’abilità: le conoscenze e gli atteggiamenti o “disposizioni interne”. È utile immaginare la competenza come un triangolo a cui vertici si trovano appunto le tre variabili dette: conoscenze, abilità, disposizioni interne. Secondo il tipo di compito, l’esecuzione richiesta tenderà a manifestare di più un aspetto e meno gli altri due. Inoltre, fanno da sfondo ad una competenza anche altre dimensioni, come le capacità o potenzialità innate,  gli <a href='#g-stile' class='link'>stili</a>, il <a href='#g-temperamento' class='link'>temperamento</a> e altre ancora. 
	   Quanto più un compito è difficile, tanto maggiormente evidenzia la competenza coinvolta. Possiamo dire che il livello di complessità è indicativo del livello di competenza. C’è però un’altra variabile fondamentale che caratterizza ogni compito, ed è il grado di familiarità o, viceversa, di novità di un compito. È su questa variabile che entrano in gioco i fattori psicologici, gli <a href='#g-atteggiamento' class='link'>atteggiamenti</a>, le disposizioni interne. La novità comporta sfida, che sarà tanto più intensa quanto più complesso è il compito.",
	],
	[
		'title' => 'Conscio-Inconscio-Preconscio',
		'tag' => 'conscio',
		'text' => "La scoperta di una dimensione inconscia che, in quanto tale, sfugge alla consapevolezza e al controllo critico, si può far risalire molto indietro nel tempo, almeno a Eraclito e a Empedocle. Nota anche in San Paolo, viene tuttavia riscoperta da filosofi come Leibniz, Kant, Schelling e, soprattutto, Schopenauer, al quale Freud, che per primo ne fornì una trattazione scientifica, si riconobbe debitore. Nella teoria psicanalitica freudiana l’inconscio è descritto come un sistema i cui contenuti sono i rappresentanti delle pulsioni. Tali contenuti rimossi tentano di accedere al sistema preconscio-conscio, ma, sottoposti a “censura”, possono emergere solo in modo deformato attraverso sogni, sintomi, lapsus o atti mancati, la cui interpretazione è il compito fondamentale dell’analista. Jung affianca ad un inconscio individuale un inconscio collettivo, che in parte struttura anche la psiche individuale. Con Jung l’inconscio perde quella caratterizzazione preminentemente sessuale e negativa che aveva in Freud, e gli si riconosce una funzione importante per la creatività e la crescita del soggetto. L’energia psichica, chiamata talvolta “libido”, che promana dall’inconscio, è concepita da Jung come una costante tensione dell’uomo, che si manifesta attraverso i suoi desideri e la sua volontà di autorealizzazione. 
	   Il preconscio è una dimensione intermedia fra l’inconscio e il conscio. Vi si trovano i contenuti che, pur non disponibili direttamente alla coscienza, sono tuttavia accessibili, come ad esempio un ricordo attivamente cercato dal soggetto. Dopo Freud, al preconscio è stata riconosciuta una funzione importante nei processi creativi.",
	],
	[
		'title' => 'Coscienziosità',
		'tag' => 'coscienziosita',
		'text' => "È una delle cinque aree del modello <a href='" . client_url('/read?id=8#bigfive') . "' class='link'>Big Five</a>, col quale abbiamo cercato di evidenziare le caratteristiche temperamentali. Il termine è associabile con “affidabilità” e “costanza”, che solitamente correlano con uno <a href='#g-stile' class='link'>stile cognitivo</a> sistematico  e con i modi di agire che abbiamo definito metodico e pianificatore.",
	],
	[
		'title' => 'Costituzione',
		'tag' => 'costituzione',
		'text' => "È un termine che, al pari dei concetti affini di <a href='#g-carattere' class='link'>carattere</a> e di <a href='#g-temperamento' class='link'>temperamento</a>, è stato usato nei secoli in modo differente in base all’epoca e ai settori di indagine. Oggi si tende a identificarlo col concetto di ereditarietà, con particolare accentuazione degli aspetti biologici che caratterizzano l’individuo.",
	],
	[
		'title' => 'Emozione (o Stato d’animo)',
		'tag' => 'emozione',
		'text' => "L’emozione è una reazione ad uno stimolo ed è costituita da una sequenza complessa di eventi, in cui entrano aspetti di giudizio cognitivo, sentimento, impulso all’azione e comportamento manifesto. Come scoprì Darwin, le emozioni, rispondendo a situazioni di emergenza e comunicando fisicamente le intenzioni di chi le prova, svolgono importanti funzioni, che hanno accresciuto le probabilità di sopravvivenza delle specie. È molto importante poter distinguere il comportamento manifesto dalla funzione corrispondente. Mentre un comportamento può risultare inadeguato o inaccettabile, e per questo va rifiutato e corretto, sarebbe sbagliato e controproducente rifiutare anche la funzione svolta da una certa emozione.  La premessa indispensabile per poter gestire le proprie emozioni e interagire positivamente con quelle altrui  è che si sappiano riconoscere e nominare. È tuttavia una competenza  linguistica, culturale e introspettiva piuttosto complessa, che, se si è adeguatamente stimolati, si acquisisce gradualmente. L’obiettivo generale deve essere la consapevolezza dei propri stati emotivi e dei meccanismi cognitivi che li influenzano, positivamente o negativamente. Ne conseguono obiettivi più specifici, come il saper fronteggiare con maggiore efficacia le difficoltà di ogni giorno (v. <a href='#g-resilienza' class='link'>resilienza</a>), favorire l’accettazione di se stessi e degli altri, aumentare la tolleranza alla frustrazione, acquisire abilità di <a href='#g-autoregolazione' class='link'>autoregolazione</a> del proprio comportamento, incrementare la frequenza e l’intensità degli stati emotivi più piacevoli.",
	],
	[
		'title' => 'Estroverso-Introverso',
		'tag' => 'estroverso',
		'text' => "Jung (1993) utilizza questa polarità per indicare due atteggiamenti opposti, l’uno (estroversione) di orientamento verso i fatti esterni, l’altro (l’introversione) indirizzato verso i fattori soggettivi. Freud interpreta l’introversione come un ripiegamento su sé stessi conseguente alla frustrazione che l’individuo può aver provato nel contatto con la realtà. Nella tipologia proposta da Eysenck ci si avvicina di più all’uso popolare non psicologico che identifica l’estroversione con l’esuberanza e l’introversione con la riservatezza e la chiusura in sé stessi.",
	],
	[
		'title' => 'Identità personale',
		'tag' => 'identita',
		'text' => "Si intende la percezione e la consapevolezza di essere un’entità  distinta da quella degli altri e permanente nel tempo. La psicologia ha sostanzialmente mutuato dalla filosofia moderna di J. Locke e D. Hume la concezione dell’identità come costruzione della memoria, un’ auto-rappresentazione che si fonda su ciò che gli altri hanno mostrato di percepire e di pensare di noi. In questo senso  la crisi di identità coinciderebbe con la fragilità e precarietà di questa costruzione.  Alla base di tale debolezza identitaria starebbe un inadeguato processo di identificazione con le figure parentali, delle quali l’individuo tende ad assimilare uno o più i tratti, modellandosi su di esse. Nella cultura occidentale un importante criterio valutativo dell’identità personale è costituito dal principio di originalità.",
	],

	[
		'title' => 'Intelligenza/e',
		'tag' => 'intelligenza',
		'text' => "L’uso del singolare e del plurale indica un’alternanza tra due prospettive teoriche che hanno attraversato tutto il secolo scorso e che si potrebbe riassumere in una domanda: l’intelligenza è unitaria, anche se si manifesta in prestazioni estremamente varie e variegate, oppure è molteplice, una specie di sistema cooperativo che connette processi del tutto diversi fra loro? Mentre il senso comune, prevalente anche nella scuola, è più monista, per cui uno è più o meno “intelligente” o più o meno “stupido”, le <a href='#g-teoria' class='link'>teorie psicologiche</a>, in particolare quella di Gardner (1987) sulle “intelligenze multiple”, sono oggi più orientate verso il pluralismo: si può eccellere in un tipo di intelligenza ed essere carenti in un altro. È chiaro che un tipo di scuola orientato a valorizzare quasi esclusivamente alcune forme di intelligenza (ad esempio l’intelligenza linguistica, quella logico-matematica o analitica) è condannato a non scoprirne e valorizzarne altre, che però talvolta si prendono la rivincita nella vita reale.",
	],
	[
		'title' => 'Interesse',
		'tag' => 'interesse',
		'text' => "Originariamente significava “essere tra”. Tra che cosa? Tra l’oggetto (una situazione, un’attività, una persona ecc.) e il soggetto che verso quell’oggetto prova un’attrazione. Quindi è un concetto dinamico, un’interazione. Ciò significa che, se uno non prova interesse, non può <a href='#g-attributivo' class='link'>attribuire</a> tutta la responsabilità all’oggetto: almeno un po’ è anche sua. Infatti uno dei criteri più efficaci per rilevare la ricchezza umana e la sensibilità di una persona è dato proprio dalla vastità dei suoi interessi. Al contrario, si può dire che una persona annoiata trova solo cose noiose.",
	],
	[
		'title' => 'Iperattività',
		'tag' => 'iperattivita',
		'text' => "Si manifesta attraverso agitazione, intolleranza a stare fermi, come se ci fosse “un motorino dentro” che non smette mai di girare. Si correla frequentemente, ma non necessariamente,  con distraibilità e impulsività. La tendenza ad agire senza pensare a ciò che si sta facendo deriva da un deficit di controllo inibitorio che deriva con molte probabilità da caratteristiche genetiche.  Rispetto ai casi segnalati, quelli che hanno una rilevanza clinica sono relativamente pochi (in media 1 su 10), con un’incidenza percentuale sulla popolazione scolastica del 4-6%, dato per altro molto variabile da paese a paese in base ai criteri diagnostici adottati. Per avere una rilevanza clinica i sintomi caratteristici devono comparire prima dei sette anni ed essere presenti da almeno sei mesi. Nonostante si usi frequentemente il termine “disturbo”, si deve precisare che buona parte dei soggetti a elevata distraibilità e iperattività, se aiutata tempestivamente con interventi educativi, riesce ad avere una vita scolastica e sociale adeguata. Molto dipende, naturalmente, dal tipo di compiti ai quali sono sottoposti e dal tipo di ambiente nel quale si collocano.",
	],
	[
		'title' => 'Memoria',
		'tag' => 'memoria',
		'text' => "Interagiamo col mondo e lo interpretiamo  attraverso i ricordi depositati in memoria. Ma, prima di consolidarsi attraverso la ripetizione, le memorie si devono formare. Ciò avviene attraverso tre fasi: l’acquisizione di nuova informazione (codificazione), la ritenzione dell’informazione (immagazzinamento) e infine il recupero dell’informazione, la reminiscenza. 
	 La memoria implicita costituisce di fatto la maggior parte dei processi di memoria, in contrapposizione con la memoria esplicita. Una traccia di memoria a lungo termine è esplicita quando, oltre che essere attivata, diviene anche consapevole, cioè accessibile alla memoria di lavoro. È implicita invece quando viene attivata ma rimane inconscia. Sono proprio le amnesie infantili e il ricordare inconscio che costituiscono, secondo diversi scienziati, i circuiti profondi, il “cuore” del sistema col quale opera il nostro software of the mind. 
	   Quindi la maggior parte dei ricordi rimangono impliciti, non divengono coscienti. Ma non per questo sono inoperanti. Anzi, possiamo dire che l’intuizione è il frutto di un processo di incubazione, durante il quale le memorie inconsce, il serbatoio più grande di ricordi al quale possiamo attingere, sono libere di combinarsi liberamente.",
	],
	[
		'title' => 'Metacognizione',
		'tag' => 'metacognizione',
		'text' => "Quando ci si trova ad affrontare compiti piuttosto impegnativi e soprattutto quando ci si accorge di sbagliare o di non capire, è l’agire stesso che diviene campo d’indagine, dovendo essere monitorato e valutato nel corso del suo svolgimento.  Nell’autoregolazione metacognitiva entrano continuamente in gioco tre operazioni: <a href='#g-automonitoraggio' class='link'>monitoraggio</a> dell’esecuzione in corso, valutazione e <a href='#g-autoregolazione' class='link'>regolazione</a>. In questi aggiustamenti continui intervengono in modo rilevante fattori non cognitivi in senso stretto quali la <a href='#g-motivazione' class='link'>motivazione</a>, il senso di autoefficacia, la percezione di <a href='#g-stato' class='link'>stati emotivi</a> come l’ansia o la noia e, più in generale, quelle che sono state definite “capacità di <a href='#g-autoregolazione' class='link'>autoregolazione fine</a>”.",
	],
	[
		'title' => 'Metodo',
		'tag' => 'metodo',
		'text' => "In generale, è un procedimento razionale e ripetibile finalizzato all’acquisizione di una conoscenza o alla soluzione di un problema (o di una classe di problemi). In quanto ripetibile, è anche comunicabile e quindi socializzabile; in quanto razionale, si deve configurare come prescrittivo, economico (per quanto possibile), completo ed esplicito. Il metodo per eccellenza è quello scientifico (o metodo sperimentale), il quale consiste, fondamentalmente, nell'analisi sistematica, attraverso l'osservazione e la sperimentazione dei fenomeni naturali, nella organizzazione degli stessi e nella loro interpretazione. In pratica, nelle tappe attraverso le quali si sviluppa il lavoro dello scienziato. In ambito scolastico, è di particolare interesse il metodo di studio, che, nell’accezione in cui lo intendiamo oggi, nasce negli Stati Uniti nel 1946 (F.P. Robinson, 1946) e si rivolge originariamente a studenti universitari per facilitarli nella comprensione dei testi attraverso lettura veloce e stesura di appunti. Successivamente queste tecniche vengono estese ad una gamma molto più ampia di fruitori e includono anche regole pratiche per “fare ricerca” (così come la si intende nella scuola). In tempi più recenti, la riflessione teorica e le proposte di tipo operativo e procedurale hanno coperto altri settori di importanza nevralgica, quali l’<a href='#g-attenzione' class='link'>attenzione</a>, la <a href='#g-memoria' class='link'>memoria</a>, la scrittura, la <a href='#g-motivazione' class='link'>motivazione</a>, le stesse <a href='#g-emozione' class='link'>emozioni</a>. Ciò in considerazione del fatto che i vari aspetti (ad esempio cognitivi ed emozionali) non si possono separare nettamente senza compromettere l’efficacia complessiva. Naturalmente, questa dilatazione del quadro di riferimento ha complicato notevolmente le cose.",
	],
	[
		'title' => 'Motivazione',
		'tag' => 'motivazione',
		'text' => "Il significato di motivazione è molto simile a quello di <a href='#g-emozione' class='link'>emozione</a>. La stessa etimologia (da emovēre “smuovere”, “agitare” e motivazione da movēre “muovere”)  suggerisce una parentela stretta fra i due concetti. In entrambi c’è una mescolanza di cognizione, affettività e propensione all’azione. La motivazione rappresenta l’interazione e il punto di equilibrio fra questi tre aspetti. Non è qualcosa che si aggiunge all’apprendimento, ma un modo di essere in un certo momento, è uno stato identitario che orienta o distoglie dall’azione. Quando è garantita una base psicologica sicura, che ha radici nella primissima infanzia, tenderanno a prevalere tendenze progressive di autorealizzazione, attraverso la ricerca, l’esplorazione attiva e l’apprendimento. Quando ci si sente indifesi, scoperti, bisognosi di una sicurezza che si vorrebbe avere ma non c’è, a prevalere saranno probabilmente le tendenze regressive, che sconsigliano di affrontare esiti incerti e rischiosi, che potrebbero minacciare l’integrità del sé. A questa situazione di svantaggio si può reagire soprattutto prendendone consapevolezza.",
	],
	[
		'title' => 'Nevrosi',
		'tag' => 'nevrosi',
		'text' => "Secondo la psicanalisi freudiana, che per prima ne ha fornito una classificazione organizzata, nasce da un conflitto fra desiderio (istinto sessuale, impulso al piacere e alla libertà totale) da una parte e difesa imposta dalla necessità sociale della repressione del desiderio. L’interiorizzazione, in parte inconsapevole, della repressione e il compromesso sempre rinnovato fra i termini in conflitto fa della nevrosi una condizione normale dell’individuo. Acquista caratteristiche patologiche, configurandosi come un vero e proprio disturbo, quando l’intensità del conflitto è troppo elevata e la mediazione fra le due istanze è inefficace.",
	],
	[
		'title' => 'Nevroticismo',
		'tag' => 'nevroticismo',
		'text' => "Uno dei tre tipi introdotti da Eysenck per caratterizzare le <a href='#g-personalita' class='link'>personalità</a> dei diversi individui. In questa dimensione, ad un polo troveremo gli individui caratterizzati da calma, serenità, equilibrio e stabilità emotiva, pazienza, controllo, tolleranza delle frustrazioni; al polo opposto invece troveremo nervosismo, tensione, ansia e impulsività. È chiara la derivazione di questa tipologia dal concetto di <a href='#g-nevrosi' class='link'>nevrosi</a>.",
	],
	[
		'title' => 'Originalità',
		'tag' => 'originalita',
		'text' => "L’importanza di essere originali si può fare risalire alla cultura romantica in genere e in particolare al filosofo tedesco  J. G. Herder (1744 – 1803).  Carl Gustav Jung ha elevato l’assunto valoriale dell’originalità a principio regolativo dell’ <a href='#g-identita' class='link'>identità personale</a>,  con la teoria dell’individuazione: «Una vita che non si individua è una vita sprecata».  L’originalità come impegno etico prioritario è certamente una cifra importante nella costruzione delle nostre identità e dei criteri coi quali le valutiamo. Il bisogno di riconoscersi e di essere riconoscibili, in armonia con le proprie aspettative culturalmente determinate, costituisce una chiave importante per leggere in filigrana molti comportamenti che ci risulterebbero altrimenti inafferrabili. In questa prospettiva, l’identità ci appare come il risultato instabile di una negoziazione continua: «Se mettiamo l’accento sulla negoziazione, l’identità si presenta come un processo in cui niente è definitivamente perso ma niente è neppure definitivamente acquisito. Quella che si apre è un’esperienza del sé in cui la provvisorietà e la reversibilità diventano costitutive dell’esperienza» (K. J. Gergen, 1994).",
	],
	[
		'title' => 'Persona',
		'tag' => 'persona',
		'text' => "Parliamo di “persona” secondo diverse prospettive: a) nella prospettiva cristiana, che è tuttora alla base della concezione giuridica dell’individuo, è la sostanza primaria che fonda in modo unico e irripetibile l’individualità (persona come “anima”); b) in una prospettiva filosofica (da Descartes all’idealismo tedesco) ci appare come rapporto dell’individio con sé stesso (persona come “coscienza” o “autocoscienza”); c) in un’altra prospettiva anch’essa filosofica (dal marxismo all’esistenzialismo) viene presentata come la risultante della relazione dell’individuo col mondo e con gli altri; d) dal punto di vista psicologico, che riassume e fonde le tre prospettive precedenti, la persona viene considerata come il punto d’incontro dinamico di fattori genetici e socio-ambientali, sia nella dimensione conscia sia in quella inconscia (v. <a href='#g-conscio' class='link'>conscio-preconscio-inconscio</a>). Particolare è la concezione di C. G. Jung, che, riproponendo l’originario significato latino del termine, concepisce la “persona” come  “maschera”, cioè come l’atteggiamento dell’individuo verso l’esterno, gli altri, contrapponendolo al concetto di “anima”, che rappresenta la mediazione verso l’interiorità. Se la maschera è più intellettuale, l’anima è certamente più sentimentale. La totale identificazione dell’individuo con la propria persona-maschera comporta l’inconsapevolezza della propria interiorità, una completa identificazione col proprio ruolo sociale, quindi una rigidità nell’atteggiamento che nasconde una rilevante fragilità psicologica.",
	],
	[
		'title' => 'Personalità',
		'tag' => 'personalita',
		'text' => "È un concetto che può variare anche moltissimo in base alla prospettiva teorica che lo definisce. L’elemento unificante dei vari approcci può essere rintracciato in un nucleo stabile di caratteristiche, di tipo psicologico e comportamentale, che si integrano fra loro, caratterizzando l’individuo in modo peculiare. Eysenck definisce la personalità come «la somma totale degli schemi di condotta dell’organismo attuali e potenziali, ereditari e acquisiti. Essa si origina e si sviluppa attraverso l’interazione funzionale dei quattro settori principali nei quali sono organizzati questi schemi di condotta: il settore cognitivo (<a href='#g-intelligenza' class='link'>intelligenza</a>), conativo (<a href='#g-carattere' class='link'>carattere</a>), affettivo (<a href='#g-temperamento' class='link'>temperamento</a>), somatico (<a href='#g-costituzione' class='link'>costituzione</a>)» (Eysenck, 1947, p. 40).",
	],
	[
		'title' => 'Problema',
		'tag' => 'problema',
		'text' => "Il significato etimologico del termine è “ciò che viene gettato davanti”. Quando è la scuola a “gettarli davanti” allo studente si hanno spesso dei problemi fittizi, a percorso obbligato, mentre i problemi imposti dalla vita sono di solito più aperti e complessi. Nel risolvere un problema  si fondono indissolubilmente almeno due dimensioni: una che potremmo definire “fredda”, di natura cognitiva, e un’altra “calda”, di natura emozionale. Questo ci fa capire bene come non sia per niente facile accettare l’esistenza di un problema e farsene carico. Per potersi “pro-gettare” (come vuole l’etimologia del termine), proiettarsi oltre, spingersi in avanti, buttando per così dire il cuore oltre l’ostacolo, è necessario, nei problemi veri, riuscire a trasformare il disagio in problema, facendolo uscire dal suo stato di latenza.",
	],
	[
		'title' => 'Resilienza',
		'tag' => 'resilienza',
		'text' => "Indica una capacità particolarmente elevata nel fronteggiare le difficoltà. È una qualità che svolge nei confronti della psiche una funzione analoga a quella svolta per il corpo dal  sistema immunitario. Come ci sono alimenti che possono potenziare o danneggiare il sistema immunitario, così ci sono atteggiamenti e pensieri che permettono di fronteggiare situazioni molto simili con esiti diversissimi: positivi o accettabili in un caso, deleteri in un altro. La resilienza consiste quindi nell’imparare a utilizzare la propria forza psichica con maggiore consapevolezza, controllo di sé e della propria vita. Alcuni pensatori antichi, come Epitteto e Marco Aurelio, la definirono forza d'animo. Il <a href='#g-temperamento' class='link'>temperamento</a> e la predisposizione genetica la possono favorire, ma l’educazione, la cultura e la riflessione la possono incrementare in qualunque <a href='#g-persona' class='link'>persona</a>.",
	],
	[
		'title' => 'Rappresentazione',
		'tag' => 'rappresentazione',
		'text' => "Le rappresentazioni sono dei modelli semplificati della realtà. Servono agli organismi viventi dotati di cervello per muoversi nel mondo. Sarebbe troppo pericoloso andare alla cieca: occorre avere un'idea di quello che c'è “là fuori”. In pratica, ci spostiamo all'interno delle rappresentazioni che riusciamo a farci del mondo esteriore. Il termine “rappresentazione” indica sia l’atto con cui la coscienza riproduce la realtà esterna sia il contenuto di tale operazione riproduttiva. 
	   In psicologia, per “rappresentazione” si intende la possibilità di riprodurre un’esperienza in assenza dello stimolo sensoriale che l’ha prodotta originariamente. In quanto tale, occupa uno spazio intermedio fra la concretezza individuale della percezione e l’universalità del concetto corrispondente.",
	],
	[
		'title' => 'Rete neurale',
		'tag' => 'rete',
		'text' => "Nel cervello, attraverso particolari connessioni o sinapsi, si formano numerosissime e complessissime “reti” che collegano fra loro gruppi di neuroni o cellule nervose. Si pensi che nell’uomo si stima che i neuroni raggiungano l’ordina di grandezza dei 100 miliardi. Ogni neurone comunica, fa rete,  con altri neuroni attraverso moltissime connessioni, in un numero che oscilla da 1000 a 10.000. In base all’esperienza, alcune reti neurali si stabilizzano più di altre. Insomma agirebbe a livello cerebrale un specie di meccanismo evolutivo di tipo darwiniano (Edelman, 1995): alcune potenzialità – leggi: connessioni neuronali – si realizzano, mentre altre non prenderanno mai corpo. “Cambiare idea”, dal punto di vista neurobiologico, significa “cambiare il proprio cervello”.",
	],
	[
		'title' => 'Socievolezza (o “Amicalità”)',
		'tag' => 'socievolezza',
		'text' => "È una delle cinque aree del modello Big Five, col quale abbiamo cercato di evidenziare le caratteristiche temperamentali. È un tratto che si caratterizza per il calore, la disponibilità, la buona disposizione verso gli altri, la gentilezza, la correttezza, la solidarietà. Naturalmente un basso livello di socievolezza coincide con tratti di ostilità, egoismo e freddezza.",
	],
	[
		'title' => 'Stabilità emotiva',
		'tag' => 'stabilita',
		'text' => "È una delle aree in base alla quale si cerca di individuare il particolare <a href='#g-temperamento' class='link'>temperamento</a> di un individuo. La maggiore o minore stabilità emotiva dipenderebbe dalla qualità dell’umore, ossia dalla preponderanza di stati d’animo positivi quali la gioia o la serenità oppure, al contrario, dalla prevalenza di umori negativi, che si possono manifestare in pianto, cupezza, ombrosità o depressione.",
	],
	[
		'title' => 'Stato d\'animo',
		'tag' => 'stato',
		'text' => "Vedi <a href='#g-emozione' class='link'>emozione</a>.",
	],
	[
		'title' => 'Stile',
		'tag' => 'stile',
		'text' => "Classe di <a href='#g-strategia' class='link'>strategie</a> talmente reiterate da essere interiorizzate, divenendo automatiche. In quanto tale, si sottrae ad una valutazione critica. Per modificare o temperare gli effetti di un certo stile, occorre che il soggetto ne prenda consapevolezza. È una questione tuttora aperta se e quanto lo stile derivi da un’inclinazione genetica oppure esclusivamente da condizionamenti culturali e ambientali.  Probabilmente si deve operare una distinzione fra i tipi di stile. Ad esempio il <a href='#g-temperamento' class='link'>temperamento</a>, o stile comportamentale, risente più fortemente della componente ereditaria di quanto ne risentano gli stili cognitivi e ancor più gli <a href='#g-attributivo' class='link'>stili attributivi</a>.
	   Lo stile è un modo caratteristico che un individuo presenta nell’affrontare problemi e compiti legati al pensare, all’agire o all’essere.  Nel primo caso parliamo di “stili cognitivi”, negli altri due casi di “modi di agire e <a href='#g-atteggiamento' class='link'>atteggiamenti</a>”. In generale, si può dire che non ci sono stili positivi o negativi: la loro utilità e adeguatezza dipende dai compiti e dalle circostanze. Quando si ha uno stile polare, ad esempio molto visivo e poco uditivo, si è molto favoriti in certe situazioni e danneggiati in certe altre. Se si conosce il proprio stile, si è tuttavia in grado di compensarne i limiti.  
	   La gran parte di noi non presenta stili polari, ma intermedi oppure flessibili, cioè molto sviluppati sia in una polarità sia in quella opposta.  Accade pure che una certa polarità  non si possa nemmeno rilevare, perché in quel settore non si sono ancora acquisite delle strategie sufficientemente stabili.",
	],
	[
		'title' => 'Stile attributivo',
		'tag' => 'attributivo',
		'text' => "Siamo soliti attribuire delle cause a tutto ciò che ci accade, in particolare ai successi e agli insuccessi che
			ci coinvolgono emotivamente. È un atteggiamento che nasce da abitudini ed esperienze, che talvolta
			diventano convinzioni stabili, un vero e proprio <a href='#g-stile'>stile</a> di interpretazione della realtà.
			Non sempre però il nostro stile attributivo ci aiuta a crescere e a progredire. Talvolta le nostre
			convinzioni ci bloccano e risultano dannose.",
	],
	[
		'title' => 'Strategia',
		'tag' => 'strategia',
		'text' => "Le strategie nascono come risposta ai limiti dell’uomo nell’affrontare compiti, in particolare quelli nuovi e complessi.  Come la bussola, che è uno strumento nato per affrontare la navigazione in mari ignoti, dove non si può navigare a vista, così le strategie sono strumenti elaborati in contesti familiari per fare fronte a situazioni nuove. 
	   Una grandissima attenzione alle strategie come strumenti al servizio del “processore umano di informazioni” nacque tra il 1953 e il 1956, quando si realizzarono diverse ricerche che diedero l’avvio alla grande avventura cognitivista, che dura tuttora. Nel 1954 Broadbent avanzò l’ipotesi di un filtro attenzionale (v. <a href='#g-attenzione' class='link'>attenzione</a>) che avrebbe il compito di bloccare informazioni indesiderate, lasciando entrare solo quelle che meritano un’analisi ulteriore,  e ciò per la semplice ragione che la nostra <a href='#g-memoria' class='link'>memoria</a> di lavoro, come verrà chiamata più tardi, ha una capacità limitata: il magico numero di 7 elementi (più o meno due) scoperto da George Miller nel 1956. La mente umana  riesce a temperare questa debolezza strutturale, congenita, nel  raggiungere i suoi obiettivi e risolvere i suoi <a href='#g-problema' class='link'>problemi</a>, facendo ricorso a sequenze di atti che da Bruner, nello stesso 1956, verranno chiamate appunto “strategie”. L’interazione più o meno efficace dell’uomo col mondo dipende dalle strategie in suo possesso. Quando vengono applicate ripetutamente si automatizzano, diventano uno <a href='#g-stile' class='link'>stile</a>, per cui non è più necessario richiamarle alla mente consapevolmente. Il problema è acquisirle, e proprio quelle giuste per i problemi posti in situazioni date. Nella grandissima parte dei casi l’acquisizione avviene spontaneamente, però in alcuni casi ciò non avviene, oppure si possono acquisire e interiorizzare strategie sbagliate. In questi casi la mediazione di qualcuno, ad esempio un insegnante,  per acquisire una strategia nuova o per modificare una strategia sbagliata, diviene essenziale.",
	],
	[
		'title' => 'Temperamento',
		'tag' => 'temperamento',
		'text' => "Il termine deriva dal latino temperies (“umore”) e con esso si intende spesso esprimere la risultante a livello comportamentale dei tratti emotivi della personalità. Nel tempo, l’originaria concezione fisiologica è stata affiancata da una concezione più spiccatamente psicologica dell’individuo. Le molte definizioni proposte possono essere condensate in cinque aspetti: il temperamento 1) consiste nelle differenze individuali a base biologica, 2) rilevabili nel comportamento. Tali differenze 3) compaiono molto precocemente, 4)  sono relativamente stabili nel tempo e 5) in situazioni diverse. Abbiamo condensato questi cinque aspetti nel concetto di <a href='#g-stile' class='link'>stile</a> comportamentale.",
	],
	[
		'title' => 'Teoria',
		'tag' => 'teoria',
		'text' => "Le teorie sono <a href='#g-rappresentazione' class='link'>rappresentazioni</a>, simili a mappe che consultiamo per muoverci nel mondo e comprenderlo. Sono tali mappe a determinare i percorsi possibili che possiamo intraprendere. 
	Ogni teoria nasce dall’esperienza e si fonda su un esame dei fatti, col risultato di fornire un insieme di ipotesi fra loro coerenti che si sorreggono e rinforzano vicendevolmente. Ciò che dà coesione alle ipotesi teoriche è il fatto di vertere su un unico campo di indagine, che ne costituisce l’universo di discorso. 
	   Accanto alle teorie degli esperti, che sono esplicite, strutturate e fondate su ricerche e sperimentazioni accurate, ci sono anche le “teorie ingenue”, che nascono da convinzioni, per lo più implicite, che si fondano sull’esperienza personale e sul senso comune. Però hanno qualcosa in comune: entrambi i tipi si basano su congetture, su ipotesi. Le teorie fondate sul senso comune servono soprattutto per orientarsi in un mondo noto, quelle scientifiche per cercare e trovare risposte soddisfacenti a ciò che è ancora ignoto o non sufficientemente spiegato. Le prime traggono forza dal grado di consenso, le seconde, oltre che dal consenso degli scienziati, dalla confutazione sperimentale, dalla loro “falsificazione metodica”.",
	],
];
