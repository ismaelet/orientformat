{% block content %}

<div class="bgr bg-secondary"></div>

<div class="main-wrap pad-t-5 pad-b-5">

	<?= title() ?>

	<div id="circles" class="wrap mar-t-5 mb-40">

		<p id="title-center" class="cen fa-center txt-c3 font-bold">Stili cognitivi</p>

		<?php for ($i = 1; $i < 5; $i++) { ?>

			<div id="border<?= $i ?>" class="border"></div>

		<?php } ?>

		<?php foreach ($circles as $key => $circle) { ?>

			<div class="circle row<?= $circle['val'] ?> group<?= $circle['group'] ?> <?= $circle['checked'] ? 'checked' : '' ?>" style="--w:<?= $circle['w'] ?>; --h:<?= $circle['h'] ?>" data-group="<?= $circle['group'] ?>">

				<div class="bgr load"></div>
			</div>

		<?php } ?>

		<?php foreach ($groups as $key => $group) { ?>

			<div id="title-box<?= $key ?>" class="title-box txt-wht" data-group="<?= $key ?>">
				<p class="title txt-15rem load"><?= $group ?></p>
			</div>

		<?php } ?>

	</div>

	<?= submit() ?>

</div>

{% end content %}