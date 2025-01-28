{% block content %}

<div id="slider">

	<div id="bgr-img" class="bgr" <?= background_image('bgr.png'); ?>></div>
	<div id="bgr" class="bgr"></div>

	<div id="title-box" class="fa-center">

		<h1 id="title" class="txt-whtpush-centerfont-bold txt-upp">Gestisci la classe</h1>

	</div>

</div>

<div id="content" class="pad-t-5 pad-b-10 bgr-wht">

	<div class="main-wrap">

		<!-- Subtitle and description -->
		<div class="fa-center">

			<p id="stitle" class="txt-upp txt-15rem txt-sbold txt-2">Funzionalità per l'insegnante</p>

			<p id="desc" class="txt-09rem mar-t-1">Qui puoi controllare i progressi dei tuoi studenti e amministrare la classe <span class="font-bold"><?= $grade->name ?></span></p>

			<?php if (!$grade->ended && $grade->year == 20211) { ?>
				<div class="button button--secondary br-red mar-t-2 txt-red lbox-open" data-tar="#survey-lbox">Clicca qui per attivare il questionario finale</div>
			<?php } ?>

		</div>

		<!-- Tests -->
		<div id="sections-sec" class="mar-t-3 grid3 grid2-1024w grid1-480w gap2">

			<?php foreach ($legacySections as $key => $legacySection) { ?>

				<div class="load slide-bottom ld-<?= ($key - 1) % 3 ?>">

					<a href="<?= $legacySection['url'] ?>" id="section<?= $key ?>" class="section bgr-wht grid gap-o-1">

						<div class="section-img">
							<div class="bgr cont rel pad-b-100" <?= background_image('section' . $key . '.svg') ?>></div>
						</div>

						<div class="section-data">

							<div class="section-texts">

								<h1 class="section-title txt-upp txt-12rem font-bold"><?= $legacySection['title'] ?></h1>

								<p class="section-stitle mb-4 txt-upp mt-2"><?= $legacySection['stitle'] ?></p>

								<p class=""><?= $legacySection['desc'] ?></p>

							</div>

							<div class="section-btn-box">

								<p class="section-btn inlb view txt-c2">Visualizza</p>

							</div>
						</div>
					</a>
				</div>

			<?php } ?>
		</div>
	</div>
</div>

<div id="survey-lbox" class="lbox">

	<form method="POST" class="form">
		<div class="">
			<div class="icon-bgr">
			</div>
			<img src="<?= client_path('question-icon.svg') ?>" alt="" class="cen">
		</div>

		<h2>Vuoi attivare il questionario?</h2>
		<p class="txt-1rem fa-center mar-t-2 mb-4">Se attivato, i tuoi studenti riceveranno un invito a completare il questionario quando accederanno alla piattaforma.</p>
		<button type="submit" name="activate-survey" class="wid-100 pbtn">Attiva</button>
		<button type="button" class="wid-100 sbtn lbox-close">Annulla</button>
	</form>

</div>

{% end content %}