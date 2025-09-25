{% block content %}

<div class="main-wrap pad-t-5 mar-b-5 grid" data-spacing="800">

	<?= title() ?>
	<?= submit(true) ?>

	<!-- Graphic -->
	<?php if (!isSupervisor() || $legacyTest->completed) { ?>

		<section id="graphic" class="">
			<div id="graphic-pan">

				<?php foreach ($graphData as $key => $data) {
					$fieldId = $key + 1;
					$val = $legacyTest->completed ? $legacyTest->rawResults[$key] : 0;
				?>

					<div id="graph-col<?= $fieldId; ?>" class="graph-col js-load load--fade-in" data-direction="top" data-id="<?= $fieldId; ?>">
						<input type="hidden" class="filler-inp" name="field[]" value="<?= $val; ?>">
						<div class="ele-box">

							<?php for ($i = 5; $i > 0; $i--) { ?>

								<div class="graph-ele bgr-e <?php if ($legacyTest->completed) echo 'disabled'; ?>" data-val="<?= $i; ?>">
									<p class="score-txt font-bold txt-09rem txt-wht cen"><?= $i; ?></p>
								</div>

							<?php } ?>

						</div>
						<p class="name txt-09rem"><?= $data['name'] ?></p>
					</div>

				<?php } ?>

			</div>
		</section>

	<?php } else if (isSupervisor()) { ?>

		<?= no_results() ?>

	<?php } ?>

	<!-- Columns descriptions -->
	<div id="desc-pan" class="">
		<div id="desc-box" class="grid stack-content">

			<?php foreach ($graphData as $key => $data) {
				$fieldId = $key + 1;
			?>

				<div class="field-info grid js-field-info" data-id="<?= $fieldId ?>" data-spacing="400">
					<h3 class="desc-title txt-blk font-bold txt-15rem"><?= $data['name'] ?></h3>
					<p class="desc-txt txt-1rem txt-blk"><?= $data['description'] ?></p>
				</div>

			<?php } ?>

		</div>
	</div>
</div>

{% end content %}