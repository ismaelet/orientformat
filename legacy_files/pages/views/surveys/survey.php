<form class="page-content main-wrap" method="POST">

	<?php if ($completed) { ?>

		<div class="completed pad-v-2">

			<div class="icon-box inlb mar-b-3">
				<div class="icon inlb bgr-2" <?= icon_svg('correct') ?>></div>
			</div>

			<h1 class="fa-center txt-black txt-2rem txt-upp">Grazie per aver completato il formulario</h1>

			<p class="txt-7 fa-center txt-1rem mar-t-3">Le tue risposte sono state salvate. Puoi cliccare qui sotto per continuare con le attività proposte</p>

			<div class="fa-center mar-t-3">
				<a href="<?= client_url('/') ?>" class="button button--secondary">Continua le attività</a>
			</div>

		</div>

	<?php } else { ?>

		<div class="header pad-t-7">

			<h1 class="txt-3rem fa-center txt-sbold"><?= $config['title'] ?></h1>

			<?php if (!empty($config['stitle'])) { ?>
				<p class="txt-12rem fa-center mar-t-2"><?= $config['stitle'] ?></p>
			<?php } ?>

		</div>

		<!-- Questions -->
		<div class="questions pad-b-5">

			<?php foreach ($areas as $areaID => $area) { ?>

				<section class="section mar-b-4 mar-t-5">

					<p class="stitle txt-c3 txt-15rem txt-sbold"><?= $area['title'] ?></p>

					<?php foreach ($area['questions'] as $question) { ?>

						<!-- Question -->
						<div id="question-<?= 's' . $areaID . 'd' . $question['id'] ?>" class="question <?= isset($question['type']) ? 'mar-b-3' : '' ?>" data-optional="<?= isset($question['optional']) && $question['optional'] ? 1 : 0 ?>" data-completed="0">

							<?php if (isset($question['text'])) { ?>
								<p class="text mar-t-2">
									<span class="icon" <?= icon_svg('correct') ?>></span>
									<span class="number"><?= $question['id-show'] ?? $question['id'] ?>.</span> <?= $question['text'] ?>
								</p>
							<?php } ?>

							<p class="inp err">Devi rispondere a tutte le domande prima di poter continuare.</p>

							<?php if (isset($question['type'])) { ?>

								<?php if ($question['type'] == 'grid') { ?>

									<!-- Grid -->
									<div class="grid">

										<!-- Head -->
										<div class="grid-row head">
											<?php foreach ($question['grid-header'] as $content) { ?>
												<p class="grid-text"><?= $content ?></p>
											<?php } ?>
										</div>

										<!-- Rows -->
										<?php foreach ($question['grid-rows'] as $rowID => $row) { ?>

											<!-- Row -->
											<div class="grid-row">

												<!-- Cells -->
												<?php

												$colID = 0;

												foreach ($row as $cell) { ?>

													<?php if ($cell[0] == 'text') { ?>

														<p class="grid-text"><?= $cell[1] ?></p>

													<?php } else if ($cell[0] == 'cbx') {
														$colID++; ?>

														<div class="grid-cell">

															<label class="cbx">

																<input type="checkbox" class="cbx-mirror field" name="<?= $name = isset($cell[1]) ? 's' . $areaID . 'd' . $question['id'] . '_' . $cell[1] : 's' . $areaID . 'd' . $question['id'] ?>" value="<?= $value = isset($question['grid-direction']) && $question['grid-direction'] == 'row' ? $colID : $rowID + 1 ?>" data-group="<?= isset($cell[1]) ? 's' . $areaID . 'd' . $question['id'] . '_' . $cell[1] : 's' . $areaID . 'd' . $question['id'] ?>">

																<div class="icon"></div>

																<?php if ($debugger) { ?>
																	<p><?= $name . ' => ' . $value ?></p>
																<?php } ?>

															</label>

														</div>

													<?php } ?>

												<?php } ?>

											</div>

										<?php } ?>

									</div>

								<?php } else if ($question['type'] == 'list') { ?>

									<div class="answers answers--list <?= isset($question['multiple']) ? 'multiple' : '' ?>">

										<?php foreach ($question['list-rows'] as $rowID => $row) { ?>

											<label class="cbx cbx-box">
												<input type="checkbox" name="<?= $name = isset($question['multiple']) ? 's' . $areaID . 'd' . $question['id'] . '_' . $rowID : 's' . $areaID . 'd' . $question['id'] ?>" value="<?= $value = isset($question['multiple']) ? 1 : $rowID + 1 ?>" class="cbx-mirror field" data-group="<?= isset($question['multiple']) ? 's' . $areaID . 'd' . $question['id'] . '_' . $rowID : 's' . $areaID . 'd' . $question['id'] ?>">

												<div class="icon"></div>

												<p class="cbx-txt txt-09rem">
													<?= $row ?>
													<?= $debugger ? '<strong>(' . $name . ' => ' . $value . ')</strong>' : '' ?>
												</p>

											</label>

										<?php } ?>

									</div>

								<?php } else if ($question['type'] == 'inputs') { ?>

									<div class="answers--inputs inputs mar-t-1">

										<?php foreach ($question['inputs'] as $inputID => $input) { ?>

											<input type="text" name="<?= isset($input['name']) ? 's' . $areaID . 'd' . $question['id'] . '_' . $input['name'] : 's' . $areaID . 'd' . $question['id'] . '_' . ($inputID + 1) ?>" placeholder="<?= $input['pholder'] ?>" class="inp field" data-group="<?= isset($input['name']) ? 's' . $areaID . 'd' . $question['id'] . '_' . $input['name'] : 's' . $areaID . 'd' . $question['id'] . '_' . ($inputID + 1) ?>" <?= isset($input['max']) ? 'maxlength="' . $input['max'] . '"' : '' ?>>

										<?php } ?>

									</div>

								<?php } ?>

							<?php } ?>

						</div>

					<?php } ?>

				</section>

			<?php } ?>

			<div class="fa-center mar-t-3">
				<button type="submit" name="submit" id="submit" class="hidden"></button>
				<button type="button" id="submit-mirror" class="button wid-100">Invia</button>
			</div>

		</div>

	<?php } ?>

</form>