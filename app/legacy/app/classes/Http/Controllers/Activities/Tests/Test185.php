<?php

namespace Legacy\Http\Controllers\Activities\Tests;



/**
 * Superiori > 2a > Imparare > Probabilità
 * 
 * Dependent tests: []
 */
class Test185 extends Test149 {

	use \System\Traits\Singleton;

	/**
	 * Test paramenters
	 */
	// protected $skipEnabled = true;
	// protected $retryEnabled = true;
	// protected $buttonIsProgressive = true;
	protected $arguments = [];

	protected function init() {
		$this->arguments['text'] = "Balene concertiste, elefanti stornellatori, scimmie polifoniche, e perfino pappagalli che suonano le percussioni. Sono alcuni dei molti esempi di animali \"musicisti\" riportati in un articolo pubblicato sulla rivista scientifica 'Science', secondo cui amare la musica e saperla creare ed eseguire non è un'esclusiva di noi superiori esseri umani, ma un' espressione naturale, innata in molte altre specie animali. I cui gorgheggi, trilli e vocalizzi {! non sarebbero :: marker0 !} affatto casuali e incoerenti, ma insiemi sonori da giudicare musicali in senso proprio, poiché rispondono alle medesime scelte estetiche e addirittura alle stesse leggi compositive utilizzate dai musicisti umani.<br>
		 Firmato da un agguerrito gruppetto di studiosi guidati da Patricia M. Gray, pianista e direttrice dell'ensemble musicale
		dell'Accademia Nazionale delle Scienze Usa, l'articolo è tra le prime uscite ufficiali degli esponenti della biomusicologia, nascente
		settore d'indagine un po' in odore di New Age, che intende rivoluzionare completamente lo studio dei suoni della natura cercando le
		basi biologiche della creazione musicale e del gusto della musica.<br>
		 Accolta con qualche freddezza da parte del mondo scientifico, la nuova disciplina {! ritiene di aver già trovato parecchi indizi :: marker0 !} di
		musicalità animale. I canti delle megattere, ad esempio, le più 'virtuose' tra tutte le balene, {! presenterebbero :: marker0 !} forti somiglianze
		strutturali con quelli degli uccelli e degli umani, con 'frasi' di lunghezza simile alle nostre frasi musicali, ed intervalli come quelli
		delle nostre scale. Le balene inoltre mescolano elementi percussivi e toni puri in un rapporto analogo a quello utilizzato nella musica
		sinfonica. E come se non bastasse, le composizioni vocali delle megattere contengono ritornelli e rime: usate {! forse :: marker0 !}, scrive la Gray,
		come trucco per memorizzare più facilmente i canti [...].<br>
		 La musica, insomma, è un linguaggio ancor più universale di quanto si pensi, tanto da {! far pensare :: marker0 !} che in qualche momento della
		storia evolutiva, balene, uccelli e uomini abbiano avuto addirittura un 'antenato musicale' in comune, di cui {! porteremmo :: marker0 !} le tracce
		nelle aree più arcaiche del nostro cervello. E se le radici della musica sono così remote, forse si spiega anche la forza delle emozioni
		che ci può regalare. A noi, e naturalmente alle balene e agli scriccioli. ";

		$this->arguments['markers'] = [
			['label' => 'Inizia a selezionare'],
		];

		$this->view();

		return $this;
	}
}
