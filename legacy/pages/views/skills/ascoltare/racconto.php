{% block content %}

<div class="main-wrap pad-t-4 pad-b-5">

	<?= title() ?>

	<?php if ($legacyTest->completed || !isSupervisor()) { ?>

		<div class="fa-center mar-t-4">

			<p class="fw-bold txt-12rem mar-b-1 fc-primary clickable" onclick="$(this).next()[0].play();">Ascolta il racconto:</p>

			<audio id="audio" controls>
				<source src="<?= client_path('audio.mp3') ?>" type="audio/mpeg">
				Il tuo browser non supporta gli audio MP3.
			</audio>
		</div>

		<h1 class="mar-t-5 txt-2rem mar-b-2">Domande:</h1>

		<div id="questions" class="mar-b-4 <?= $legacyTest->completed ? 'completed' : '' ?>">

			<?php foreach ($content as $questionKey => $question) { ?>

				<div class="question mar-b-2">

					<p class="txt-11rem mar-b-1 fw-bold"><span class="fw-bold txt-c2"><?= $questionKey + 1 ?>.</span> <?= $question['text'] ?>:</p>

					<?php foreach ($question['answers'] as $answerKey => $answer) { ?>

						<div class="block mar-b-1">

							<label class="checkbox <?= $answer['class'] ?>">
								<input type="checkbox" name="field[]" class="cbx-mirror filler-inp" <?= $answer['checked'] ? 'checked' : '' ?> value="<?= $answerKey + 1 ?>" <?= $legacyTest->completed ? 'readonly' : '' ?>>
								<span></span>
								<p><?= $answer['text'] ?></p>
							</label>

						</div>

					<?php } ?>

				</div>

			<?php } ?>

		</div>

	<?php } else if (isSupervisor()) { ?>

		<?= no_results() ?>

	<?php } ?>

	<?= submit(2) ?>
	<?= skip() ?>

</div>

{% end content %}