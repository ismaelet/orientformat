{% block content %}

<input type="hidden" class="js-score" name="field[]" value="<?= legacy_test()->completed ? legacy_test()->rawResults[0] : 0 ?>">

<div class="main-wrap grid" data-spacing="900">
	<div class="title__wrapper">
		<?= title() ?>
	</div>

	<?php if (legacy_test()->completed) { ?>

		<p class="result__text"><?= __('tests.135-result', ['percentage' => legacy_test()->percentage]) ?></p>

	<?php } ?>

	<div class="page-content grid" data-spacing="800">
		<h3 class="subsection-title center-content">L'8 MARZO È LA FESTA DELLA DONNA. PARLA DELLA CONDIZIONE FEMMINILE</h3>

		<p class="test-text js-text <?= legacy_test()->completed ? 'test-text--right-version' : '' ?>">

			<?php

			$errorId = 0;
			foreach ($text as $textPart) {
				if (is_array($textPart)) {
					$errorId++;
					$found = legacy_test()->completed && (legacy_test()->rawResults[$errorId] ?? false);

					echo '<label class="test-text__part error-type--' . (!legacy_test()->completed || $found ? $textPart[2] : 'skipped') . ' js-text-error"><input type="hidden" class="js-field" name="field[]" value="0"><span class="test-error">' . ($found ? $textPart[1] : $textPart[0]) . '</span></label>';
				} else {
					echo $textPart;
				}
			} ?>

		</p>

		<p class="fa-right">Da D’Orta M. (1994),<span class="italic">Io speriamo che me la cavo. Sessanta temi di bambini napoletani</span>, Mondadori, Milano</p>

		<section class="markers grid <?= legacy_test()->completed ? 'markers--completed' : '' ?>" data-spacing="400">
			<div class="marker grid center-content" data-marker-type="1"><?= __('tests.135-error-type-1') ?></div>
			<div class="marker grid center-content" data-marker-type="2"><?= __('tests.135-error-type-2') ?></div>
			<div class="marker grid center-content" data-marker-type="3"><?= __('tests.135-error-type-3') ?></div>
			<div class="marker grid center-content" data-marker-type="4"><?= __('tests.135-error-type-4') ?></div>

			<?php if (legacy_test()->completed) { ?>
				<div class="marker grid center-content" data-marker-type="5"><?= __('tests.135-missed') ?></div>
			<?php } ?>
		</section>
	</div>

	<div class="grid" data-spacing="700">
		<?= renderRedoButton(true) ?>

		<div>
			<?= submit() ?>
			<?= skip() ?>
		</div>
	</div>
</div>

{% end content %}