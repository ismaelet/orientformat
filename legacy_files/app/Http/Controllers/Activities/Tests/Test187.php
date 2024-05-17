<?php

namespace app\Http\Controllers\Activities\Tests;



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
class Test187 extends Test149 {

	use \System\Traits\Singleton;

	// protected $skipEnabled = true;
	// protected $retryEnabled = true;
	// protected $buttonIsProgressive = true;
	protected $arguments = [];

	protected function init() {
		$this->arguments['text'] = "
		Sono {! arrivati a cavallo :: marker4 !} {! da est :: marker0 !}. {! Alti, muscolosi, abbronzati, scuri di occhi e capelli :: marker2 !}. E senza compagne. I {! loro monili di metallo hanno colpito le donne del luogo :: marker4 !}. A essere colpiti dalle loro {! armi, fatte dello stesso materiale :: marker4 !}, sono stati invece gli uomini. Cosa sia successo dopo (siamo {! nel 3mila a.C. in Europa centrale :: marker0 !}) possiamo solo immaginarlo. Fatto sta che nel giro di poche generazioni, {! hanno osservato i genetisti, il Dna dei nuovi arrivati era già penetrato nel 50% della popolazione :: marker3 !}. {! E le sepolture, hanno notato gli archeologi, si sono riempite di cadaveri ammucchiati e crani forati. :: marker3 !}<br>
		Così si presentarono gli Yamnaya, il terrore del Neolitico. {! Giovani guerrieri partiti in bande, a cavallo e sui carri :: marker4 !}, {! dalle steppe del Nord del Caucaso :: marker0 !} che sono la loro casa {! dal 3.300 a.C. :: marker0 !}: epoca e luogo della leggenda dell’Arca di Noè. Hanno spronato i loro cavalli sia {! in Europa verso est, sia verso la Mongolia :: marker0 !}. Le loro tombe sono eloquenti: i resti, prima dell'ultimo addio, venivano dipinti di rosso e affiancati da asce. Quando partivano, non portavano nulla con sé. Dove arrivavano, {! razziavano. Soprattutto le donne, sbarazzandosi senza troppi complimenti degli uomini :: marker4 !}.<br>
		L’Europa del Neolitico, già piegata dalla peste (ma non manca chi crede che a portare il batterio siano stati gli stessi Yamnaya), divenne un luogo malsano e violento. Ci si è chiesti a lungo {! come mai la civiltà che costruì Stonehenge si sia dissolta rapidamente nel nulla :: marker1 !}. I razziatori delle steppe, arrivati {! nell’attuale Francia nel 2.500 a.C. :: marker0 !} e {! capaci di apprendere anche la navigazione :: marker4 !}, sono fra i principali indiziati. Kristian Kristiansen dell'università di Goteborg, fra i principali studiosi di questo popolo, ha scritto senza troppi giri di parole che la specialità degli Yamnaya era il genocidio. E che i cavalieri delle steppe vanno considerati {! il popolo più sanguinario :: marker2 !} della storia. {! Gli studi sul Dna :: marker3 !} confermano che {! la scomparsa delle tracce genetiche dei popoli indigeni del Neolitico è stata rapidissima :: marker5 !}.<br>
		La storia degli Yamnaya, per via di quei cromosomi diffusi con tanto impeto, non è confinata al passato. {! Tracce dei loro geni :: marker3 !}, conferma la ricerca di Science del 5 settembre, {! sono onnipresenti oggi fra i popoli :: marker3 !} {! dall’Asia all’Atlantico, soprattutto in Europa del Nord :: marker0 !}. È scorretto parlare di “geni della guerra”, ma quei semi di violenza gettano una luce cupa su quello che sarebbe diventato il nostro futuro.<br>
		Anche perché gli Yamnaya erano {! violenti :: marker2 !}, ma non solo. {! Sapevano forgiare i metalli, avevano addomesticato i cavalli, usavano ruote e carri :: marker4 !}. {! Erano ben nutriti, grazie a porzioni abbondanti di carne e latticini :: marker4 !}. E sono i padri della nostra lingua. {! Portarono fra Asia ed Europa un idioma che si diffuse con la stessa rapidità delle loro razzie: l’antenato delle lingue indo-europee, la famiglia più parlata al mondo con 400 idiomi dal celtico al persiano, fino alle parlate dell’India, incluso italiano :: marker5 !}. <br>
		Presto {! le donne locali iniziarono ad apprezzare gli Yamnaya più dei loro ex neolitici :: marker5 !}. In qualche modo - {! ci rivela sempre il Dna :: marker3 !} – riuscirono a convertirli alla monogamia. E a contatto con l'agricoltura, i truci razziatori impararono ad apprezzarne i frutti (con una passione speciale per la birra). {! Coltivarono, allevarono, diventarono artigiani della ceramica :: marker5 !} (attività non scontata per un popolo nomade). {! Costruirono una società definitivamente fondata sulla proprietà privata :: marker5 !}. Siamo solo nell’Età del Bronzo, ma i semi della nostra storia, nei suoi aspetti di {! civiltà e di violenza :: marker2 !}, sono stati definitivamente gettati.";

		$this->arguments['markers'] = [
			['label' => 'Quando e dove?'],
			['label' => 'Qual è	l’interrogativo?'],
			['label' => 'Come erano'],
			['label' => 'Prove?'],
			['label' => 'Perché prevalgono?'],
			['label' => 'Conseguenze?'],
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
