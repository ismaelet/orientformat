{% block content %}

<div class="main-wrap">
	<div class="title__wrapper">
		<?= title() ?>
		<?= submit(true) ?>
	</div>

	<?php if ($test->completed || !$supervisorView) { ?>

		<div id="content" class="wrap">

			<!-- Hexagons -->
			<div id="hexagons" class="<?= $test->completed ? 'completed' : '' ?>">

				<?php for ($i = 1; $i < 5; $i++) { ?>

					<div id="hexagon<?= $i ?>" class="hexagon cen" style="--w: <?= ($i - 1) * 150 ?>px;">

						<div class="hexagon__background fill-all"></div>

						<?php for ($j = 1; $j < 7; $j++) {
							$active = $test->completed ? $test->rawResults[$j - 1] == 5 - $i : false;
						?>

							<div class="number-box number-box<?= $j ?>">
								<p class="number txt-12rem fw-bold clickable <?= $active ? 'active' : '' ?>" data-question="<?= $j ?>" data-val="<?= 5 - $i ?>">
									<?= (4 - $i) ?>
								</p>
							</div>

						<?php } ?>

					</div>

				<?php } ?>

				<?php foreach ($questions as $key => $question) { ?>

					<input type="hidden" id="field<?= $key ?>" class="filler-inp" name="field[]" value="<?= $test->completed ? $test->rawResults[$key - 1] : 0 ?>">
					<p id="question<?= $key ?>" class="question txt-12rem fw-bold txt-c3"><?= $question ?></p>

				<?php } ?>

			</div>
		</div>

	<?php } else if ($supervisorView) { ?>

		<?= no_results() ?>

	<?php } ?>

</div>

{% end content %}