{% block content %}

<div class="main-wrap" autocomplete="off">

	<div id="body" class="grid va-items-cen pad-b-5">

		<!-- Graphic -->
		<?php if ($test->completed || !$supervisorView) { ?>

			<div id="page-graph-box" class="txt-0 cell">

				<div id="page-graph" class="fill-all">

					<?php

					$count = 13;

					for ($i = 0; $i < $count; $i++) {

						$angle = deg2rad(360 / ($count - 1) * ($i - 1));

						if ($test->completed) $right = $i ? eval_num($test->rawResults, $i) : $test->percentage == 100;

						$val = $test->completed ? $test->rawResults[$i] : ''; ?>

						<?php if ($i) { ?>

							<div id="page-graph-line<?= $i; ?>" class="page-graph-line js-load line-g<?= $i % (($count - 1) / 2); ?> <?php if ($test->completed) echo $right ? 'right' : 'wrong'; ?>" style="--i:<?= $i; ?>"></div>

						<?php } ?>

						<div id="page-graph-box<?= $i; ?>" class="page-graph-box <?= $i ? 'circle js-load' : 'origin'; ?> <?php if ($test->completed) echo $right ? 'right' : 'wrong'; ?>" data-id="<?= $i; ?>" style="--w:<?= cos($angle); ?>; --h:<?= sin($angle); ?>">

							<input type="number" class="inp fa-center txt-wht inp-num filler-inp" name="field[]" onKeyPress="if(this.value.length==3) return false;" autocomplete="new-password" data-group="<?= $i ? $i % (($count - 1) / 2) : -1; ?>" min="0" value="<?= $val; ?>" <?= $test->completed ? 'disabled' : ''; ?> required>

						</div>

					<?php } ?>
				</div>
			</div>
		<?php } else if ($supervisorView) { ?>

			<?= no_results() ?>

		<?php } ?>

		<div class="grid-flow pad-v-3" data-spacing="700">

			<!-- Title -->
			<?= title() ?>

			<?php if ($test->completed && !$supervisorView) { ?>

				<div class="grid-flow center-content" data-spacing="400">
					<p class="txt-12rem">Hai risolto il test al <span class="fw-bold fc-primary"><?= $test->percentage ?>%</span></p>

					<?php if ($test->percentage != 100) {
						echo renderRedoButton(true);
					} ?>

				</div>

			<?php } ?>

			<div>
				<?= submit(true) ?>
				<?= skip() ?>
			</div>

		</div>
	</div>
</div>

{% end content %}