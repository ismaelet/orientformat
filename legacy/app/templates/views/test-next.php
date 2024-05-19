{% extends test %}

{% block content %}

<div class="test__wrapper main-wrap grid-flow" data-spacing="800">
	<div class="title__wrapper">
		<?= title() ?>
	</div>

	<div class="test__content">
		<?= $legacyTestController->render(); ?>
	</div>

	<div class="grid-flow" data-spacing="700">
		<div class="">
			<?= submit($buttonIsProgressive) ?>

			<?php if ($skipEnabled) { ?>
				<?= skip() ?>
			<?php } ?>
		</div>

		<?php if ($retryEnabled) { ?>
			<?= renderRedoButton() ?>
		<?php } ?>
	</div>
</div>

{% end content %}