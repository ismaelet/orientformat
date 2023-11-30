{% block main %}

<!-- Body -->
<div class="page-body grid-flow center-content main-wrap" data-spacing="400">
	<img class="page-image" src="<?= client_path('image.svg') ?>" alt="">

	<div class="page-content grid-flow center-content" data-spacing="400">
		<h1 class="title"><?= __('Pagina in<br>manutenzione') ?></h1>
		<p class="section-subtitle">
			<?= __("Questa pagina verrà riattivata a breve") ?>
		</p>
		<a href="<?= client_url('/') ?>" class="button button--secondary">Indietro</a>
	</div>
</div>

{% end main %}