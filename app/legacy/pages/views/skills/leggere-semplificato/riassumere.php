{% block content %}

<div class="pad-t-5 pad-b-5 main-wrap">

	<?= title() ?>

	<?php if ($legacyTest->completed || !isSupervisor()) { ?>

		<div id="text-box" class="section">

			<h1 class="fa-center txt-3rem mar-b-2 mar-t-5 font-bold txt-upp"><?= __('Summary') ?></h1>

			<p id="text" class="mar-b-2 txt-1rem"><?= $text ?></p>

			<p class="clickable mar-b-2 txt-c3 fc-primary-h inlb" onclick="$('.section').toggleClass('hidden');">
				<span class="text-icon bgr-c3" <?= icon_svg('read') ?>></span>
				<span class="btn-txt"><?= __('Click here to read the text again') ?></span>
			</p>
		</div>

		<div id="original-box" class="section hidden">

			<h1 class="fa-center txt-3rem mar-b-2 mar-t-5 font-bold txt-upp">Testo</h1>

			<p id="original" class="mar-b-2 txt-1rem">
				<?= __('tests.39-full-text') ?>
			</p>

			<p class="clickable mar-b-2 txt-c3 fc-primary-h inlb" onclick="$('.section').toggleClass('hidden');">
				<span class="text-icon bgr-c3" <?= icon_svg('navigation/back') ?>></span>
				<span class="btn-txt"><?= __('tests.39-back') ?></span>
			</p>
		</div>

	<?php } ?>

	<?= no_results() ?>
	<?= submit(true) ?>
	<?= skip() ?>

</div>

{% end content %}