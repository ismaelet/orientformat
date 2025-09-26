{% block content %}

<div class="title__wrapper main-wrap contrasting-background mar-b-3">
	<?= title() ?>
	<?= submit() ?>
	<?= renderSaveButton(true) ?>
</div>

<section class="map grid stack-content center-content">
	<div class="map__background fill-all background-fill" <?= background_image('background') ?>></div>
	<div class="map__system grid stack-content center-content">

		<div class="orbits grid stack-content center-content">

			<?php

			$planetId = 0;

			for ($i = 1; $i <= 5; $i++) { ?>

				<div class="orbit">

					<?php for ($j = 1; $j <= 3; $j++) {
						$planetId++;
					?>

						<div class="planet grid center-content <?= !isSupervisor() ? 'js-planet js-open-modal' : '' ?>" data-planet-id="<?= $planetId ?>" data-target="interest-modal">
							<input type="hidden" class="js-planet-field" name="field[]" value="<?= legacy_test()->rawResults ? legacy_test()->rawResults[$planetId - 1] : null ?>">
							<img src="<?= client_path('planet-' . $planetId . '.svg') ?>" alt="" class="planet__image">
							<p class="planet__text js-planet-text"><?= legacy_test()->rawResults ? legacy_test()->rawResults[$planetId - 1] : null ?></p>
						</div>

					<?php } ?>

				</div>

			<?php } ?>

		</div>

		<div class="star grid stack-content center-content">
			<img class="star__image" src="<?= client_path('star.svg') ?>">
			<p class="star__me heading-like"><?= __('ME') ?></p>
		</div>
	</div>
</section>

<section class="modal" id="interest-modal">
	<div class="modal__content contrasting-background grid center-content" data-spacing="700">
		<h2 class="subsection-title">Inserisci l'interesse</h2>
		<input type="text" class="modal-input js-interest bg-white" placeholder="Interesse" maxlength="50">
		<button type="button" class="button js-add-interest js-close-modal">Inserisci</button>
	</div>
</section>

{% end content %}