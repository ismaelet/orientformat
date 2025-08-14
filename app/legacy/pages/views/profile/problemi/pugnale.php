{% block content %}

<div class="main-wrap grid" data-spacing="900">
	<div class="title__wrapper center-content">
		<?= title() ?>

		<?php if (test()->completed) { ?>

			<div>
				<p class="result__text">Hai associato correttamente il <span><?= test()->percentage ?>%</span> degli oggetti</p>
			</div>

		<?php } ?>

		<?= no_results() ?>
	</div>

	<?php if (test()->completed || !isSupervisor()) { ?>

		<div class="characters grid" data-columns="25rem" data-row-spacing="800" data-column-spacing="800">

			<?php foreach ($characters as $characterKey => $character) { ?>

				<div class="character js-character <?= test()->completed ? (test()->rawResults[$characterKey] == $correctResults[$characterKey] ? 'correct' : 'wrong') : null ?>">
					<input type="hidden" class="js-field" name="field[]" value="0">

					<div class="character__weapon js-weapon-image-wrapper <?= test()->completed ? 'active' : null ?>">
						<?= embed_icon('weapon') ?>

						<img class="js-weapon-image" src="<?= client_path('weapon-' . test()->rawResults[$characterKey]) ?>" alt="">
					</div>

					<div class="character__body">
						<img src="<?= client_path('character-' . ($characterKey + 1)) ?>" alt="" class="character__image">
						<div class="character__text">
							<?= $character['text'] ?>
						</div>
					</div>
				</div>

			<?php } ?>

		</div>

		<?php if (!test()->completed) { ?>

			<div class="weapons grid" data-spacing="700">
				<h2 class="section-title center-content">Oggetti</h2>

				<div class="weapon-list flex">

					<?php for ($i = 1; $i <= 4; $i++) { ?>

						<div class="weapon js-weapon" data-id="<?= $i ?>">
							<img class="weapon__image" src="<?= client_path('weapon-' . $i) ?>" alt="">
						</div>

					<?php } ?>

				</div>
			</div>

		<?php } ?>
	<?php } ?>

	<div>
		<?= submit(true) ?>
	</div>
</div>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

{% end content %}