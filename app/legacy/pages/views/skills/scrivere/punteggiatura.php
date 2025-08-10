{% block content %}

<div class="main-wrap grid" data-spacing="800">
	<div class="title__wrapper">
		<?= title() ?>
	</div>

	<div class="sentences grid" data-spacing="700">

		<?php foreach ($sentencesHtml as $key => $sentence) { ?>

			<p class="sentence"><span class="font-bold"><?= $key + 1 ?>.</span> <?= $sentence ?></p>

		<?php } ?>

	</div>

	<div class="grid" data-spacing="700">
		<div>
			<?= submit(true) ?>
		</div>
		<?= renderRedoButton(true) ?>
	</div>
</div>

{% end content %}