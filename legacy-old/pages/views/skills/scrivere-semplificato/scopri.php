{% block content %}

<input type="hidden" class="js-score" name="field[]" value="<?= test()->completed ? test()->rawResults[0] : 0 ?>">

<div class="main-wrap grid-flow" data-spacing="900">
	<div class="title__wrapper">
		<?= title() ?>
	</div>

	<?php if (test()->completed) { ?>

		<p class="result__text">Hai identificato il <span class="result__score"><?= test()->percentage ?>%</span> degli errori.</p>

	<?php } ?>

	<div class="page-content grid-flow" data-spacing="800">
		<h3 class="subsection-title center-content">L'8 MARZO È LA FESTA DELLA DONNA. PARLA DELLA CONDIZIONE FEMMINILE</h3>

		<p class="test-text js-text <?= test()->completed ? 'test-text--right-version' : '' ?>">

			<?php
			$errorId = 0;
			foreach ($text as $textPart) {
				if (is_array($textPart)) {
					$errorId++;
					$found = test()->completed && test()->rawResults[$errorId];

					echo '<label class="test-text__part error-type--' . (!test()->completed || $found ? $textPart[2] : 'skipped') . ' js-text-error"><input type="hidden" class="js-field" name="field[]" value="0"><span class="test-error">' . ($found ? $textPart[1] : $textPart[0]) . '</span></label>';
				} else {
					echo $textPart;
				}
			} ?>

		</p>

		<p class="fa-right">Da D’Orta M. (1994),<span class="fy-italic">Io speriamo che me la cavo. Sessanta temi di bambini napoletani</span>, Mondadori, Milano</p>

		<section class="markers grid-flow <?= test()->completed ? 'markers--completed' : '' ?>" data-spacing="400">
			<div class="marker grid-flow center-content" data-marker-type="1">LETTERE SBAGLIATE O MANCANTI</div>
			<div class="marker grid-flow center-content" data-marker-type="2">SEPARAZIONI O FUSIONI SBAGLIATE</div>
			<div class="marker grid-flow center-content" data-marker-type="3">PAROLE SCELTE MALE O DI TROPPO</div>
			<div class="marker grid-flow center-content" data-marker-type="4">VERBI SBAGLIATI</div>

			<?php if (test()->completed) { ?>
				<div class="marker grid-flow center-content" data-marker-type="5">Errori non individuati</div>
			<?php } ?>
		</section>
	</div>

	<div class="grid-flow" data-spacing="700">
		<?= renderRedoButton(true) ?>

		<div>
			<?= submit() ?>
			<?= skip() ?>
		</div>
	</div>
</div>

{% end content %}