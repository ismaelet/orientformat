{% block content %}

<div class="main-wrap pad-t-4 pad-b-5">

	<?= title() ?>

	<?php if ($sibling->completed) { ?>

		<div class="page-content mar-t-5 mar-b-5">

			<div class="page-grid page-grid--header">
				<h3 class="page-grid_title txt-line font-bold txt-c3">Distraibilità</h3>
				<h3 class="page-grid_title txt-line font-bold txt-c3">Iperattività</h3>
			</div>

			<div class="page-grid page-grid--body">

				<?php foreach ($answers as $key => $answer) {
					if ($key % 2) { ?>

						<div class="score-box left">
							<div class="score score<?= $answer['result'] ?> <?= $answer['critical'] ? 'critical' : '' ?>">
								<div class="score-gradient bgr"></div>
							</div>
						</div>

						<div class="number-box left">
							<h3 class="number">Domanda <?= $key ?></h3>
							<p class="question cen txt-09rem txt-ita fa-center"><?= $answer['question'] ?></p>
						</div>

					<?php } else { ?>

						<div class="number-box right">
							<h3 class="number">Domanda <?= $key ?></h3>
							<p class="question cen txt-09rem txt-ita fa-center"><?= $answer['question'] ?></p>
						</div>

						<div class="score-box right">
							<div class="score score<?= $answer['result'] ?> <?= $answer['critical'] ? 'critical' : '' ?>">
								<div class="score-gradient bgr"></div>
							</div>
						</div>

					<?php } ?>
				<?php } ?>

				<!-- Total -->
				<div class="score-box left">
					<div class="score <?= $focus['critical'] ? 'critical' : '' ?>" style="width: <?= $focus['width'] ?>%;">
						<div class="score-gradient bgr"></div>
					</div>
				</div>

				<div class="number-box left">
					<h1 class="number total font-bold txt-line left">
						<span class="total_name">Totale Distraibilità:</span><br>
						<?= round($focus['width']) ?> %
					</h1>
				</div>

				<div class="number-box right">
					<h1 class="number total font-bold txt-line right">
						<span class="total_name">Totale Iperattività:</span><br>
						<?= round($hyper['width']) ?> %
					</h1>
				</div>

				<div class="score-box right">
					<div class="score <?= $hyper['critical'] ? 'critical' : '' ?>" style="width: <?= $hyper['width'] ?>%;">
						<div class="score-gradient bgr"></div>
					</div>
				</div>

				<!-- Lines -->
				<div class="page-grid_line"></div>
				<div class="page-grid_line"></div>
			</div>
		</div>

		<?= submit() ?>

	<?php } else echo no_results() ?>

</div>

{% end content %}