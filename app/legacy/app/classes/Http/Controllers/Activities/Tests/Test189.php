<?php

namespace Legacy\Http\Controllers\Activities\Tests;



/**
 * Specific test class
 * 
 * @property int $resultCount = 0 <inherited>
 * @property bool $buttonIsProgressive = false <inherited>
 * @property bool $skipEnabled = false <inherited>
 * @property bool $retryEnabled = false <inherited>
 * @property array $parameters = [] <inherited>
 * @property array $arguments = []
 */
class Test189 extends Test149 {

	use \System\Traits\Singleton;

	// protected $skipEnabled = true;
	// protected $retryEnabled = true;
	// protected $buttonIsProgressive = true;
	protected $arguments = [];

	protected function init() {
		$this->arguments['text'] = "
		Seduta alla finestra guardava la sera invadere il viale. Teneva la testa appoggiata contro le tendine e sentiva nelle narici l'odore della cretonne polverosa. Era stanca.<br>
    Poca gente per strada. Passò l'inquilino della casa di fondo che rientrava. Lei ne sentì i passi risuonare sul marciapiede di cemento, poi scricchiolare sul sentiero di cenere dinanzi alle nuove case di color rosso. In passato c'era un campo laggiù dove loro giocavano ogni sera con gli altri ragazzi del quartiere. Poi l'aveva comprato un tale di Belfast e ci aveva costruito delle case; non piccole case nere come le loro, ma vivaci case in mattoni, dal tetto lucente. Tutti i ragazzi del viale avevano giocato in quel campo: i Bevine, i Water, i Dunn, il piccolo Keogh lo zoppo e lei coi fratelli e le sorelle. Ernest però non giocava mai: era troppo grande. Spesso veniva il padre a scacciarli dal campo col suo bastone di pruno, ma di solito il piccolo Keogh stava di guardia e dava l'allarme non appena lo vedeva arrivare. {! Eppure le pareva che, a quei tempi, fossero stati abbastanza felici :: marker4 !}. Il padre non era ancora così cattivo e inoltre era viva la mamma. Cose di tanto tempo addietro; poi lei e i suoi fratelli e sorelle s'erano fatti grandi e la mamma era morta. Anche Tizzie Dunn era morto e i Water erano tornati in Inghilterra. Tutto cambia. Adesso lei stava per andarsene via come gli altri, lasciare la casa.<br>
   {! La sua casa! Si guardò attorno nella stanza fissando tutti gli oggetti familiari :: marker4 !} che aveva spolverato una volta la settimana per tanti anni, domandandosi sempre da dove poteva venire tanta polvere. {! Forse non avrebbe mai più visto quegli oggetti dai quali non aveva mai immaginato di doversi separare :: marker4 !}. E in tanti anni, tuttavia, non era mai riuscita a sapere il nome del prete la cui fotografia ingiallita era appesa al muro sopra l'harmonium scordato, accanto alla stampa a colori dei voti fatti alla Beata Margherita Maria Alacoque. Era stato un compagno di scuola del padre e ogni volta che questi mostrava il ritratto a un visitatore non mancava d'accompagnare il gesto con una parola distratta:<br>
  «È a Melbourne adesso.»<br>
   Lei aveva acconsentito ad andarsene, a lasciare la casa. {! Ma era una cosa sensata? :: marker1 !} Si sforzava di valutare ogni aspetto del problema. {! Lì in casa sua non le sarebbero mai mancati cibo e alloggio; né le persone che era avvezza a vedersi intorno sin dalla nascita :: marker1 !}. Certo che doveva lavorare sodo, sia in casa che all'impiego. Che avrebbero detto ai Magazzini quando si fosse risaputo che era scappata con un giovanotto? Le avrebbero dato della scema, forse, e messo un annuncio sul giornale per sostituirla. Sarebbe stata contenta Miss Gavan. Non le aveva mai risparmiato le sue stoccate, specie se c'era gente che sentiva.<br>
   «Non vedete che le signore aspettano, Miss Hill?»<br>
   «Ma svegliatevi. Miss Hill, per favore.»<br>
   Non avrebbe pianto molte lacrime nel lasciare i Magazzini.<br>
   {! Nella casa nuova però, in un paese lontano e sconosciuto, non sarebbe andata così. Sarebbe stata una donna maritata: lei, Eveline, e la gente l'avrebbe trattata con rispetto :: marker2 !}. Non sarebbe stata trattata come sua madre, no. Ancora adesso, per quanto avesse già diciannove anni compiuti, le avveniva a volte di temere la violenza paterna. Era stato questo, lo sapeva, a farle venire le palpitazioni. Quando erano ancora piccoli, il padre non si sfogava mai su di lei come su Harry e Ernest, perché era una ragazza; ma in seguito aveva cominciato a minacciarla e a dirle che, se non fosse stato per la memoria di quella buon'anima di sua madre, {! non avrebbe mancato di darle il fatto suo :: marker3 !}. {! E ora non c'era nessuno a proteggerla :: marker3 !}. Ernest era morto e Harry, che faceva il decoratore di chiese, era quasi sempre via, in qualche paese di campagna. Senza contare le eterne discussioni per i soldi, il sabato sera, che da qualche tempo in qua la sfinivano oltre ogni dire. Dava lo stipendio intero in famiglia -sette scellini - e Harry mandava quanto poteva; ma il guaio era di cavarli al padre, i quattrini. Era una spendacciona, le diceva lui, una scervellata e lui non se la sentiva di darle i soldi guadagnati con tanta fatica perché li buttasse dalla finestra; questo e altro le diceva, perché era sempre di cattivo umore il sabato sera. Alla fine però glieli dava, domandandole se non aveva per caso l'intenzione di comperare qualcosa per il pranzo della domenica. Così le toccava uscire a precipizio per fare la spesa, aprendosi la strada a gomitate fra la folla, il borsellino di pelle nera stretto nel pugno, e rincasare sul tardi, carica di provviste. Era un lavoro duro, per lei, badare alla casa e stare attenta che i due fratellini minori, affidati alle sue cure, andassero a scuola regolarmente e avessero di che mangiare. Un lavoro duro, sì, una vitaccia; ma adesso che stava per lasciarla, già non la trovava più così insopportabile.<br>
   {! Ne avrebbe cominciata un'altra, con Frank :: marker2 !}. Era buono e forte Frank, e di cuore generoso. {! Sarebbe scappata :: marker0 !} con lui sul piroscafo della notte, e {! sarebbe diventata sua moglie, avrebbero vissuto insieme a Buenos Aires, dove lui aveva una casa che la aspettava :: marker2 !}. Come ricordava bene la prima volta che l'aveva visto! Aveva preso alloggio in una casa sulla strada principale, dove lei aveva degli amici. Le pareva fossero passate poche settimane da allora. Lui era al cancello, il berretto a visiera tirato all'indietro sulla nuca e i capelli che gli ricadevano sulla fronte abbronzata. Poi si erano conosciuti. Ogni sera la aspettava all'uscita dei Magazzini e la accompagnava fino a casa. L'aveva portata a sentire La Zingara e a lei era parso un sogno stargli seduta accanto, a teatro, in posti che non le erano abituali. Lui aveva un'enorme passione per la musica, e un poco cantava. Tutti erano al corrente del loro amore e così quando egli cantava la canzone della ragazza innamorata del marinaio, Eveline provava sempre un dolce imbarazzo. Lui la chiamava scherzosamente Papavero. In principio l'idea di avere un corteggiatore le aveva dato alla testa, ma poi s'era messa a volergli bene sul serio. Le parlava di paesi lontani; aveva cominciato da mozzo, a una sterlina al mese, su una nave della linea Allan che andava al Canada. E le diceva i nomi delle navi su cui era stato e quelli dei diversi servizi. Aveva passato lo Stretto di Magellano e le narrava storie dei terribili patagoni. Aveva avuto fortuna a Buenos Aires, diceva, ed era tornato al vecchio paese solo in vacanza. Naturalmente il padre di Eveline era venuto a sapere la storia, e le aveva proibito d'avere a che fare con lui.<br>
Un giorno avevano litigato, Frank e il padre, dopo di che loro avevano dovuto vedersi di nascosto.";

		$this->arguments['markers'] = [
			['label' => 'Senso di colpa'],
			['label' => 'Il dubbio'],
			['label' => 'La speranza'],
			['label' => 'Senso di minaccia'],
			['label' => 'Nostalgia'],
			// ['label' => 'Disperazione'],
		];

		$this->storeInlineStyles([$this->additionalStyle()]);
		$this->view();

		return $this;
	}

	/**
	 * Style
	 */
	protected function additionalStyle() {
		ob_start();
?>

		<style>
			#text {
				font-size: var(--fs-400);
				text-align: justify;
			}
		</style>

<?php return ob_get_clean();
	}
}
