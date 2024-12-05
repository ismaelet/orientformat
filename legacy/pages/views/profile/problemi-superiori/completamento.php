<?php

$sets = _SETS;

?>

{% block content %}

<div class="main-wrap">
	<div class="title__wrapper">
		<?= title() ?>
	</div>

	<div id="body">
		<!-- Content -->
		<?php if ($legacyTest->completed || !$supervisorView) { ?>

			<section id="num-pan" data-count="<?= count($sets) ?>" class="<?= $legacyTest->completed ? 'completed' : 'uncompleted' ?>">

				<?php foreach ($sets as $key => $set) {
					$fieldID = $key + 1;

					$numbers = explode(',', $set[0]);
					$max = count($numbers);

					if ($legacyTest->completed) {
						$right = ($legacyTest->rawResults[$key] ?? 0) == $set[1];
					}

					$value = $test->completed && isset($test->rawResults[$key]) ? $test->rawResultsPa[$key] : null;
				?>

					<div class="num-row mar-t-2 px-8 py-4 <?php if ($test->completed) echo $right ? 'right' : 'wrong';
															else echo 'clickable' ?>" onclick="$(this).find('.num-emp').focus();">
						<?php foreach ($numbers as $i => $number) {

							if ($number == 'e') {

								if ($test->completed) { ?>

									<input type="hidden" class="filler-inp" value="<?= $value ?>" readonly>

									<h1 class="num num<?= $i + 1 ?> txt-wht inlb va-cen no-mob"><?= $value ?></h1>

								<?php } else { ?>

									<div class="num-emp-box num<?= $i + 1 ?> inlb no-mob">

										<input type="number" class="num-emp inp inp-num filler-inp txt-blk fa-center va-cen" name="field[]" onKeyPress="if(this.value.length==2) return false;" value="<?= $value ?>" required>

									</div>

								<?php }
							} else { ?>

								<h1 class="num num<?= $i + 1 ?> txt-blk inlb va-cen no-mob"><?= $number ?></h1>

							<?php }

							// separator
							if ($i + 1 < $max) { ?>
								<h1 class="num dots maro2 txt-blk inlb">:</h1>
						<?php }
						} ?>
					</div>

					<?php if ($legacyTest->completed) { ?>

						<p class="result-txt txt-09rem mar-t-10px font-bold txt-upp <?= $right ? 'right' : 'wrong' ?>">
							<span class="text-icon" <?= $right ? icon_css('correct/correct') : icon_css('errors/alert_red') ?>></span>
							<?= $right ? 'Giusto' : 'Sbagliato' ?>
						</p>

					<?php } ?>
				<?php } ?>

			</section>

		<?php } else if ($supervisorView) { ?>

			<?= no_results() ?>

		<?php } ?>

		<div class="mar-t-4 grid-flow" data-spacing="400">
			<?= renderRedoButton(true) ?>

			<div>
				<?= submit(true) ?>
				<?= skip() ?>
			</div>
		</div>
	</div>
</div>

{% end content %}