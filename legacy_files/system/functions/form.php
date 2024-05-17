<?php

// Add to database
function form_db_add($tbl, $fields) {

	$inputs = [];
	$values = [];
	$names = $pholders = '';

	foreach ($fields as $field) {
		if (isset($field[0])) {
			foreach ($field as $input) $inputs[] = $input;
		} else $inputs[] = $field;
	}

	foreach ($inputs as $input) {

		$type = $input['type'] ?? 'text';

		if ($type != 'file') {

			if (isset($input['name'])) {

				$name = $input['name'];
				$value = isset($_POST[$name]) ? trim($_POST[$name]) : ($input['value'] ?? 0);

				// parse
				if (isset($input['parse'])) switch ($input['parse']) {

					case 'int':
						$value = (int) $value;
						break;
				}

				// store values
				$names .= $name . ', ';
				$pholders .= '?, ';
				$values[] = $value;
			}
		}
	}

	$names = rtrim($names, ', ');
	$pholders = rtrim($pholders, ', ');

	$query = $tbl . ' (' . $names . ') VALUES (' . $pholders . ')';

	return \System\Classes\DBOld::add($query, $values);
}

// Edit database
function form_db_update($tbl, $fields, $index, $indexVal) {

	$inputs = [];
	$values = [];
	$query = '';

	foreach ($fields as $field) {
		if (isset($field[0])) {
			foreach ($field as $input) $inputs[] = $input;
		} else $inputs[] = $field;
	}

	foreach ($inputs as $input) {

		if (isset($input['name'])) {

			$name = $input['name'];
			$value = isset($_POST[$name]) ? trim($_POST[$name]) : ($input['value'] ?? 0);

			// parse
			if (isset($input['parse'])) switch ($input['parse']) {

				case 'int':
					$value = (int) $value;
					break;
			}

			// store values
			$values[] = $value;
			$query .= $name . '=?, ';
		}
	}

	$query = rtrim($query, ', ');

	$query = $tbl . ' SET ' . $query . ' WHERE ' . $index . '=?';
	$values[] = $indexVal;

	\System\Classes\DBOld::update($query, $values);
}

// Generate form
function generate_form($fields, $data = false, $error = false, $done = false) {

	foreach ($fields as $field) {

		echo '<div class="form-field">';

		if (isset($field[0]))
			foreach ($field as $input) generate_input($input, $data, $error, $done);

		else
			generate_input($field, $data, $error, $done);

		echo '</div>';
	}
}

function generate_input($input, $data, $error, $done) {

	// basic data
	$type = $input['type'] ?? 'text';
	$name = $input['name'] ?? false;
	$styling = $input['styling'] ?? false;

	// calculate value
	$value = false;

	// if value is explicit
	if (isset($input['value'])) $value = $input['value'];

	// else get from POST, if set
	else if ($name && isset($_POST[$name])) $value = $_POST[$name];

	// else get from MySQL result, if set
	else if ($name && isset($data[$name]) && $type != 'cbx') $value = $data[$name];

	// else if it's a checkbox
	else if ($type == 'cbx') $value = 1;

	// styling
	if ($styling == 'fancy') { ?>

		<div class="fancy-input <?= isset($input['size']) ? 'fancy-input_size' . $input['size'] : '' ?>">

			<?php }

		// start to generate
		// label
		switch ($type) {

			case 'lbl': ?>

				<p class="form-lbl"><?= $input['text'] ?>:</p>

			<?php break;

			case 'info': ?>

				<p class="form-text"><?= $input['text'] ?></p>

				<?php break;

			case 'done':

				if ($type == 'done' && $done) { ?>

					<p class="confirmation-message"><?= $input['text'] ?></p>

				<?php }
				break;

			case 'error':

				if ($input['error'] == $error) { ?>

					<p class="error-warning"><?= $input['text'] ?></p>

				<?php }
				break;

			case 'search':

				input_search($input);

				break;

			case 'file': ?>

				<input type="file" class="inp file" name="<?= $name ?>" <?= isset($input['multiple']) ? 'multiple' : '' ?> <?= isset($input['required']) ? 'required' : '' ?>>

			<?php break;

			case 'select':

				if (isset($input['query'])) {
					$selectOptions = \System\Classes\DBOld::select($input['query'])->res;
					$fieldId = $input['field-name'];
					$fieldShow = $input['field-show'];
				} else if (isset($input['array'])) {
					$selectOptions = $input['array'];
					$fieldId = 0;
					$fieldShow = 1;
				}
			?>

				<select class="sel <?= isset($input['affect']) ? 'affect' : '' ?>" <?= isset($input['affect']) ? 'data-affect="' . $input['affect'] . '"' : '' ?> name="<?= $name ?>" <?= !empty($input['disabled']) ? 'disabled' : '' ?>>

					<?php if (isset($input['empty'])) { ?>

						<option value="0" selected>- <?= __('None') ?> -</option>

					<?php }
					foreach ($selectOptions as $option) { ?>

						<option value="<?= $option[$fieldId] ?>" <?php if ($option[$fieldId] == $value) echo 'selected' ?>>
							<?= $option[$fieldShow] ?>
						</option>

					<?php } ?>

				</select>

			<?php break;

			case 'select-dependent': ?>

				<select class="sel" data-tbl="<?= $input['query-tbl'] ?>" data-filter="<?= $input['query-filter'] ?>" data-id="<?= $input['field-name'] ?>" data-show="<?= $input['field-show'] ?>" data-root="<?= CLIENT_ROOT ?>" name="<?= $name ?>" disabled>
					<option>-</option>
				</select>

			<?php break;

			case 'textarea': ?>

				<textarea class="textarea" name="<?= $name ?>" placeholder="<?= $input['text'] ?? '' ?>" <?= isset($input['maxlength']) ? 'maxlength="' . $input['maxlength'] . '"' : '' ?>><?=
																																															$value ?: ''
																																															?></textarea>

			<?php break;

			case 'cbx': ?>

				<label class="
					cbx
					<?= $input['custom-class'] ?? '' ?>
					<?= isset($input['size']) ? 'inp-size' . $input['size'] : '' ?>
				">

					<input type="checkbox" name="<?= $name ?>" value="<?= $value ?>" <?= !empty($input['checked']) || ($name && isset($_POST[$name])) || ($name && isset($data[$name]) && $data[$name] == $value) ? 'checked' : '' ?> <?= isset($input['required']) ? 'required' : '' ?>>

					<div class="icon"></div>

					<p><?= $input['text'] ?></p>

				</label>

			<?php break;

			case 'radio': ?>

				<label class="checkbox
					<?= $input['custom-class'] ?? '' ?>
					<?= isset($input['size']) ? 'inp-size' . $input['size'] : '' ?>
				">

					<input type="radio" name="<?= $name ?>" value="<?= $value ?>" <?= !empty($input['checked']) || ($name && isset($_POST[$name])) || ($name && isset($data[$name]) && $data[$name] == $value) ? 'checked' : '' ?> <?= isset($input['required']) ? 'required' : '' ?>>

					<span></span>

					<p><?= $input['text'] ?></p>

				</label>

			<?php break;

			case 'btn': ?>

				<button type="submit" class="<?= $input['btn-type'] ?? 'pbtn' ?> <?= isset($input['load']) ? 'file-submit' : '' ?>" name="<?= $name ?: 'submit' ?>">
					<?= $input['text'] ?? '' ?>
				</button>

				<?php if (isset($input['load'])) { ?>

					<div class="file-load">
						<?= icon_embed('loading') ?>
					</div>

				<?php } ?>

			<?php break;

			default: ?>

				<input type="<?= $type ?>" class="
					inp
					<?= $input['custom-class'] ?? '' ?>
					<?= isset($input['size']) ? 'inp-size' . $input['size'] : '' ?>
				" name="<?= $name ?>" value="<?= $value ?>" placeholder="<?= $styling ? '' : ($input['text'] ?? '') ?>" <?= isset($input['minlength']) ? 'minlength="' . $input['minlength'] . '"' : '' ?> <?= isset($input['maxlength']) ? 'maxlength="' . $input['maxlength'] . '"' : '' ?> <?= isset($input['min']) ? 'min="' . $input['min'] . '"' : '' ?> <?= isset($input['max']) ? 'max="' . $input['max'] . '"' : '' ?> <?= isset($input['step']) ? 'step="' . $input['step'] . '"' : '' ?> <?= isset($input['required']) ? 'required' : '' ?> <?php
																																																																																																																																						if (isset($input['data']))
																																																																																																																																							foreach ($input['data'] as $dataName => $dataValue) echo 'data-' . $dataName . '="' . $dataValue . '" '
																																																																																																																																						?>>

			<?php break;
		}

		// styling closing tag
		if ($styling == 'fancy') { ?>

			<p class="fancy-input-lbl"><?= $input['text'] ?></p>

		</div>

<?php }
	}
