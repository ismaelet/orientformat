{% block content %}

<input type="hidden" class="js-field" name="field[]" value="">

<div class="main-wrap grid-flow" data-spacing="800">
	<div class="title__wrapper">
		<?= title() ?>
	</div>

	<?php if (test()->completed) { ?>

		<div class="center-content grid-flow" data-spacing="700">
			<p class="result-text <?= test()->percentage == 100 ? 'result-text--good' : 'result-text--bad' ?>"><?= test()->percentage == 100 ? __('tests.' . test()->id . '-right') : __('tests.' . test()->id . '-wrong') ?></p>

			<?= renderRedoButton() ?>
		</div>

	<?php } ?>

	<div class="image-grid grid-flow">

		<?php for ($i = 1; $i <= 8; $i++) { ?>

			<div class="image-box load--fade-in js-load" data-direction="bottom" data-delay="<?= $i % 4 ?>">
				<img src="<?= client_path('image-' . $i) ?>" alt="">
			</div>

		<?php } ?>

		<div class="image-box image-box--empty load--fade-in js-load js-empty-image <?= test()->completed && test()->percentage == 100 ? 'image-box--correct' : '' ?>" data-direction="bottom" data-delay="1">
			<img src="<?= test()->completed ? client_path('answer-' . test()->rawResults[0]) : '' ?>" alt="">
		</div>

	</div>

	<?php if (!test()->completed) { ?>

		<div class="center-content grid-flow" data-spacing="700">
			<h3 class="subsection-title"><?= __('tests.' . test()->id . '-title') ?></h3>
			<div class="answers">

				<?php for ($i = 1; $i <= 8; $i++) { ?>

					<div class="image-box image-box--answer load--fade-in js-load js-answer" id="asnwer-<?= $i ?>" data-direction="bottom" data-delay="<?= $i % 5 ?>" data-id="<?= $i ?>">
						<img src="<?= client_path('answer-' . $i) ?>" alt="">
					</div>

				<?php } ?>

			</div>
		</div>

	<?php } ?>

	<div>
		<?= submit(true) ?>
	</div>
</div>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

{% end content %}