{% extends main %}

{% block main %}

<div class="background center-content grid">
	<h3 class="sec-title text-center txt-upp load--fade-in js-load" data-direction="right"><?= $legacySection->name ?></h3>
</div>

<form class="pos-rel" id="body" method="POST">
	<?= csrf_field() ?>

	<div class="page-wrapper main-wrap">

		<input type="hidden" id="time-passed" name="speed" value="0">

		<!-- Questions -->
		<div class="questions-carousel" data-pos="1">
			<div class="questions-wrapper">

				<?php foreach ($survey->questions as $key => $question) { ?>

					<div class="question <?= $key ? '' : 'active' ?>">

						<!-- Title -->
						<h2 class="section-subtitle load--fade-in js-load" data-direction="bottom" data-delay="2">
							<?= $legacyTest->title ?> <span><?= sprintf('%02d', ($key + 1)) . '/' . sprintf('%02d', $survey->questionCount) ?></span>
						</h2>

						<h3 class="question-text section-title colored-title load--fade-in js-load" data-direction="top"><?= $question[0] ?>:</h3>

						<!-- Questions -->
						<div class="answers" data-direction="bottom">

							<?php foreach ($survey->answers as $j => $answer) { ?>

								<div class="answer load--fade-in js-load" data-direction="top" data-delay="<?= $j ?>">
									<label class="answer-icon">
										<input type="checkbox" class="answer-cbx hidden" name="field[]" value="<?= $question[1] ? $j : $survey->answerCount - 1 - $j ?>">
										<div class="answer-dot"></div>
									</label>

									<p class="answer-text"><?= $answer ?></p>
								</div>

							<?php } ?>

						</div>
					</div>

				<?php } ?>

			</div>
		</div>
	</div>

	<!-- Navigation arrows -->
	<div id="slide-arrow-box" class="">
		<div class="slide-arrow disabled" data-direction="left">
			<div class="slide-arrow-icon icon-box">
				<?= embed_icon('navigation/arrow2-left') ?>
			</div>

			<p class="slide-arrow-text"><?= __('Previous') ?></p>
		</div>

		<div class="slide-arrow disabled" data-direction="right">
			<p class="slide-arrow-text"><?= __('Next') ?></p>

			<div class="slide-arrow-icon icon-box">
				<?= embed_icon('navigation/arrow2-right') ?>
			</div>
		</div>
	</div>
</form>

{% end main %}