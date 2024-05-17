	{% block content %}

	<div class="main-wrap pad-t-4 pad-b-5" autocomplete="off">

		<input type="text" name="field[]" value="<?= $level ?>" class="hidden">

		<?= title() ?>

		<div id="content" style="--size: <?= $level + 2 ?>">

			<?php if ($levelOld && $level <= $count) { ?>

				<div id="numbers-old">

					<?php if (!test()->completed || $right) { ?>

						<div class="numbers fa-center mar-t-10 push-center" style="--size: <?= $levelOld + 2 ?>">

							<?php for ($i = 0; $i < $levelOld + 2; $i++) { ?>

								<div class="number-box">
									<input type="number" class="number <?= $test->rawResults[$i + 1] == $answers[$levelOld][$i] ? 'right' : 'wrong' ?>" disabled min="1" max="9" value="<?= $test->rawResults[$i + 1] ?>" autocomplete="off">
								</div>

							<?php } ?>

						</div>

					<?php } ?>

					<?php if ($right) { ?>

						<div class="submit-box fa-center mar-t-5">
							<div id="start" class="button resume mar-b-2">Procedi</div>
						</div>

					<?php } else { ?>

						<div class="submit-box fa-center mar-t-5">

							<?php if (!isSupervisor()) { ?>
								<div id="reset" class="button resume mar-b-2">Riprova</div><br>

								<?php if (!$test->completed) { ?>

									<label>
										<p class="interactive">Non riesco a memorizzare tutte le cifre e preferisco fermarmi qui.</p>
										<input type="checkbox" name="skip-cbx" class="hidden" onchange="$(this).next().click();">
										<button type="submit" name="submit" class="hidden" formnovalidate></button>
									</label>

								<?php } ?>
							<?php } ?>

						</div>

					<?php } ?>
				</div>

			<?php } else if ($levelOld) { ?>

				<h1 id="completed" class="pad-v-5 fa-center txt-3rem fw-light"><span class="fc-primary fw-bold">Ottimo lavoro!</span> Hai completato l'attività</h1>

				<div class="submit-box fa-center">
					<button name="submit" class="button mar-b-2">Procedi</button>
				</div>

			<?php } ?>

			<?php if ($level <= $count) { ?>

				<div id="numbers-new" class="<?= $levelOld ? '' : 'active' ?>">

					<div class="grid2 ha-cen mar-t-4">
						<div id="view" class="button button--secondary">
							<?= embed_icon('view') ?>
							Vedi
						</div>

						<div id="listen" class="button button--secondary">
							<?= embed_icon('listen') ?>
							Ascolta
						</div>
					</div>

					<div class="numbers fa-center mar-t-4 push-center">

						<?php for ($i = 0; $i < $level + 2; $i++) { ?>

							<div class="number-box">
								<input type="number" class="number js-number" name="field[]" min="0" max="9" onKeyPress="if(this.value.length==2) return false;" required>
							</div>

						<?php } ?>

					</div>

					<div class="submit-box fa-center mar-t-5">
						<button type="submit" id="check" name="check" class="button mar-b-2">Conferma</button><br>

						<?php if (!$test->completed) { ?>

							<label>
								<p class="txt-a clickable inlb">Non riesco a memorizzare tutte le cifre e preferisco fermarmi qui.</p>
								<input type="checkbox" name="skip-cbx" class="hidden" onchange="$(this).next().click();">
								<button type="submit" name="submit" class="hidden" formnovalidate></button>
							</label>

						<?php } ?>

					</div>
				</div>

			<?php } ?>

			<!-- View section -->
			<div id="view-pan" class="pad-v-5">
				<div class="grid">
					<h1 id="view-txt" class="txt-c3 fw-bold fa-center"><?= $view_text ?></h1>
				</div>

				<div class="submit-box fa-center mar-t-5">
					<div class="back button mar-b-2">Inserisci i numeri</div>
				</div>
			</div>

			<!-- Listen section -->
			<div id="listen-pan" class="pad-v-5 fa-center">
				<audio id="audio">
					<source src="<?= client_path('/pages/assets/' . test()->area->slug . '/' . test()->section->mainSection->slug . '/' . test()->slug . '/' . 'audio' . $level . '.mp3') ?>" type="audio/mpeg">
					Il tuo browser non supporta gli audio MP3.
				</audio>

				<div id="play-box" class="inlb round pos-rel js-listen-button">
					<div id="pulse" class="bgr bgr-c3 round js-pulse"></div>
					<div id="play" class="bgr bgr-c3 clickable">

						<div class="icon cen bgr-wht" <?= icon_svg('play') ?>></div>
						<div class="icon cen bgr-wht" <?= icon_svg('listen') ?>></div>

					</div>
				</div>

				<div class="submit-box fa-center mar-t-5">
					<div class="back button mar-b-2">Inserisci i numeri</div>
				</div>
			</div>
		</div>
	</div>

	{% end content %}