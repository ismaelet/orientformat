{% block content %}

<div class="main-wrap grid" data-spacing="800">
	<div class="title__wrapper">
		<?= title() ?>
	</div>

	<?php if (test()->completed) { ?>

		<p class="result">Hai inserito il <span><?= test()->percentage ?>%</span> dei segni di punteggiatura corretti.</p>

	<?php } ?>

	<div class="text grid" data-spacing="700">

		<p class="text"><?= $textHtml ?></p>

	</div>

	<div class="grid" data-spacing="700">
		<div>
			<?= submit(true) ?>
			<?= skip() ?>
		</div>
		<?= renderRedoButton(true) ?>
	</div>
</div>

{% end content %}