{% extends test %}

{% block content %}

<div class="main-wrap grid-flow" data-spacing="800">
	<div class="title__wrapper">
		<?= title() ?>
		<?= no_results() ?>
	</div>

	<?php if ($requiredTest->completed) { ?>

		<div id="grid" class="grid" style="--_range: <?= $range ?>">

			<?php foreach ($answers as $key => $answer) { ?>

				<div class="question-box">
					<p class="question txt-c3 txt-line">
						<span class="txt-bold"><?= $key ?>.</span> <?= $categories[$key] ?? $answer['question'] ?>
					</p>
					<p class="question-focus"><?= $categories[$key] ?? $answer['question'] ?></p>
				</div>

				<div class="score-box">
					<div class="score js-load" style="--_score: <?= $answer['result'] ?>; --_delay: <?= $key / 20 ?>s">
						<div class="score-gradient bgr"></div>
					</div>
				</div>

			<?php } ?>

			<div class="question-box">
				<p class="question total txt-c3 txt-bold txt-line"><?= __('Total') ?></p>
			</div>

			<div class="score-box">
				<div class="score js-load" style="--_score: <?= $average ?>; --_delay: .1s">
					<div class="score-gradient bgr">
						<p class="contrasting-background total-num cenY txt-2rem txt-bold txt-c3"><?= round($average / ($range - 1) * 100) ?> %</p>
					</div>
				</div>
			</div>

		</div>

	<?php } ?>

	<?= submit() ?>

</div>

{% end content %}