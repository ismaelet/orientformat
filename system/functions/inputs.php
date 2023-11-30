<?php

/*
* endpoint: the class to target
* value-field: the field that contains the value that will populate the hidden input, used on form submit
* value-show: the field that contains the value that will be visible to the user, not used on form submit
* filter: the fields that have to be searched, separated by comma
*/

function input_search($input) {
	$config = $input['search'];
?>

	<div class="ajax-search pos-rel" data-endpoint="<?= $config['endpoint'] ?>" data-value-field="<?= $config['value-field'] ?? '' ?>" data-show-field="<?= $config['show-field'] ?? '' ?>" data-filter="<?= $config['filter'] ?? '' ?>">

		<input type="hidden" class="ajax-search-id" name="<?= $input['name'] ?>" value="<?= $config['value-field'] ?? '' ?>" <?= isset($input['required']) ? 'required' : '' ?>>

		<input type="text" class="inp ajax-search-txt" value="<?= $config['value-show'] ?? '' ?>" placeholder="<?= $input['text'] ?? '' ?>" <?= isset($input['required']) ? 'required' : '' ?> autocomplete="off">

		<div class="ajax-search-ddown">
			<div class="ajax-search-box"></div>
		</div>
	</div>

<?php }
