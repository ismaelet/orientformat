<?php

namespace App\Models\Reviews;

use App\Models\Model;

class Review extends Model {

	/**
	 * @property string the name of the table associated to the model
	 */
	protected const TABLE = 'reviews';

	/**
	 * @param array the list of settable properties as ['propertyName' => 'propertyType', ...]
	 */
	protected const SETTABLE = ['title' => 'string'];
}
