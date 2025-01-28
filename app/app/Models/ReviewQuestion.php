<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewQuestion extends Model {

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [];

	/**
	 * Get the options for the question.
	 * 
	 * @return array
	 */
	public function options(): array {
		return explode(',', $this->rows);
	}
}
