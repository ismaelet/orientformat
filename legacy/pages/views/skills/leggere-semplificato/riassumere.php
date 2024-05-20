{% block content %}

<div class="pad-t-5 pad-b-5 main-wrap">

	<?= title() ?>

	<?php if ($legacyTest->completed || !isSupervisor()) { ?>

		<div id="text-box" class="section">

			<h1 class="fa-center txt-3rem mar-b-2 mar-t-5 font-bold txt-upp">Riassunto</h1>

			<p id="text" class="mar-b-2 txt-1rem"><?= $text ?></p>

			<p class="clickable mar-b-2 txt-c3 fc-primary-h inlb" onclick="$('.section').toggleClass('hidden');">
				<span class="text-icon bgr-c3" <?= icon_svg('read') ?>></span>
				<span class="btn-txt">Clicca qui per rileggere il testo</span>
			</p>
		</div>

		<div id="original-box" class="section hidden">

			<h1 class="fa-center txt-3rem mar-b-2 mar-t-5 font-bold txt-upp">Testo</h1>

			<p id="original" class="mar-b-2 txt-1rem">
				Esemplare la fedeltà coniugale degli albatri, i grandi uccelli che veleggiano ad ali spiegate soprattutto nelle regioni subantartiche. E se ne comprende facilmente il motivo. Il loro uovo, uno solo, che pesa circa mezzo chilo, richiede un periodo d'incubazione lunghissimo, il più lungo che si conosca nel mondo degli uccelli: circa 80 giorni. In questo periodo i genitori si danno il cambio una volta alla settimana. Mentre l'uno cova, l'altro vola in mare a rifocillarsi. Nel momento in cui l'uno arriva dall’oceano e l'altro sta per involarsi, avviene un breve intermezzo di carezze volto a rinforzare il legame di coppia. Si lisciano reciprocamente le penne e lanciano acute grida quasi per infondersi coraggio reciprocamente. "Ci vuol pazienza. Abbiamo un figlio da allevare". Quando, infine, il piccolo sguscia dall’uovo, debbono passare ancora nove lunghi mesi prima che diventi autosufficiente. Nessun pulcino necessita di cure parentali così protratte nel tempo.<br>
				E non basta. Di regola gli albatri si riproducono ogni due anni. Ma se per disgrazia l'uovo va distrutto o il piccolo muore, la coppia fa uno strappo alla regola e si riproduce l'anno successivo. Così il tempo passa e l'unione diventa permanente.
			</p>

			<p class="clickable mar-b-2 txt-c3 fc-primary-h inlb" onclick="$('.section').toggleClass('hidden');">
				<span class="text-icon bgr-c3" <?= icon_svg('navigation/back') ?>></span>
				<span class="btn-txt">Clicca qui per tornare al riassunto</span>
			</p>
		</div>

	<?php } ?>

	<?= no_results() ?>
	<?= submit(true) ?>
	<?= skip() ?>

</div>

{% end content %}