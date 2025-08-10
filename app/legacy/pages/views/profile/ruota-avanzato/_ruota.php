{% block content %}

<input type="hidden" class="js-field js-field-emotion" name="field[]" value="<?= $resultEmotion ?>">
<input type="hidden" class="js-field-intensity" name="field[]" value="<?= $resultIntensity ?>">

<div class="title__wrapper main-wrap">
	<?= title() ?>
	<?= submit(true) ?>
</div>

<div class="wheel-wrapper js-wheel">
	<div class="main-wrap">
		<section class="wheel" style="--emotion-count: <?= $emotionCount ?>">

			<div class="wheel__center grid center-content stack-content">
				<img class="wheel__arrow js-arrow" src="<?= client_path('/pages/assets/profile/ruota/ruota/arrow.svg') ?>">
				<p class="wheel__counter" data-step="<?= $step ?>">
					<?= $stepNames[$step - 1] ?><br>ruota
				</p>
			</div>

			<?php foreach ($emotions as $key => $emotion) {
				$chosen = in_array($emotion, $resultEmotions);
				$emotionKey = $chosen ? array_search($emotion, $resultEmotions) : null;
				$intensity = $chosen ? $resultIntensities[$emotionKey] : null;
			?>

				<div class="emotion <?= $chosen ? 'chosen' : 'js-emotion' ?>" style="--i: <?= $key + 1 ?>;" data-emotion="<?= $emotion ?>" data-intensity="<?= $chosen ? $intensity : '' ?>">
					<div class="emotion__content">
						<div class="emotion__dot gradient-overlay <?= !$legacyTest->completed && !$chosen ? 'js-emotion-dot' : null ?>">
							<p class="<?= !$legacyTest->completed && !$chosen ? 'js-emotion-value' : null ?>"><?= $chosen ? $intensity : null ?></p>
						</div>

						<p class="emotion__name" data-emotion="<?= $emotion ?>"><?= $emotion ?></p>

						<div class="emotion__scores">

							<?php for ($j = 1; $j <= 4; $j++) { ?>

								<label class="emotion__score js-emotion-score" style="--j: <?= $j ?>;" data-value="<?= $j ?>">
									<?= $j ?>
								</label>

							<?php } ?>

						</div>
					</div>
				</div>

			<?php } ?>

		</section>
	</div>
</div>

{% end content %}