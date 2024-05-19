{% block content %}

<div class="main-wrap pad-t-4 pad-b-5" method="POST">

	<?= title() ?>

	<div id="types" class="grid <?= $legacyTest->completed ? 'completed' : '' ?>">

		<?php foreach ($questions as $questionId => $question) { ?>

			<div class="question">
				<div class="name-box grid">
					<p class="name txt-1rem"><?= $questionId ?>. <?= $question ?></p>
				</div>

				<div class="score-box txt-rig js-question">

					<?php for ($i = 0; $i <= 3; $i++) { ?>

						<label class="score<?= $i ?> score clickable">
							<input type="checkbox" class="hidden js-field" name="field[]" value="<?= $i + 1 ?>" <?= isset($legacyTest->rawResults[$questionId - 1]) && $i + 1 == $legacyTest->rawResults[$questionId - 1] ? 'checked' : '' ?>>

							<div class="circle">
								<div class="dot cen"></div>
							</div>

							<p class="fa-center"><?= $i ?></p>
						</label>

					<?php } ?>

				</div>
			</div>

		<?php } ?>

	</div>

	<div class="mar-t-4">
		<?= submit(true) ?>
	</div>

</div>

{% end content %}