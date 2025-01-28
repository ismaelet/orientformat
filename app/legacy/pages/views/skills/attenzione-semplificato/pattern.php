{% block content %}

<input type="hidden" class="js-score" name="field[]" value="0">

<div class="main-wrap grid-flow" data-spacing="800">
	<section class="title__wrapper">

		<?php if (!test()->completed) {
			echo title();
		} else {
			echo title(null, ' ');
		} ?>

	</section>

	<?php if (!test()->completed) { ?>

		<section class="pattern">
			<p class="pattern__text"><?= $letters ?></p>
		</section>

	<?php } else { ?>

		<div class="result grid-flow center-content" data-spacing="600">
			<p class="result__text">hai trovato il</p>
			<h3 class="result__value"><?= test()->percentage ?>%</h3>
			<p class="result__text">delle combinazioni</p>
		</div>

	<?php } ?>

	<div class="grid-flow" data-spacing="700">
		<?= renderRedoButton(true) ?>

		<div>
			<?= submit() ?>
			<?= skip() ?>
		</div>
	</div>
</div>

{% end content %}