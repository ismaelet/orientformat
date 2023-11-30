{% block content %}

<div class="main-wrap pad-t-4 pad-b-5" autocomplete="off">

	<input type="hidden" id="record-time" name="field[]">

	<?= title() ?>

	<div id="content" class="mar-t-4 <?= $test->completed ? 'completed' : '' ?>">

		<div class="fa-center">
			<div id="start" class="button">Comincia</div>
		</div>

		<div id="concepts" class="fa-center">

			<?php foreach (_CONCEPTS as $key => $concept) { ?>

				<h2 class="concept txt-c3 mar-v-1 fw-bold inlb loadA pos-rel" style="--del: <?= $key / 10 ?>s">
					<span class="concept-line"></span>
					<span class="block"><?= ucfirst($concept) ?></span>
				</h2><br>

			<?php } ?>

			<div class="fa-center mar-t-3">
				<div id="stop" class="button bgr-c5">Stop</div>
			</div>

		</div>

		<div id="answers">

			<?php for ($i = 0; $i < $count; $i++) { ?>

				<div class="answer">
					<input type="text" name="field_other[]" placeholder="" class="inp filler-inp <?php if ($test->completed) echo in_array(strtolower($results[$i]), _CONCEPTS) ? 'right' : 'wrong' ?>" maxlength="40" required value="<?= $results[$i] ?? null ?>" <?= $test->completed ? 'readonly' : null ?>>
					<h3 class="number fw-bold txt-c3"><?= $i + 1 ?>.</h3>
				</div>

			<?php } ?>

		</div>

		<?php if ($test->completed) { ?>

			<p id="result" class="txt-c3 txt-12rem mar-t-2">
				Ti sei ricordato <?= $test->percentage ? 'il ' : 'lo ' ?><strong><?= $test->percentage ?>%</strong> dei concetti e ci hai messo <strong><?= $time_str ?></strong> per memorizzarli.
			</p>

		<?php } ?>

		<div class="page-footer mar-t-2 grid-flow" data-spacing="700">
			<div>
				<?= submit(true) ?>
				<?= skip() ?>
			</div>

			<?= renderRedoButton(true) ?>
		</div>
	</div>
</div>

{% end content %}