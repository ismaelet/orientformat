{% block content %}

<div class="main-wrap pad-t-5">

	<div id="body" class="pad-b-5">

		<!-- Title and instructions -->
		<?= title() ?>

		<?php if ($test->completed || !$supervisorView) { ?>

			<section class="page-body <?= $test->completed ? 'test-completed' : '' ?>">
				<!-- Full shape -->
				<div id="full-shape" class="mar-t-3" <?= background_image('shape.png'); ?>></div>

				<!-- Solution -->
				<div id="solution" class="mar-t-3 mar-b-3 grid-flow center-content  <?php if ($test->completed) echo $test->percentage ? 'right' : 'wrong'; ?>" data-spacing="700">

					<div class="grid-flow center-content" data-spacing="400">
						<h3 class="subsection-title txt-c3 mar-b-05">Soluzione</h3>

						<?php if ($test->completed) { ?>

							<p id="solution-txt" class="txt-11rem fw-bold <?= $test->percentage ? 'right' : 'wrong'; ?>">

								<?php if (!$supervisorView) { ?>

									<?= $test->percentage ? 'Ottimo! La combinazione scelta è corretta.' : 'La combinazione scelta non è corretta, ma puoi ritentare quando vuoi.' ?>

								<?php } else { ?>

									<?= $test->percentage ? 'La combinazione scelta è corretta.' : 'La combinazione scelta non è corretta.' ?>

								<?php } ?>

							</p>

							<?php if (!$test->percentage) {
								echo renderRedoButton();
							} ?>

						<?php } ?>

					</div>

					<div id="solution-box" class="fa-center txt-0rem pad-v-1 full-width">

						<?php for ($i = 1; $i <= $count; $i++) {
							$val = $test->completed ? $test->rawResults[$i - 1] : '';
						?>

							<input type="text" name="field[]" placeholder="" value="<?= $val; ?>" class="filler-inp mar-h-1 shape-inp txt-upp" onKeyPress="if(this.value.length>1) return false;" <?= $test->completed ? 'disabled' : ''; ?>>

						<?php } ?>

					</div>

					<div class="max-width--300 full-width">
						<!-- Submit -->
						<?= submit(true) ?>

						<!-- Skip -->
						<?= skip() ?>
					</div>
				</div>

				<!-- Shapes -->
				<div id="shapes" class="grid4 grid2-480w">

					<?php for ($i = 1; $i < 9; $i++) { ?>

						<div id="shape-box<?= $i; ?>" class="shape-box">

							<h1 class="shape-num txt-2rem fw-bold mar-b-05"><?= $answers[$i - 1] ?>.</h1>
							<div class="shape" <?= background_image('shape' . $i . '.png'); ?>></div>

						</div>

					<?php } ?>

				</div>
			</section>

		<?php } else if ($supervisorView) { ?>

			<?= no_results() ?>

		<?php } ?>

	</div>
</div>

{% end content %}