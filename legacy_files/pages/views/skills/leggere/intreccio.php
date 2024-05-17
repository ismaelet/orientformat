<?php

use \Legacy\Activity\Test;

?>

{% block content %}

<div class="pad-b-5 main-wrap">

	<div class="title__wrapper">
		<div>
			<?= title() ?>
			<?= no_results() ?>

			<?php if (!$supervisorView) { ?>

				<a href="<?= (new Test(70))->clientUrl ?>">
					<p class="txt-c5 txt-1rem br-b-1 br-c5 inlb">Rileggi il racconto</p>
				</a>

			<?php } ?>
		</div>

		<?php if ($test->completed && !$supervisorView) { ?>
			<div>

				<p class="result txt-15rem mar-b-2 pad-1 br-2 br-c1 fa-center">Sei riuscito a riordinare il <span class="fc-primary fw-bold"><?= $test->percentage ?> %</span> delle cause ed effetti.</p>

				<?= renderRedoButton(true) ?>

			</div>

		<?php } ?>

		<div>
			<?= submit(true) ?>
			<?= skip() ?>
		</div>
	</div>

	<?php if ($test->completed || !$supervisorView) { ?>

		<div id="graph-box" class="mar-t-4">

			<div id="graph" class="grid3">

				<?php foreach ($boxes as $key => $box) {

					if ($box) { ?>

						<div id="box<?= $key ?>" class="box <?= $box['classes'] ?> <?= $box['reader'] ? 'reader' : '' ?>">

							<p class="txt-1rem fa-center"><?= $box['text'] ?></p>

							<?php if (!$box['autofilled']) { ?>

								<input type="hidden" class="filler-inp" name="field[]" value="0">

								<div class="reset clickable bgr bgr-red" <?= icon_svg('close') ?>></div>

							<?php } ?>

						</div>

					<?php } else { ?>

						<div class="empty"></div>

					<?php } ?>
				<?php } ?>

			</div>

		</div>

		<?php if (!$test->completed) { ?>

			<h2 class="subsection-title txt-blk txt-15rem fw-bold mar-t-3">Elementi:</h2>
			<div id="causes" class="mar-b-3 mar-t-2 grid3">

				<?php foreach ($boxes as $key => $box) if ($box && !$box['autofilled']) { ?>

					<div id="cause<?= $key ?>" class="cause <?= $box['reader'] ? 'reader' : '' ?>" data-id="<?= $key ?>">
						<p class="txt-1rem fa-center"><?= $box['content'] ?></p>
					</div>

				<?php } ?>

			</div>

		<?php } ?>
	<?php } ?>

</div>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

{% end content %}