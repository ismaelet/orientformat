{% block content %}

<div class="main-wrap grid" data-spacing="800">
	<div class="title__wrapper">
		<?= title() ?>
	</div>

	<div class="grid" data-spacing="700">

		<?php if (legacy_test()->completed) { ?>

			<p class="result <?= legacy_test()->percentage == 100 ? 'result--correct' : 'result--wrong' ?>"><?= legacy_test()->percentage == 100 ? 'La soluzione è corretta!' : 'La soluzione è sbagliata, ma puoi riprovare quando vuoi' ?></p>

		<?php } else { ?>

			<input type="number" class="answer js-field" name="field[]" placeholder="Risposta">

		<?php } ?>

		<?= submit(true) ?>
		<?= renderRedoButton() ?>
	</div>

	<div class="page__content">
		<img src="<?= client_path('image') ?>" alt="">
	</div>
</div>

{% end content %}