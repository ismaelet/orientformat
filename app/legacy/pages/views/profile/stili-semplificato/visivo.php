{% block content %}

<div class="main-wrap">

	<?php if (! legacy_test()->completed) { ?>

		<div class="title__wrapper center-content">
			<?= title() ?>

			<?php if (! legacy_test()->completed && ! isSupervisor()) { ?>

				<div class="">
					<div class="start-button button js-start"><?= __('Start') ?></div>
				</div>

			<?php } ?>

		</div>

	<?php } elseif (legacy_test()->completed) { ?>

		<div class="title__wrapper center-content">
			<?= title(null, __('Below is indicated how many objects you have identified among those you have seen or heard and how many mistakes you have made.')) ?>
		</div>

		<div class="grid mar-t-2 mar-b-4" data-spacing="700">

			<div class="result-grid">
				<div class="result-grid__column gradient-overlay js-load" style="height: <?= 10 + $viewScore * 0.9 ?>%;">
					<p class="result-grid__score"><?= $viewCount.'/'.$maxView  ?></p>
				</div>
				<div class="result-grid__column gradient-overlay js-load" style="height: <?= 10 + $hearScore * 0.9 ?>%;">
					<p class="result-grid__score"><?= $hearCount.'/'.$maxHear ?></p>
				</div>
				<div class="result-grid__column gradient-overlay js-load" style="height: <?= 10 + $errorScore * 0.9 ?>%;">
					<p class="result-grid__score"><?= $errorCount.'/'.$maxErrors ?></p>
				</div>
				<p class="result-grid__column-name"><?= __('Visual style') ?></p>
				<p class="result-grid__column-name"><?= __('Auditory style') ?></p>
				<p class="result-grid__column-name"><?= __('Mistakes') ?></p>
			</div>
		</div>

		<?= submit() ?>

	<?php } ?>

	<section class="test-images grid stack-content center-content js-images">

		<?php for ($i = 1; $i <= 6; $i++) { ?>

			<div class="test-images__block js-image-set">
				<img src="<?= client_path('image-'.$i.'-1') ?>" alt="" class="test-image">
				<img src="<?= client_path('image-'.$i.'-2') ?>" alt="" class="test-image">
			</div>

		<?php } ?>

	</section>

	<section class="test-audios">

		<?php for ($i = 1; $i <= 6; $i++) { ?>

			<audio class="test-audio js-audio" src="<?= client_path('audio-'.$i.'-1.mp3') ?>" data-id="<?= $i ?>1"></audio>
			<audio class="test-audio js-audio" src="<?= client_path('audio-'.$i.'-2.mp3') ?>" data-id="<?= $i ?>2"></audio>

		<?php } ?>

	</section>

	<section class="answers grid js-answers" data-spacing="700">
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