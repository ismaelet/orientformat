{% block content %}

<div class="main-wrap pad-b-1">
	<div class="title__wrapper">
		<?= title() ?>
		<?= no_results() ?>
		<?= submit() ?>
	</div>

	<?php if ($sibling->completed) { ?>

		<!-- Graphic -->
		<section id="content" class="mar-t-7">
			<div id="graph" class="grid push-center mar-t-5 mar-b-5">

				<div id="quare1" class="square gradient-overlay" data-ver="top" data-hor="left"></div>
				<div id="quare2" class="square gradient-overlay" data-ver="top" data-hor="right"></div>
				<div id="quare3" class="square gradient-overlay" data-ver="bottom" data-hor="left"></div>
				<div id="quare4" class="square gradient-overlay" data-ver="bottom" data-hor="right"></div>

				<?php foreach ($results as $key => $result) { ?>

					<div id="type<?= $key + 1 ?>" class="
							type
							<?= $key + 1 > 10 ? 'right' : 'left' ?>
							<?= $key + 1 < 8 || ($key + 1 < 13 && $key + 1 > 10) ? 'top' : 'bottom' ?>
							<?= $key + 1 == 7 ? 'bottom' : '' ?>
						">

						<p class="result result<?= $result['score'] ?>"><?= $result['score'] ?></p>
						<p class="name"><?= $result['title'] ?></p>

					</div>

				<?php } ?>

				<?php foreach ($categories as $key => $category) { ?>

					<p id="category<?= $key + 1 ?>" class="category txt-2rem font-bold <?= $category[1] ?> <?= $key + 1 > 2 ? 'txt-vertical' : '' ?>"><?= $category[0] ?></p>

				<?php } ?>

				<h1 id="center" class="cen txt-2rem bgr-c3 txt-wht"><?= __('tests.63-title') ?></h1>

			</div>
		</section>

	<?php } ?>

</div>

{% end content %}