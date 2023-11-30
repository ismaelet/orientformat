<?php

namespace app\Models\Framework;

use app\Models\Model;

class Migration extends Model {
	/**
	 * Table name
	 */
	protected const TABLE = 'migrations';

	public static function allMigrations() {
		return self::list('migration') ?: [];
	}
}
