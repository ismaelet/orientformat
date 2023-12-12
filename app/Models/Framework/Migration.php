<?php

namespace App\Models\Framework;

use App\Models\Model;

class Migration extends Model {

	/**
	 * @property string the name of the table associated to the model
	 */
	protected const TABLE = 'migrations';

	/**
	 * @property array the list of settable properties as ['propertyName' => 'propertyType', ...]
	 */
	protected const SETTABLE = [];
}
