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
class Test190 extends Test189 {

	use \System\Traits\Singleton;

	// protected $skipEnabled = true;
	// protected $retryEnabled = true;
	// protected $buttonIsProgressive = true;
	protected $arguments = [];

	protected function init() {
		$this->arguments['text'] = "
		{! La sera s'andava infittendo sul viale e il bianco delle due lettere che aveva in grembo si faceva indistinto :: marker4 !}. {! Una era per Harry, l'altra per il padre :: marker0 !}. Il suo prediletto, veramente, era stato Ernest, ma anche a Harry voleva bene. {! Aveva notato che negli ultimi tempi il padre stava invecchiando; lei gli sarebbe mancata :: marker0 !}. {! A volte sapeva essere gentile. Non molto tempo prima, un giorno che era stata a letto, malata, s'era messo a leggerle una storia di fantasmi e le aveva abbrustolito il pane sul fuoco :: marker4 !}. [...]<br>
   Il tempo passava ma {! lei rimaneva lì seduta presso la finestra, la testa appoggiata contro le tendine e l'odore polveroso della cretonne nelle narici. Giù dal viale sentiva salire il lontano suono di un organetto :: marker4 !}. Era un motivo che conosceva. Strano che venisse proprio quella sera a rammentarle {! la promessa fatta alla madre, la promessa di badare alla famiglia più a lungo che avesse potuto :: marker0 !}. Le tornò a mente l'ultima notte della malattia della madre. Si rivide nella stanza buia, chiusa, dall'altra parte dell'anticamera: da fuori giungeva una melanconica aria italiana. Ricordava il padre che rientrava pomposo nella camera dell'ammalata dicendo: «Dannati italiani! Proprio qui debbono venire!».<br>
{! E mentre stava lì a meditare, la penosa visione della vita della madre operava nel più profondo del suo essere una specie di sortilegio, quella vita di sacrifici meschini conclusasi nella pazzia finale. Tremò riudendo la voce materna ripetere con vuota insistenza :: marker3 !}:<br>
   «Derevaun Seraun! Deveraun Seraun!»<br>
{! Balzò in piedi con un subitaneo moto di terrore. Fuggire! Fuggire doveva! :: marker3 !} {! Frank l'avrebbe salvata. Le avrebbe dato una vita e forse anche l'amore :: marker2 !}. E in ogni modo {! lei voleva vivere. Perché avrebbe dovuto essere infelice? :: marker1 !} Aveva diritto alla felicità. {! Frank l'avrebbe presa fra le braccia, l'avrebbe stretta fra le braccia, l'avrebbe salvata :: marker2 !}.<br>
   Era alla stazione di North Wall, in mezzo alla folla ondeggiante. Egli la teneva per mano e lei sapeva che le stava parlando, che le ripeteva qualche cosa sulla traversata. La stazione era piena di soldati coi loro bagagli scuri e attraverso le ampie porte della tettoia si scorgeva a tratti, lungo la murata della banchina, la massa immobile e nera della nave, con gli oblò illuminati. {! Lei non rispondeva. Si sentiva le guance pallide e fredde e da un confuso fondo di disperazione :: marker5 !} {! pregava Dio di guidarla, di mostrarle qual era il suo dovere :: marker1 !}. La nave lanciò nella nebbia un lungo, luttuoso ululo di sirena. {! Se partiva, domani si sarebbe trovata in alto mare, con Frank, diretta a Buenos Aires :: marker2 !}. I posti erano fissati. {! Come poteva tirarsi indietro dopo tutto quel che Frank aveva fatto per lei? :: marker0 !}{! Lo sgomento le dette quasi un senso di nausea :: marker5 !}: {! continuava a muovere le labbra in tacita e fervida preghiera :: marker1 !}.<br>
   {! Una campana le rintoccò nel cuore. Sentì ch'egli la afferrava per mano :: marker5 !}.<br>
   «Vieni!»<br>
   {! Tutti i mari del mondo le s'infrangevano sul cuore. E lui la trascinava dentro, la voleva annegare. Con ambo le mani s'aggrappò al parapetto di ferro. :: marker3 !} <br>
   «Vieni!»<br>
   {! No! no! no! Era impossibile. Le mani strinsero frenetiche il ferro. Dalla distesa dei mari essa alzò un grido d'angoscia :: marker5 !}.<br>
   «Eveline! Evy!»<br>
   Lui si precipitò di là dal cancello, chiamandola perché lo seguisse. Gli gridarono di andare avanti ma lui continuava a chiamarla. {! Lei lo fissava con la faccia pallida, passiva, come un animale smarrito :: marker5 !}. I suoi occhi non gli diedero alcun segno d'amore o di addio o di riconoscimento.";

		$this->arguments['markers'] = [
			['label' => 'Senso di colpa'],
			['label' => 'Il dubbio'],
			['label' => 'La speranza'],
			['label' => 'Senso di minaccia'],
			['label' => 'Nostalgia'],
			['label' => 'Disperazione'],
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
