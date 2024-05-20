{% block content %}

<div class="main-wrap pad-t-5 pad-b-5">

	<?= title() ?>

	<div id="scores" class="mar-t-10">

		<?php foreach ($questions as $key => $question) { ?>

			<div id="score<?= $key ?>" class="score <?= $key == 1 ? 'active' : '' ?>">
				<div class="score-grid grid">
					<p id="desc1" class="desc font-bold txt-12rem txt-c3 txt-rig padr2"><?= $question[0] ?></p>
					<input type="hidden" class="field" name="field[]">
					<div id="dots">

						<?php for ($i = 1; $i < 7; $i++) {

							if ($i == 1 || $i == 6) $text = '&middot;&middot;&middot;';
							else if ($i == 2 || $i == 5) $text = '&middot;&middot;';
							else if ($i == 3 || $i == 4) $text = '&middot;';
						?>

							<div id="dot<?= $i ?>" class="dot inlb va-cen clickable" data-score="<?= $i ?>">
								<p class="cen"><?= $text ?></p>
							</div>

						<?php } ?>

					</div>
					<p id="desc2" class="desc font-bold txt-12rem txt-c3 padl2"><?= $question[1] ?></p>

				</div>
				<div class="fa-center">
					<div class="confirm button mar-t-4">Conferma</div>
				</div>
			</div>

		<?php } ?>

		<button type="submit" name="submit" id="submit" class="hidden"></button>
	</div>
</div>

{% end content %}