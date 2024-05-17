<?php

namespace LegacyModels\Helpers;

use LegacyModels\OldModel;

/**
 * @method string text()
 */
class Notification extends OldModel {
	/**
	 * Table data
	 */
	protected const TABLE = 'notifications';
	protected const TABLE_LINKS = [];
	protected const SETTABLE = [
		'text' => ['type' => 'string'],
	];

	public function text() {
		return nl2br($this->databaseData['text']);
	}

	public function date() {
		return date('Y-m-d', strtotime($this->databaseData['time']));
	}
}
