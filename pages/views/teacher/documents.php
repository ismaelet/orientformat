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

		<section class="form">

			<!-- Title -->
			<div class="title-box fa-center">
				<h1 class="subsection-title txt-2rem txt-sbold">Consiglio<br>orientativo</h1>
				<p class="stitle txt-09rem mar-t-1">Qui puoi scaricare il modulo per il Consiglio orientativo.</p>
			</div>

			<!-- Buttons -->
			<div class="buttons fa-center mar-t-2">
				<a href="<?= client_path('Consiglio-Orientativo.pdf') ?>" class="button button--full-width " download>
					<?= icon_embed('download') ?>
					Scarica in PDF
				</a>
				<a href="<?= client_path('Consiglio-Orientativo.docx') ?>" class="button button--secondary button--full-width  " download>
					<?= icon_embed('download') ?>
					Scarica in DOCX
				</a>
			</div>

		</section>

		<section class="form">

			<!-- Title -->
			<div class="title-box fa-center">
				<h1 class="subsection-title txt-2rem txt-sbold">Certificazione<br>delle competenze</h1>
				<p class="stitle txt-09rem mar-t-1">Qui puoi scaricare il modulo per la Certificazione delle Competenze.</p>
			</div>

			<!-- Buttons -->
			<div class="buttons fa-center mar-t-2">
				<a href="<?= client_path('Certificazione-delle-Competenze.pdf') ?>" class="button button--full-width " download>
					<?= icon_embed('download') ?>
					Scarica in PDF
				</a>
				<a href="<?= client_path('Certificazione-delle-Competenze.docx') ?>" class="button button--secondary button--full-width  " download>
					<?= icon_embed('download') ?>
					Scarica in DOCX
				</a>
			</div>

		</section>

		<section class="form">

			<!-- Title -->
			<div class="title-box fa-center">
				<h1 class="subsection-title txt-2rem txt-sbold">Informativa privacy</h1>
				<p class="stitle txt-09rem mar-t-1">Qui puoi scaricare l'informativa per la privacy e il trattamento dei dati.</p>
			</div>

			<!-- Buttons -->
			<div class="buttons fa-center mar-t-2">
				<a href="<?= client_path('Informativa-Privacy.pdf') ?>" class="button button--full-width " download>
					<?= icon_embed('download') ?>
					Scarica
				</a>
			</div>

		</section>

	</div>

</section>

{% end main %}