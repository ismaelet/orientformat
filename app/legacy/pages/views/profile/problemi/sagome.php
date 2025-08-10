{% block content %}

<div class="main-wrap pad-t-5">

	<div id="body" class="pad-b-5">

		<!-- Title and instructions -->
		<?= title() ?>

		<?php if ($legacyTest->completed || !$supervisorView) { ?>

			<section class="page-body <?= $legacyTest->completed ? 'test-completed' : '' ?>">
				<!-- Full shape -->
				<div id="full-shape" class="mar-t-3" <?= background_image('shape.png'); ?>></div>

				<!-- Solution -->
				<div id="solution" class="mar-t-3 mar-b-3 grid center-content  <?php if ($legacyTest->completed) echo $legacyTest->percentage ? 'right' : 'wrong'; ?>" data-spacing="700">

					<div class="grid center-content" data-spacing="400">
						<h3 class="subsection-title txt-c3 mar-b-05"><?= __('Solution') ?></h3>

						<?php if ($legacyTest->completed) { ?>

							<p id="solution-txt" class="txt-11rem font-bold <?= $legacyTest->percentage ? 'right' : 'wrong'; ?>">

								<?php if (!$supervisorView) { ?>

									<?= $legacyTest->percentage ? __('tests.' . $legacyTest->id . '-student-right') : __('tests.' . $legacyTest->id . '-student-wrong') ?>

								<?php } else { ?>

									<?= $legacyTest->percentage ? __('tests.' . $legacyTest->id . '-supervisor-right') : __('tests.' . $legacyTest->id . '-supervisor-wrong') ?>

								<?php } ?>

							</p>

							<?php if (!$legacyTest->percentage) {
								echo renderRedoButton();
							} ?>

						<?php } ?>

					</div>

					<div id="solution-box" class="fa-center justify-center flex gap-4 py-4 full-width">

						<?php for ($i = 1; $i <= $count; $i++) {
							$val = $legacyTest->completed ? ($legacyTest->rawResults[$i - 1] ?? '') : '';
						?>

							<input type="text" name="field[]" placeholder="" value="<?= $val; ?>" class="filler-inp mar-h-1 shape-inp txt-upp" onKeyPress="if(this.value.length>1) return false;" <?= $legacyTest->completed ? 'disabled' : ''; ?>>

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

							<h1 class="shape-num txt-2rem font-bold mar-b-05"><?= $answers[$i - 1] ?>.</h1>
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