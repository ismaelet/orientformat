{% block content %}

<!-- Review view -->
<?php if ($test->completed) { ?>

	<div id="results-sec" class="grid-flow main-wrap pad-t-5 pad-b-5" data-spacing="700">

		<?= title('A quale conclusione sei arrivato?', 'La conclusione qui è incerta, però:') ?>

		<div class="grid-flow" data-columns="25rem" data-spacing="700">

			<div id="method1" class="method" data-tilt>

				<h3 class="subsection-title txt-15rem fw-bold br-b-1 br-5 pad-b-1 mar-b-2">Se sei molto <span class="highlight">intuitivo/a</span></h3>

				<p class="desc txt-1rem txt-2 mar-b-1">
					- avrai notato subito i diversi tipi di impronta e sarai giunto rapidamente alla conclusione: 6 (o 8 a seconda di come hai contato le biciclette)
				</p>
				<p class="desc txt-1rem txt-2">
					- In questo caso la rapidità della conclusione è pericolosa, anche se in altre situazioni essere intuitivo può aiutarti a raggiungere più velocemente il risultato.
				</p>

			</div>

			<div id="method2" class="method" data-tilt>

				<h3 class="subsection-title txt-15rem fw-bold br-b-1 br-5 pad-b-1 mar-b-2">Se sei molto <span class="highlight">sistematico/a</span></h3>

				<p class="desc txt-1rem txt-2 mar-b-1">
					- ti sarai detto: ci sono sei (o otto) tipi di impronte, ma non si può escludere che la stessa persona sia passata più di una volta, con scarpe o mezzi diversi, oppure sullo stesso mezzo ci poteva essere più di una persona.
				</p>
				<p class="desc txt-1rem txt-2">
					- In questo caso l’accuratezza e la prudenza del sistematico erano necessarie.
				</p>

			</div>
		</div>

		<!-- Submit -->
		<?= submit() ?>

	</div>

	<!-- Initial view -->
<?php } else { ?>

	<div id="image-sec" class="main-wrap grid-flow" data-spacing="800">
		<div class="title__wrapper">
			<?= title() ?>
		</div>
		<img id="img" class="" src="<?= client_path('img.jpg') ?>">
		<button type="submit" name="review" class="button button--full-width">Esamina la tua risposta</button>
	</div>

<?php } ?>

{% end content %}