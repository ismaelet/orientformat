{% block main %}

<!-- Slider -->
<section id="slider">

	<div id="bgr-img" class="bgr" <?= background_image('/pages/assets/teacher/bgr.png') ?>></div>

</section>

<!-- Content -->
<section class="main-wrap pad-b-7">

	<div class="fa-center mar-t-3">
		<a href="<?= client_url('/teacher') ?>" class="button button--secondary back">Torna alla gestione</a>
	</div>

	<div id="grid" class="grid2 grid1-1024w al-top mar-t-2">

		<section class="form">

			<!-- Title -->
			<div class="title-box fa-center">
				<h1 class="title txt-2rem txt-sbold">Consiglio orientativo</h1>
				<p class="stitle txt-09rem mar-t-1">Qui puoi scaricare il modulo per il Consiglio orientativo.</p>
			</div>

			<!-- Buttons -->
			<div class="buttons fa-center mar-t-2">
				<a href="<?= client_url('Consiglio-Orientativo.pdf') ?>" class="button wid-100">Scarica in PDF</a><br>
				<a href="<?= client_url('Consiglio-Orientativo.docx') ?>" class="button wid-100 bgr-c2">Scarica in DOCX</a>
			</div>

		</section>

		<section class="form">

			<!-- Title -->
			<div class="title-box fa-center">
				<h1 class="title txt-2rem txt-sbold">Certificazione delle Competenze</h1>
				<p class="stitle txt-09rem mar-t-1">Qui puoi scaricare il modulo per la Certificazione delle Competenze.</p>
			</div>

			<!-- Buttons -->
			<div class="buttons fa-center mar-t-2">
				<a href="<?= client_url('Certificazione-delle-Competenze.pdf') ?>" class="button wid-100">Scarica in PDF</a><br>
				<a href="<?= client_url('Certificazione-delle-Competenze.docx') ?>" class="button wid-100 bgr-c2">Scarica in DOCX</a>
			</div>

		</section>

		<section class="form">

			<!-- Title -->
			<div class="title-box fa-center">
				<h1 class="title txt-2rem txt-sbold">Informativa privacy</h1>
				<p class="stitle txt-09rem mar-t-1">Qui puoi scaricare l'informativa per la privacy e il trattamento dei dati.</p>
			</div>

			<!-- Buttons -->
			<div class="buttons fa-center mar-t-2">
				<a href="<?= client_url('Informativa-Privacy.pdf') ?>" class="button wid-100">Scarica</a><br>
			</div>

		</section>

	</div>

</section>

{% end main %}