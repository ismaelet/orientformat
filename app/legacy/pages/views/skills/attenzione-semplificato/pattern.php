{% block content %}

<input type="hidden" class="js-score" name="field[]" value="0">

<div class="main-wrap grid" data-spacing="800">
	<section class="title__wrapper">

		<?php if (!legacy_test()->completed) {
			echo title();
		} else {
			echo title(null, ' ');
		} ?>

	</section>

	<?php if (!legacy_test()->completed) { ?>

		<section class="pattern">
			<p class="pattern__text"><?= $letters ?></p>
		</section>

	<?php } else { ?>

		<div class="result grid center-content" data-spacing="600">
			<p class="result__text"><?= __('tests.118-result-1') ?></p>
			<h3 class="result__value"><?= legacy_test()->percentage ?>%</h3>
			<p class="result__text"><?= __('tests.118-result-2') ?></p>
		</div>

	<?php } ?>

	<div class="grid" data-spacing="700">
		<?= renderRedoButton(true) ?>

		<div class="">
			<?= submit() ?>
			<?= skip() ?>
		</div>
	</div>
</div>

{% end content %}