{% block content %}

<div class="dashboard-panel">
	<div class="title-block fa-center mar-b-4">
		<h1 class="section-title txt-3rem txt-sbold"><?= $student->fullName ?></h1>
		<h3 class="section-subtitle txt-12rem txt-sbold">Risultati del questionario <?= $pageType == 'start' ? 'iniziale' : 'finale' ?></h3>
		<a href="<?= client_url('/class/students/progress/focus?id=' . \Illuminate\Support\Facades\Auth::id()) ?>" class="button button--secondary block push-center mar-t-2">Indietro</a>
	</div>

	<?php if ($profile->id) {
		foreach ($review->areas as $area) {
			if ($area->id != 1) { ?>

				<div class="area mar-t-3">
					<h2 class="area_title"><?= $area->title ?></h2>
					<div class="results mar-t-2">

						<?php foreach ($area->questions as $question) { ?>

							<?php if (isset($results[$question->fullSlug])) { ?>
								<div class="question">
									<h3 class="question_title"><strong><?= $question->slug ?>.</strong> <?= $question->text ?></h3>
									<p class="answer">

										<?php if (is_array($results[$question->fullSlug])) { ?>
											<!-- Question with multiple answers -->
											<span class="txt-sbold">Risposte:</span><br>

											<?php foreach ($results[$question->fullSlug] as $resultTitle => $result) {
												if ($question->type == 'grid') { ?>

													<!-- Grid answers -->
													<span class=""><?= $resultTitle ?></span>: <span class="fw-bold"><?= $result ?></span><br>

												<?php } else { ?>

													<!-- List answers -->
													<span class=""><?= $result ?><br>

												<?php }
											}
										} else { ?>

												<!-- Answer -->
												<span class="txt-sbold">Risposta:</span>
												<?= $results[$question->fullSlug] ?>

											<?php } ?>
									</p>

									<?php if (isset($averages[$question->fullSlug])) { ?>

										<!-- Average -->
										<p class="average">
											<span class="txt-sbold">Media dei partecipanti:</span><br>

											<?php if (is_array($averages[$question->fullSlug])) {
												foreach ($averages[$question->fullSlug] as $resultTitle => $result) {
													print_r($averages[$question->fullSlug], true); ?>

													<span class=""><?= $resultTitle ?></span>: <span class="fw-bold"><?= $result ?></span><br>

												<?php }
											} else { ?>
												<?= $averages[$question->fullSlug] ?>
											<?php } ?>
										</p>

									<?php } ?>
								</div>
							<?php } ?>
						<?php } ?>
					</div>
				</div>
		<?php }
		}
	} else { ?>

		<p class="txt-1rem fa-center fw-bold pad-b-5">È possibile visualizzare i risultati di questio questionario solo per gli studenti che l'hanno completato dopo il 29/09/2022</p>

	<?php } ?>

</div>

{% end content %}