{% block content %}

<div class="test__body main-wrap grid" data-spacing="800">
	<div class="title__wrapper">
		<?= title() ?>
	</div>

	<?php if (test()->completed) { ?>

		<p class="result__text">
			Hai trovato il <span><?= test()->percentage ?>%</span> dei messaggi nascosti.
		</p>

	<?php } ?>

	<div class="cryptograms grid" data-spacing="800">

		<?php foreach ($texts as $cryptogramKey => $cryptogram) {
			$cryptogram = explode(' ', $cryptogram);
			$cryptogramId = $cryptogramKey + 1;
		?>

			<div class="cryptogram cryptogram--<?= test()->completed ? ($legacyTestResults[$cryptogramId] == $correctResults[$cryptogramId] ? 'correct' : 'wrong') : null ?>" data-id="<?= $cryptogramId ?>">
				<p class="cryptogram__text">

					<?php foreach ($cryptogram as $fragmentKey => $fragment) {
						$fragmentId = $fragmentKey + 1;
					?>

						<label class="cryptogram__fragment">
							<input type="checkbox" class="hidden js-field" name="field[]" value="<?= $cryptogramId . '-' . $fragmentId ?>">

							<span class="<?= in_array($fragmentId, $correctResults[$cryptogramId]) ? 'solutionFragment' : null ?>">
								<?= $fragment ?>
							</span>
						</label>

					<?php } ?>
				</p>
			</div>

		<?php } ?>

	</div>

	<div class="grid" data-spacing="400">
		<div>
			<?= submit() ?>
			<?= skip() ?>
		</div>

		<?= renderRedoButton() ?>
	</div>
</div>

{% end content %}