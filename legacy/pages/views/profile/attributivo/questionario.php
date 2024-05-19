{% block content %}

<div class="">
	<div class="title__wrapper main-wrap mar-b-5">
		<?= title() ?>
	</div>

	<div id="questions" class="<?= $legacyTest->completed ? 'completed' : '' ?>">

		<?php foreach ($questions as $key => $question) {

			$answer = $answers[$key]; ?>

			<div id="question<?= $key ?>" class="question-box pad-v-3 gradient-overlay bgr-<?= $colors[($key % 4)] ?>" data-id="<?= $key ?>">

				<div class="main-wrap">

					<p class="question txt-15rem mar-b-2 txt-sbold"><span class="number fw-bold"><?= $key ?>.</span> <?= $question ?>:</p>

					<?php foreach ($answer as $i => $res) { ?>

						<label class="answer checkbox mar-b-1">
							<input type="checkbox" name="field[]" class="cbx-mirror filler-inp" <?= !empty($legacyTest->rawResults[$key - 1]) && $legacyTest->rawResults[$key - 1] == ($i + 1) ? 'checked' : '' ?> value="<?= $i + 1 ?>">
							<span></span>
							<p><?= $res ?></p>
						</label>

					<?php } ?>

				</div>
			</div>

		<?php } ?>

	</div>

	<div class="">
		<div class="main-wrap mar-t-5">

			<?= submit(true) ?>

		</div>
	</div>
</div>

{% end content %}