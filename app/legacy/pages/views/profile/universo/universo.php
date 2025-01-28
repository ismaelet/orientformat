{% block content %}

<div class="title__wrapper main-wrap contrasting-background mar-b-3">
	<?= title() ?>
	<?= submit() ?>
	<?= renderSaveButton(true) ?>
</div>

<section class="map grid-flow stack-content center-content">
	<div class="map__background fill-all background-fill" <?= background_image('background') ?>></div>
	<div class="map__system grid-flow stack-content center-content">

		<div class="orbits grid-flow stack-content center-content">

			<?php

			$planetId = 0;

			for ($i = 1; $i <= 5; $i++) { ?>

				<div class="orbit">

					<?php for ($j = 1; $j <= 3; $j++) {
						$planetId++;
					?>

						<div class="planet grid-flow center-content <?= !isSupervisor() ? 'js-planet js-open-modal' : '' ?>" data-planet-id="<?= $planetId ?>" data-target="interest-modal">
							<input type="hidden" class="js-planet-field" name="field[]" value="<?= test()->rawResults ? test()->rawResults[$planetId - 1] : null ?>">
							<img src="<?= client_path('planet-' . $planetId . '.svg') ?>" alt="" class="planet__image">
							<p class="planet__text js-planet-text"><?= test()->rawResults ? test()->rawResults[$planetId - 1] : null ?></p>
						</div>

					<?php } ?>

				</div>

			<?php } ?>

		</div>

		<div class="star grid-flow stack-content center-content">
			<img class="star__image" src="<?= client_path('star.svg') ?>">
			<p class="star__me heading-like">IO</p>
		</div>
	</div>
</section>

<section class="modal" id="interest-modal">
	<div class="modal__content contrasting-background grid-flow center-content" data-spacing="700">
		<h2 class="subsection-title">Inserisci l'interesse</h2>
		<input type="text" class="modal-input js-interest" placeholder="Interesse" maxlength="50">
		<button type="button" class="button js-add-interest js-close-modal">Inserisci</button>
	</div>
</section>

{% end content %}