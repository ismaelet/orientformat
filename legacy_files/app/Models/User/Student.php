<?php

namespace LegacyModels\User;

use LegacyModels\Model;

class Student extends Model {

	/**
	 * @property string the name of the table associated to the model
	 */
	protected const TABLE = 'students';

	/**
	 * @param array the list of settable properties as ['propertyName' => 'propertyType', ...]
	 */
	protected const SETTABLE = [];
}
