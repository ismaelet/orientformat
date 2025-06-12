{% block content %}

<div class="test__body main-wrap grid-flow" data-spacing="800">
	<div class="title__wrapper">
		<?= title() ?>
	</div>

	<?php if (test()->completed) { ?>

		<p class="result__text <?= test()->percentage == 100 ? 'correct' : 'wrong' ?>">
			<?= test()->percentage == 100 ? __('tests.148-right') : __('tests.148-wrong') ?>
		</p>

	<?php } ?>

	<div class="test-content grid-flow center-content" data-spacing="800">

		<?php if (!test()->completed) { ?>

			<div class="flex-group center-content" data-spacing="800">
				<div class="test-group test-group--linear js-load">
					<span class="pattern-1-original"></span>
					<span class="pattern-2-original"></span>
					<span class="pattern-3-original"></span>
				</div>

				<p class="test-text">sta a</p>

				<div class="test-group test-group--radial js-load">
					<span class="pattern-3-original"></span>
					<span class="pattern-2-original"></span>
					<span class="pattern-1-original"></span>
				</div>
			</div>

			<p class="test-text">come</p>

			<div class="test-group test-group--linear js-load">
				<span class="pattern-1-match"></span>
				<span class="pattern-2-match"></span>
				<span class="pattern-3-match"></span>
			</div>

			<p class="test-text">sta a</p>

		<?php } ?>

		<div class="flex-group center-content <?= test()->completed ? 'completed' : null ?>" data-spacing="700">

			<?php for ($i = 1; $i <= 4; $i++) { ?>

				<label class="test-group test-group--radial solution js-load <?= test()->completed && test()->rawResults[0] == $i ? (test()->percentage == 100 ? 'correct' : 'wrong') : null ?>">
					<span class="pattern-<?= $patterns[$i - 1][0] ?>-match"></span>
					<span class="pattern-<?= $patterns[$i - 1][1] ?>-match"></span>
					<span class="pattern-<?= $patterns[$i - 1][2] ?>-match"></span>
					<input type="radio" class="hidden js-field" name="field[]" value="<?= $i ?>">
				</label>

			<?php } ?>

		</div>

	</div>

	<div class="" data-spacing="400">
		<?= submit(true) ?>
		<?= renderRedoButton() ?>
	</div>
</div>

{% end content %}