{% block content %}

<div class="main-wrap mar-t-5 pad-b-10">

	<div id="content" class="grid gap3 va-items-cen">

		<section id="page-graph-sec" class="gradient-overlay js-load load--fade-in" data-direction="bottom">

			<div id="page-graph-box">

				<canvas id="canv-perm" class="canv bgr"></canvas>
				<canvas id="canv-draw" class="canv bgr"></canvas>

				<div id="page-graph" class="grid5 <?= $legacyTest->completed ? 'disabled' : ''; ?>">

					<input type="hidden" name="field[]" id="field" class="tracking-inp field" value="<?= $val = $legacyTest->completed ? implode(',', $legacyTest->rawResults) : 0; ?>">

					<?php
					$row = sqrt($count) + 2;
					$max = pow($row, 2);

					for ($i = 1; $i <= $max; $i++) {
						$tar = (!($i % $row) || $i % $row == 1 || $i < $row || $i > ($max - $row)) ? false : true;
					?>

						<div id="dot-space<?= $i; ?>" class="dot-space">

							<input type="hidden" class="tracking-inp <?php if ($tar) echo 'filler-inp'; ?>" value="0">

							<div class="dot <?php if ($tar) echo 'tar'; ?> js-load" data-active="0" data-id="<?= $i; ?>" data-x="<?= ($i - 1) % $row ?>" data-y="<?= floor(($max - $i) / $row); ?>"></div>

						</div>

					<?php } ?>

				</div>

				<div id="count-box" class="py-4 px-8 contrasting-background">
					<p class="txt-1rem">segmenti usati: <span class="font-bold contrasting-background marl1"><span id="segments">0</span>/4</span></p>
					<p class="txt-1rem">punti uniti: <span class="font-bold contrasting-background marl1 flt-r"><span id="score">0</span>/9</span></p>
				</div>
			</div>
		</section>

		<section class="title__wrapper title__wrapper--no-margin">
			<?= title() ?>

			<div>
				<?= submit(true) ?>
				<?= skip() ?>
			</div>
		</section>
	</div>
</div>
{% end content %}