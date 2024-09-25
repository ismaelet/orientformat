<?php

namespace App\Models\Results\User;

use Illuminate\Database\Eloquent\Model;

class SectionResult extends Model {

	/**
	 * The table associated with the model.
	 * 
	 * @var string
	 */
	protected $table = 'results_sections';

	/**
	 * The attributes that are mass assignable.
	 * 
	 * @var array
	 */
	protected $fillable = [];
}
