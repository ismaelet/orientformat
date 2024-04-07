{% block main %}

<form class="page-content main-wrap" method="POST">

	<?php if ($review->completed) { ?>

		<div class="completed pad-v-2 grid-flow center-content" data-spacing="700">
			<div class="success-icon">
				<?= icon_embed('correct') ?>
			</div>

			<h1 class="section-title">Grazie per aver<br>completato il formulario</h1>

			<p class="section-subtitle">Le tue risposte sono state salvate. Puoi cliccare qui sotto per continuare con le attività proposte</p>

			<a href="<?= client_url('/') ?>" class="button button--secondary">Continua le attività</a>
		</div>

	<?php } else { ?>

		<div class="header pad-t-7">
			<h1 class="txt-3rem fa-center txt-sbold"><?= $review->title ?></h1>
			<p class="txt-12rem fa-center mar-t-2"><?= $review->description ?></p>
		</div>

		<!-- Questions -->
		<div class="questions pad-b-5">

			<?php

			$i = 0;

			foreach ($review->areas as $area) { ?>

				<section class="section mar-b-4 mar-t-5">
					<p class="stitle txt-c3 txt-15rem txt-sbold"><?= $area->title ?></p>

					<?php if ($area->text) { ?>
						<p><?= $area->text ?></p>
					<?php } ?>

					<?php foreach ($area->getQuestions($review->id) as $key => $question) {
						$i++;
					?>

						<!-- Question -->
						<div id="question-<?= $question->fullSlug ?>" class="question <?= $question->type ? 'mar-b-3' : '' ?> js-question" data-optional="<?= $question->optional ?>" data-completed="0" data-multiple="<?= $question->multiple ?>">

							<p class="text mar-t-2">
								<?= $debugger ? '(' . $question->fullSlug . ')' : '' ?>
								<?php if ($question->text) { ?>

									<span class="icon" <?= icon_svg('correct') ?>></span>
									<span class="number"><?= $i ?>.</span> <?= $question->text ?>

								<?php } ?>
							</p>

							<p class="error-warning js-error-warning">Devi rispondere a tutte le domande prima di poter continuare.</p>

							<?php switch ($question->type) {
								case 'grid': { ?>

										<!-- Grid -->
										<div class="review-grid js-grid">

											<!-- Head -->
											<div class="grid-row grid-row--head <?= $question->hasLegend ? 'grid-row--legend' : '' ?>">

												<?php if ($question->hasLegend) { ?>

													<span></span>

												<?php } ?>

												<?php foreach ($question->gridHeader as $content) { ?>

													<p class="grid-text"><?= $content ?></p>

												<?php } ?>

											</div>

											<!-- Rows -->
											<?php foreach ($question->rows as $row) { ?>

												<!-- Row -->
												<div class="grid-row js-grid-row <?= $question->hasLegend ? 'grid-row--legend' : '' ?>">

													<?php if (isset($row['title'])) { ?>

														<p class="grid-cell grid-cell--title"><?= $row['title'] ?></p>

													<?php } ?>

													<!-- Cells -->
													<?php foreach ($row['content'] as $cell) { ?>

														<div class="grid-cell">

															<label class="checkbox">
																<input type="checkbox" class="field js-cbx" name="<?= $cell['name'] ?>" value="<?= $cell['value'] ?>" data-type="row">

																<span></span>
															</label>

															<?php if ($debugger) { ?>
																<p><?= $cell['name'] . ' = ' . $cell['value'] ?></p>
															<?php } ?>

														</div>


													<?php } ?>

												</div>

											<?php } ?>

										</div>

									<?php }
									break;

								case 'list': { ?>

										<div class="answers answers--list mar-t-05">

											<?php foreach ($question->rows as $row) { ?>

												<label class="checkbox">
													<input type="checkbox" name="<?= $row['name'] ?>" value="<?= $row['value'] ?>" class="field js-cbx">

													<span></span>

													<p class="">
														<?= $row['title'] ?>
														<?= $debugger ? '<strong>(' . $row['name'] . ' = ' . $row['value'] . ')</strong>' : '' ?>
													</p>
												</label>

											<?php } ?>

										</div>

									<?php }
									break;

								case 'number': { ?>
										<input type="number" class="field js-input mar-t-1" name="<?= $question->fullSlug ?>" min="1" max="100" placeholder="Numero" required>

							<?php }
							} ?>

						</div>

					<?php } ?>

				</section>

			<?php } ?>

			<div class="fa-center mar-t-3">
				<button type="submit" id="submit" class="hidden js-submit"></button>
				<button type="button" class="button wid-100 js-attempt-submit">Invia</button>
			</div>

		</div>

	<?php } ?>

</form>

{% end main %}