{% block content %}

<div class="main-wrap">

	<div id="body" class="">

		<div id="content" class="pt-40 pad-b-4">

			<!-- Title and instructions -->
			<?= title() ?>

			<!-- Submit -->
			<?= submit() ?>

			<!-- Quiz -->
			<section class="tbl mar-t-5">

				<div class="quiz-nav cell">
					<div class="quiz-arr top disabled" <?= icon_css('navigation/nav1_top_blk'); ?>></div>
					<div class="quiz-arr bot disabled" <?= icon_css('navigation/nav1_bot_blk'); ?>></div>
				</div>

				<div class="quiz-sec load slide-bottom cell">

					<div class="quiz-pan">

						<div class="quiz-cont no-trans" data-pos="<?= $pos; ?>" <?php if ($legacyTest->completed) echo 'data-locked="1"' ?> data-max="<?= $count; ?>">

							<?php
							foreach ($questions as $key => $question) {

								$fieldID = $count - $key;

								$val = $legacyTest->completed ? $legacyTest->rawResults[$key] : 0; ?>

								<div id="quiz<?= $fieldID; ?>" class="quiz no-trans" data-pos="<?= $fieldID; ?>">

									<input type="hidden" class="field filler-inp" name="field[]" value="<?= $val; ?>">

									<p class="quiz-title fc-primary"><?= $question[0]; ?></p>

									<p class="quiz-text"><?= $question[1]; ?></p>

									<div class="quiz-scor-box mar-t-1 <?php if ($legacyTest->completed) echo 'disabled' ?>">

										<?php for ($i = 1; $i < 6; $i++) { ?>

											<label class="quiz-scor inlb marr2 marr1-480w">

												<input type="checkbox" class="quiz-cbx hidden" value="<?= $i; ?>" <?= $legacyTest->completed ? 'disabled' : ''; ?> <?= $val == $i ? 'checked' : ''; ?>>

												<p class="quiz-scor-txt fa-center font-bold"><?= $i ?></p>

											</label>

										<?php } ?>

									</div>
								</div>
							<?php }
							?>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>

{% end content %}