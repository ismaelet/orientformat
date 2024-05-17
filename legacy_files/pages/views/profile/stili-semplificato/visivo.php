{% block content %}

<div class="main-wrap">

	<?php if (!test()->completed) { ?>

		<div class="title__wrapper center-content">
			<?= title() ?>

			<?php if (!test()->completed && !isSupervisor()) { ?>

				<div class="">
					<div class="start-button button js-start">Comincia</div>
				</div>

			<?php } ?>

		</div>

	<?php } else if (test()->completed) { ?>

		<div class="title__wrapper center-content">
			<?= title(null, 'Qui sotto è indicato quanti oggetti hai identificato tra quelli che hai visto o udito e quanti errori hai fatto.') ?>
		</div>

		<div class="grid-flow mar-t-2 mar-b-4" data-spacing="700">

			<div class="result-grid">
				<div class="result-grid__column gradient-overlay js-load" style="height: <?= $viewScore ?>%;">
					<p class="result-grid__score"><?= $viewCount . '/' . $maxView  ?></p>
				</div>
				<div class="result-grid__column gradient-overlay js-load" style="height: <?= $hearScore ?>%;">
					<p class="result-grid__score"><?= $hearCount . '/' . $maxHear ?></p>
				</div>
				<div class="result-grid__column gradient-overlay js-load" style="height: <?= max($errorScore, 10) ?>%;">
					<p class="result-grid__score"><?= $errorCount . '/' . $maxErrors ?></p>
				</div>
				<p class="result-grid__column-name">Stile<br>visivo</p>
				<p class="result-grid__column-name">Stile<br>uditivo</p>
				<p class="result-grid__column-name">Errori</p>
			</div>
		</div>

		<?= submit() ?>

	<?php } ?>

	<section class="test-images grid-flow stack-content center-content js-images">

		<?php for ($i = 1; $i <= 6; $i++) { ?>

			<div class="test-images__block js-image-set">
				<img src="<?= client_path('image-' . $i . '-1') ?>" alt="" class="test-image">
				<img src="<?= client_path('image-' . $i . '-2') ?>" alt="" class="test-image">
			</div>

		<?php } ?>

	</section>

	<section class="test-audios">

		<?php for ($i = 1; $i <= 6; $i++) { ?>

			<audio class="test-audio js-audio" src="<?= client_path('audio-' . $i . '-1.mp3') ?>" data-id="<?= $i ?>1"></audio>
			<audio class="test-audio js-audio" src="<?= client_path('audio-' . $i . '-2.mp3') ?>" data-id="<?= $i ?>2"></audio>

		<?php } ?>

	</section>

	<section class="answers grid-flow js-answers" data-spacing="700">
		<div class="answer-list">

			<?php foreach ($options as $key => $option) { ?>

				<label class="answer">
					<input type="checkbox" class="hidden" name="field[]" value="<?= $key ?>">
					<p class="answer__text"><?= $option ?></p>
				</label>

			<?php } ?>

		</div>

		<div>
			<?= submit() ?>
			<?= skip() ?>
		</div>
	</section>
</div>

{% end content %}