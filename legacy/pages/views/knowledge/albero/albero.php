{% block content %}

<div class="title__wrapper main-wrap">
	<?= title() ?>
	<?= submit() ?>
	<?= renderSaveButton(true) ?>
</div>

<!-- Tree -->
<section class="tree-wrapper">
	<div class="tree <?= $legacyTest->completed ? 'completed' : '' ?>">
		<!-- Side images -->
		<div class="tree__side-image" <?= background_image('tree-1') ?>></div>
		<div class="tree__side-image" <?= background_image('tree-3') ?>></div>

		<!-- Center content -->
		<div class="tree__center">
			<!-- Tree image -->
			<img class="tree__center-image" src="<?= client_path('tree-2') ?>" alt="">

			<?php

			$fruitId = 0;

			for ($i = 1; $i <= 5; $i++) { ?>

				<div class="branch js-branch <?= empty($branchResults[$i]) ? '' : 'active' ?>" data-id="<?= $i ?>">

					<!-- Branch value -->
					<input type="hidden" class="js-branch-value" name="branch[]" value="<?= $branchResults[$i] ?? null ?>">

					<!-- Branch layers -->
					<div class="branch__highlight js-branch-highlight" <?= background_image('branch-highlight-' . $i) ?>>
					</div>

					<div class="branch__leaves js-branch-leaves" <?= background_image('branch-' . $i) ?>>
					</div>

					<div class="branch__interaction js-branch-interaction js-open-modal" data-target="branch-modal"></div>

					<p class="branch__name js-branch-name"><?= $branchResults[$i] ?? null ?></p>

					<!-- Fruits -->
					<?php for ($j = 1; $j <= 3; $j++) {

						$fruitId++;

					?>

						<div class="fruit js-fruit <?= empty($fruitsResults[$fruitId]) ? '' : 'active' ?>" data-fruit-id="<?= $fruitId ?>">
							<input type="hidden" class="js-fruit-value" name="fruit[]" value="<?= $fruitsResults[$fruitId] ?? null ?>" data-fruit-id="<?= $fruitId ?>">

							<div class="fruit__content grid-flow stack-content center-content js-fruit-interaction js-open-modal" data-target="fruit-modal">
								<div class="fruit__images grid-flow stack-content">
									<img class="fruit__image" src="<?= client_path('fruit-' . $i) ?>">
									<img class="fruit__image fruit__image--highlight " src="<?= client_path('fruit-' . $i . '-highlight') ?>">
								</div>

								<div class="fruit__add">
									<?= embed_icon('add') ?>
								</div>
							</div>

							<p class="fruit__name js-fruit-name"><?= $fruitsResults[$fruitId] ?? null ?></p>
						</div>

					<?php } ?>

				</div>

			<?php } ?>

		</div>
	</div>
</section>

<section class="modal" id="branch-modal">
	<div class="modal__content grid-flow center-content" data-spacing="700">
		<h2 class="subsection-title">Inserisci il nome della categoria</h2>
		<input type="text" class="fa-center js-branch-name-input" placeholder="Per es. musica, arte, sport o abilità manuali" maxlength="25">
		<button type="button" class="button js-add-branch js-close-modal">Inserisci</button>
	</div>
</section>

<section class="modal" id="fruit-modal">
	<div class="modal__content grid-flow center-content" data-spacing="700">
		<h2 class="subsection-title">Inserisci la competenza</h2>
		<input type="text" class="fa-center js-fruit-name-input" placeholder="Per es. suonare la chitarra, giocare a calcio, disegnare, ecc." maxlength="25">
		<button type="button" class="button js-add-fruit js-close-modal">Inserisci</button>
	</div>
</section>

{% end content %}