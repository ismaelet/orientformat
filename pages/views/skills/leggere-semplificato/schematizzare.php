{% block content %}

<div class="main-wrap">

	<div class="title__wrapper mar-b-4">
		<?= title() ?>

		<div>
			<?= submit(true) ?>
			<?= skip() ?>
		</div>
	</div>

	<?php if ($test->completed || !$supervisorView) { ?>

		<h3 class="section-title center-content">Schema</h3>

		<div id="graph-box" class="pos-rel">
			<div id="graph" class="pos-rel">

				<p id="graph-text1" class="graph-text txt-12rem fw-bold txt-c3">se</p>
				<p id="graph-text2" class="graph-text txt-12rem fw-bold txt-c3">normalmente</p>

				<?php for ($i = 1; $i < 15; $i++) { ?>

					<div id="line<?= $i ?>" class="graph-line"></div>

				<?php } ?>

				<?php foreach ($boxes as $key => $box) { ?>

					<div id="box<?= $key ?>" class="box gradient-overlay <?= $box['classes'] ?>">

						<p class="txt-wht txt-1rem cenY wid-100 fa-center"><?= $box['text'] ?></p>

						<?php if (!$box['autofilled']) { ?>

							<input type="hidden" class="filler-inp" name="field[]" value="0">

							<div class="reset clickable icon-box">
								<?= icon_embed('close') ?>
							</div>

						<?php } ?>

					</div>

				<?php } ?>

			</div>
		</div>

	<?php } else if ($supervisorView) { ?>

		<?= no_results() ?>

	<?php } ?>

	<?php if (!$test->completed && !$supervisorView) { ?>

		<h3 class="section-title center-content mar-b-2">Elementi</h3>
		<div id="causes" class="mar-b-5">

			<?php foreach ($boxes as $key => $box) if (!$box['autofilled']) { ?>

				<div id="cause<?= $key ?>" class="cause pos-rel" data-id="<?= $key ?>">
					<p class="txt-wht txt-1rem cenY wid-100 fa-center"><?= $box['content'] ?></p>
				</div>

			<?php } ?>

		</div>

	<?php } ?>

</div>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

{% end content %}