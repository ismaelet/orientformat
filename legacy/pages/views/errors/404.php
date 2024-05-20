{% block main %}

<div class="page-content grid-flow stack-content center-content">
	<div class="page-background fill-all background-fill" <?= background_image('background') ?>></div>

	<div class="page-body grid-flow center-content" data-spacing="400">
		<h1 class="title">Errore 404</h1>
		<p class="section-subtitle">Pagina non trovata</p>
		<a class="button button--secondary button--auto-width" href="<?= route('home') ?>">Torna alla Home</a>
	</div>
</div>

{% end main %}