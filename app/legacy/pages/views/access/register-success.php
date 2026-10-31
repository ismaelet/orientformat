{% block main %}

<div class="page__content grid center-content main-wrap pad-v-5">
	<div class="grid center-content" data-spacing="700">
		<div class="success-icon">
			<?= embed_icon('correct') ?>
		</div>

		<h1 class="section-title">Ti sei registrato con successo</h1>

		<p class="section-subtitle">
			Il tuo username è: <span class="font-bold"><?= user()->username ?></span><br>
			Potrai usare questo username o l'indirizzo email per accedere nuovamente.
		</p>

		<a href="<?= route('home') ?>" class="button button--secondary">Prosegui</a>
	</div>
</div>

{% end main %}