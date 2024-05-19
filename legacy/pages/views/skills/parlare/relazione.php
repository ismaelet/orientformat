{% block content %}

<div class="main-wrap pad-t-4 pad-b-5">

	<!-- Title -->
	<?= title() ?>

	<!-- Content -->
	<section id="grid" class="grid-flow mar-t-5 mar-b-5" data-align="center">

		<!-- Image -->
		<div class="img-box js-load load--fade-in" data-direction="bottom" data-delay="3">
			<img src="<?= client_path('img.jpg') ?>" alt="" id="image" class="wid-100">
		</div>

		<!-- Graph -->
		<div id="graph" class="fa-center pos-rel">
			<div class="background bgr">
				<h3 class="txt-upp txt-wht fw-bold txt-15rem cenY txt-vertical">Organizzazione</h3>
			</div>

			<div class="element big start" data-delay="1">
				<p id="element1" class="name">Scelta</p>
				<p class="desc cen bgr-f3 pad-1 z1 txt-ita">Un argomento o un problema che mi interessa.</p>
			</div>

			<div class="element small" data-delay="2">
				<p id="element2" class="name">Introduzione</p>
				<p class="desc cen bgr-f3 pad-1 z1 txt-ita">Dico in breve di che cosa parlerò.</p>
			</div>

			<div class="element small" data-delay="3">
				<p id="element3" class="name">Sviluppo</p>
				<p class="desc cen bgr-f3 pad-1 z1 txt-ita">Spiego per punti con dati ed esempi.</p>
			</div>

			<div class="element small" data-delay="4">
				<p id="element4" class="name">Conclusione</p>
				<p class="desc cen bgr-f3 pad-1 z1 txt-ita">Il mio punto di vista sull'argomento.</p>
			</div>

			<div class="element big end" data-delay="5">
				<p id="element5" class="name">Esposizione</p>
				<p class="desc cen bgr-f3 pad-1 z1 txt-ita">Parlo scegliendo le parole e il ritmo giusti.</p>
			</div>

		</div>

	</section>

	<!-- Result -->
	<section id="result">
		<div class="grid va-items-cen">
			<p class="txt-15rem fw-bold">Risultato:</p>

			<input type="number" class="inp txt-15rem fw-bold fa-center inp-num filler-inp" name="field[]" min="1" max="10" <?= $legacyTest->completed || isSupervisor() ? 'readonly' : '' ?> value="<?= $legacyTest->completed ? $legacyTest->rawResults[0] : '' ?>" onKeyPress="if(this.value.length==2) return false;">

			<p class="fw-bold txt-15rem padl10px">/10</p>
		</div>
	</section>

	<!-- Submit -->
	<?= submit() ?>
	<?= skip() ?>

</div>

{% end content %}