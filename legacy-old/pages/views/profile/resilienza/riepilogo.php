{% block content %}

<div class="title__wrapper main-wrap">
	<?= title() ?>
	<?= submit() ?>
	<?= no_results() ?>
</div>

<?php if ($sibling->completed) { ?>

	<div id="panorama" class="js-load">

		<?php for ($i = 1; $i < 6; $i++) { ?>

			<img id="image<?= $i ?>" class="image" src="<?= client_path(watchedStudent()->isInMiddleSchool ? 'middleschool-img' . $i : 'middleschool-img' . $i) ?>">

		<?php } ?>


		<h1 id="title<?= $score ?>" class="title txt">
			<span class="block js-load load--fade-in" data-direction="left"><span class="score"><?= $score ?></span> <?= $titles[$score] ?></span>
		</h1>

		<div id="figure" class="pos<?= $score ?>">
			<div id="figure-img" class="bgr bgr-fit cont" <?= background_image(watchedStudent()->isInMiddleSchool ? 'middleschool-figure' : 'middleschool-figure') ?>></div>
		</div>

	</div>

<?php } ?>

{% end content %}