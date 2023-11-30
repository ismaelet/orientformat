<?php

namespace app\Models\Helpers;

use app\Models\Model;

/**
 * @method string text()
 */
class Notification extends Model {
	/**
	 * Table data
	 */
	protected const TABLE = 'notifications';
	protected const TABLE_LINKS = [];

	public function text() {
		return nl2br($this->databaseData['text']);
	}

	public function date() {
		return date('Y-m-d', strtotime($this->databaseData['time']));
	}
}
