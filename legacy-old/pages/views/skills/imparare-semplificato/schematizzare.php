{% block content %}

<div class="main-wrap">

	<div class="title__wrapper mar-b-4">
		<?= title() ?>
	</div>

	<?php if ($test->completed || !isSupervisor()) { ?>

		<h3 class="section-title center-content">Schema</h3>

		<div id="graph-box" class="pos-rel">
			<div id="graph" class="pos-rel">

				<?php foreach ($boxes as $key => $box) { ?>

					<div id="box<?= $key ?>" class="box gradient-overlay <?= $box['classes'] ?> <?= $box['type'] == 1 ? 'box--solid js-box--solid' : 'box--dashed js-box--dashed' ?>">

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

	<?php } else if (isSupervisor()) { ?>

		<?= no_results() ?>

	<?php } ?>

	<?php if (!$test->completed && !isSupervisor()) { ?>

		<h3 class="section-title center-content mar-b-2">Elementi</h3>
		<div id="causes" class="mar-b-5">
			<div class="flex-line">
				<?php foreach ($boxes as $key => $box) {
					if (!$box['autofilled'] && $box['type'] == 1) { ?>

						<div id="cause<?= $key ?>" class="cause cause--solid js-box--solid" data-id="<?= $key ?>">
							<p class="txt-wht txt-1rem"><?= $box['content'] ?></p>
						</div>

				<?php }
				} ?>
			</div>

			<div class="flex-line">
				<?php foreach ($boxes as $key => $box) {
					if (!$box['autofilled'] && $box['type'] == 2) { ?>

						<div id="cause<?= $key ?>" class="cause cause--dashed js-box--dashed" data-id="<?= $key ?>">
							<p class="txt-wht txt-1rem"><?= $box['content'] ?></p>
						</div>

				<?php }
				} ?>
			</div>

		</div>

	<?php } ?>

	<div>
		<?= submit(true) ?>
		<?= skip() ?>
	</div>

</div>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

{% end content %}