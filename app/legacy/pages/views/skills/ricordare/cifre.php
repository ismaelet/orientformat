	{% block content %}

	<div class="main-wrap pad-t-4 pad-b-5" autocomplete="off">

		<input type="text" name="field[]" value="<?= $level ?>" class="hidden">

		<?= title() ?>

		<div id="content" style="--size: <?= $level + 2 ?>">

			<?php if ($levelOld && $level <= $count) { ?>

				<div id="numbers-old">

					<?php if (!legacy_test()->completed || $right) { ?>

						<div class="numbers fa-center mar-t-10 push-center" style="--size: <?= $levelOld + 2 ?>">

							<?php for ($i = 0; $i < $levelOld + 2; $i++) { ?>

								<div class="number-box">
									<input type="number" class="number <?= $legacyTest->rawResults[$i + 1] == $answers[$levelOld][$i] ? 'right' : 'wrong' ?>" disabled min="1" max="9" value="<?= $legacyTest->rawResults[$i + 1] ?>" autocomplete="off">
								</div>

							<?php } ?>

						</div>

					<?php } ?>

					<?php if ($right) { ?>

						<div class="submit-box fa-center mar-t-5">
							<div id="start" class="button resume mar-b-2"><?= __('Continue') ?></div>
						</div>

					<?php } else { ?>

						<div class="submit-box fa-center mar-t-5">

							<?php if (!isSupervisor()) { ?>
								<div id="reset" class="button resume mar-b-2"><?= __('Try again') ?></div><br>

								<?php if (!$legacyTest->completed) { ?>

									<label>
										<p class="interactive"><?= __('tests.163-stop') ?></p>
										<input type="checkbox" name="skip-cbx" class="hidden" onchange="$(this).next().click();">
										<button type="submit" name="submit" class="hidden" formnovalidate></button>
									</label>

								<?php } ?>
							<?php } ?>

						</div>

					<?php } ?>
				</div>

			<?php } else if ($levelOld) { ?>

				<h1 id="completed" class="pad-v-5 fa-center txt-3rem fw-light"><?= __('tests.163-right') ?></h1>

				<div class="submit-box fa-center">
					<button name="submit" class="button mar-b-2"><?= __('Continue') ?></button>
				</div>

			<?php } ?>

			<?php if ($level <= $count) { ?>

				<div id="numbers-new" class="<?= $levelOld ? '' : 'active' ?>">

					<div class="grid2 ha-cen mar-t-4">
						<div id="view" class="button button--secondary">
							<?= embed_icon('view') ?>
							<?= __('See') ?>
						</div>

						<div id="listen" class="button button--secondary">
							<?= embed_icon('listen') ?>
							<?= __('Listen') ?>
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
						<button type="submit" id="check" name="check" class="button mar-b-2"><?= __('Confirm') ?></button><br>

						<?php if (!$legacyTest->completed) { ?>

							<label>
								<p class="txt-a clickable inlb"><?= __('tests.163-stop') ?></p>
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
					<h1 id="view-txt" class="txt-c3 font-bold fa-center"><?= $view_text ?></h1>
				</div>

				<div class="submit-box fa-center mar-t-5">
					<div class="back button mar-b-2"><?= __('tests.163-insert') ?></div>
				</div>
			</div>

			<!-- Listen section -->
			<div id="listen-pan" class="pad-v-5 fa-center">
				<audio id="audio">
					<source src="<?= client_path('/pages/assets/' . legacy_test()->area->slug . '/' . legacy_test()->section->mainSection->slug . '/' . legacy_test()->slug . '/' . 'audio' . $level . '.mp3') ?>" type="audio/mpeg">
					<?= __('mp3-error') ?>
				</audio>

				<div id="play-box" class="inlb round pos-rel js-listen-button">
					<div id="pulse" class="bgr bgr-c3 round js-pulse"></div>
					<div id="play" class="bgr bgr-c3 clickable">

						<div class="icon cen text-neutral-100"><?= embed_icon('play') ?></div>
						<div class="icon cen text-neutral-100"><?= embed_icon('listen') ?></div>

					</div>
				</div>

				<div class="submit-box fa-center mar-t-5">
					<div class="back button mar-b-2"><?= __('tests.163-insert') ?></div>
				</div>
			</div>
		</div>
	</div>

	{% end content %}