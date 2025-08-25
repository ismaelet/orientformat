{% block main %}

<!-- Content -->
<section class="main-wrap pad-t-3 pad-b-7">

	<h1 class="page-title">Modulistica</h1>
	<div class="fa-center mar-v-1">
		<a href="<?= client_url('/teacher') ?>" class="button button--secondary back">Indietro</a>
	</div>
	<p class="page-subtitle">
		Qui puoi scaricare i moduli della <span class="txt-sbold">Certificazione delle competenze</span>, del <span class="txt-sbold">Consiglio orientativo</span> e altri documenti di supporto.
	</p>

	<div id="grid" class="documents al-top mar-t-2">

		<section class="form grid">

			<!-- Title -->
			<div class="title-box fa-center">
				<h1 class="subsection-title txt-2rem txt-sbold">UNICA</h1>
				<p class="stitle txt-09rem mar-t-1">Qui puoi collegarti all’ E-portfolio di UNICA, per inserire Certificazioni e visionare le autovalutazioni e i Capolavori inseriti dagli studenti.</p>
			</div>

			<!-- Buttons -->
			<div class="buttons fa-center mar-t-2 items-center">
				<a href="https://unica.istruzione.gov.it/portale/it/orientamento/il-tuo-percorso/e-portfolio" class="button button--full-width" target="_blank">
					<?= embed_icon('link') ?>
					Collegati a UNICA
				</a>
			</div>

		</section>

		<section class="form grid">

			<!-- Title -->
			<div class="title-box fa-center">
				<h1 class="subsection-title txt-2rem txt-sbold">Consiglio<br>orientativo</h1>
				<p class="stitle txt-09rem mar-t-1">Qui puoi scaricare il modulo per il Consiglio orientativo.</p>
			</div>

			<!-- Buttons -->
			<div class="buttons fa-center mar-t-2 items-center">
				<a href="<?= client_path('Consiglio-Orientativo.pdf') ?>" class="button button--full-width " download>
					<?= embed_icon('download') ?>
					Scarica in PDF
				</a>
				<a href="<?= client_path('Consiglio-Orientativo.docx') ?>" class="button button--secondary button--full-width  " download>
					<?= embed_icon('download') ?>
					Scarica in DOCX
				</a>
			</div>

		</section>

		<section class="form grid">

			<!-- Title -->
			<div class="title-box fa-center">
				<h1 class="subsection-title txt-2rem txt-sbold">Certificazione<br>delle competenze</h1>
				<p class="stitle txt-09rem mar-t-1">Qui puoi scaricare il modulo per la Certificazione delle Competenze.</p>
			</div>

			<!-- Buttons -->
			<div class="buttons fa-center mar-t-2 items-center">
				<a href="<?= client_path('Certificazione-delle-Competenze.pdf') ?>" class="button button--full-width " download>
					<?= embed_icon('download') ?>
					Scarica in PDF
				</a>
				<a href="<?= client_path('Certificazione-delle-Competenze.docx') ?>" class="button button--secondary button--full-width  " download>
					<?= embed_icon('download') ?>
					Scarica in DOCX
				</a>
			</div>

		</section>

		<section class="form grid">

			<!-- Title -->
			<div class="title-box fa-center">
				<h1 class="subsection-title txt-2rem txt-sbold">Informativa privacy</h1>
				<p class="stitle txt-09rem mar-t-1">Qui puoi scaricare l'informativa per la privacy e il trattamento dei dati.</p>
			</div>

			<!-- Buttons -->
			<div class="buttons fa-center mar-t-2 items-center">
				<a href="<?= client_path('Informativa-Privacy.pdf') ?>" class="button button--full-width " download>
					<?= embed_icon('download') ?>
					Scarica
				</a>
			</div>

		</section>

	</div>

</section>

{% end main %}