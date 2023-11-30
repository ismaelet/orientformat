<?php

namespace app\Http\Controllers\Activities\Tests;

use Singleton;

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
class Test188 extends Test187 {

	use Singleton;

	// protected $skipEnabled = true;
	// protected $retryEnabled = true;
	// protected $buttonIsProgressive = true;
	protected $arguments = [];

	protected function init() {
		$this->arguments['text'] = "
		Sono arrivati a cavallo da est. Alti, muscolosi, abbronzati, scuri di occhi e capelli. E senza compagne. I loro monili di metallo hanno colpito le donne del luogo. A essere colpiti dalle loro armi, fatte dello stesso materiale, sono stati invece gli uomini. Cosa sia successo dopo (siamo nel 3mila a.C. in Europa centrale) {! possiamo solo immaginarlo :: marker0 !}. Fatto sta che nel giro di poche generazioni, hanno osservato i genetisti, il Dna dei nuovi arrivati era già penetrato nel 50% della popolazione. E le sepolture, hanno notato gli archeologi, si sono riempite di cadaveri ammucchiati e crani forati.<br>
		Così si presentarono gli Yamnaya, il terrore del Neolitico. Giovani guerrieri partiti in bande, a cavallo e sui carri, dalle steppe del Nord del Caucaso che sono la loro casa dal 3.300 a.C.: epoca e luogo della leggenda dell’Arca di Noè. Hanno spronato i loro cavalli sia in Europa verso est, sia verso la Mongolia. Le loro tombe sono eloquenti: i resti, prima dell'ultimo addio, venivano dipinti di rosso e affiancati da asce. Quando partivano, non portavano nulla con sé. Dove arrivavano, razziavano. Soprattutto le donne, sbarazzandosi senza troppi complimenti degli uomini.<br>
		L’Europa del Neolitico, già piegata dalla peste (ma {! non manca chi crede :: marker0 !} che a portare il batterio siano stati gli stessi Yamnaya), divenne un luogo malsano e violento. {! Ci si è chiesti a lungo :: marker0 !} come mai la civiltà che costruì Stonehenge si sia dissolta rapidamente nel nulla. I razziatori delle steppe, arrivati nell’attuale Francia nel 2.500 a.C. e capaci di apprendere anche la navigazione, {! sono fra i principali indiziati :: marker0 !}. Kristian Kristiansen dell'università di Goteborg, fra i principali studiosi di questo popolo, ha scritto senza troppi giri di parole che la specialità degli Yamnaya era il genocidio. E che i cavalieri delle steppe vanno considerati il popolo più sanguinario della storia. Gli studi sul Dna confermano che la scomparsa delle tracce genetiche dei popoli indigeni del Neolitico è stata rapidissima.<br>
		La storia degli Yamnaya, per via di quei cromosomi diffusi con tanto impeto, non è confinata al passato. Tracce dei loro geni, conferma la ricerca di Science del 5 settembre, sono onnipresenti oggi fra i popoli dall’Asia all’Atlantico, soprattutto in Europa del Nord. {! È scorretto parlare di “geni della guerra”, ma quei semi di violenza gettano una luce cupa su quello che sarebbe diventato il nostro futuro :: marker0 !}.<br>
		Anche perché gli Yamnaya erano violenti, ma non solo. Sapevano forgiare i metalli, avevano addomesticato i cavalli, usavano ruote e carri. Erano ben nutriti, grazie a porzioni abbondanti di carne e latticini. E sono i padri della nostra lingua. Portarono fra Asia ed Europa un idioma che si diffuse con la stessa rapidità delle loro razzie: l’antenato delle lingue indo-europee, la famiglia più parlata al mondo con 400 idiomi dal celtico al persiano, fino alle parlate dell’India, incluso italiano. <br>
		Presto le donne locali iniziarono ad apprezzare gli Yamnaya più dei loro ex neolitici. In qualche modo - ci rivela sempre il Dna – riuscirono a convertirli alla monogamia. E a contatto con l'agricoltura, i truci razziatori impararono ad apprezzarne i frutti (con una passione speciale per la birra). Coltivarono, allevarono, diventarono artigiani della ceramica (attività non scontata per un popolo nomade). Costruirono una società definitivamente fondata sulla proprietà privata. Siamo solo nell’Età del Bronzo, ma i semi della nostra storia, nei suoi aspetti di civiltà e di violenza, sono stati definitivamente gettati.";

		$this->arguments['markers'] = [
			['label' => 'Inizia a selezionare'],
		];

		$this->storeInlineStyles([$this->additionalStyle()]);
		$this->view();

		return $this;
	}
}
