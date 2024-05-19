<?php

namespace App\Models\Schools;

use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model {

	/**
	 * The attributes that are mass assignable
	 */
	protected $fillable = [];

	/**
	 * * Attributes
	 */

	/**
	 * Check if the class is in highschool
	 */
	public function isInHighschool(): bool {
		return $this->startingGrade > 3;
	}
}
