{% block content %}

<div class="main-wrap pad-t-5 mar-b-5 grid-flow" data-spacing="800">

	<?= title() ?>
	<?= submit(true) ?>

	<!-- Graphic -->
	<?php if (!isSupervisor() || $test->completed) { ?>

		<section id="graphic" class="">
			<div id="graphic-pan">

				<?php foreach ($graph_data as $key => $column) {
					$fieldID = $key + 1;
					$val = $test->completed ? $test->rawResults[$key] : 0;
				?>

					<div id="graph-col<?= $fieldID; ?>" class="graph-col js-load load--fade-in" data-direction="top" data-id="<?= $fieldID; ?>">
						<input type="hidden" class="filler-inp" name="field[]" value="<?= $val; ?>">
						<div class="ele-box">

							<?php for ($i = 5; $i > 0; $i--) { ?>

								<div class="graph-ele bgr-e <?php if ($test->completed) echo 'disabled'; ?>" data-val="<?= $i; ?>">
									<p class="score-txt fw-bold txt-09rem txt-wht cen"><?= $i; ?></p>
								</div>

							<?php } ?>

						</div>
						<p class="name txt-09rem"><?= $column[0]; ?></p>
					</div>

				<?php } ?>

			</div>
		</section>

	<?php } else if (isSupervisor()) { ?>

		<?= no_results() ?>

	<?php } ?>

	<!-- Columns descriptions -->
	<div id="desc-pan" class="">
		<div id="desc-box" class="grid-flow stack-content">

			<?php foreach ($graph_data as $key => $column) {
				$fieldID = $key + 1;

			?>

				<div class="field-info grid-flow js-field-info" data-id="<?= $fieldID ?>" data-spacing="400">
					<h3 class="desc-title txt-blk fw-bold txt-15rem"><?= $column[0] ?></h3>
					<p class="desc-txt txt-1rem txt-blk"><?= $column[1] ?></p>
				</div>

			<?php } ?>

		</div>
	</div>
</div>

{% end content %}