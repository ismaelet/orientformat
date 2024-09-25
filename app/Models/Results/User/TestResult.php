<?php

namespace App\Models\Results\User;

use Illuminate\Database\Eloquent\Model;

class TestResult extends Model {

	/**
	 * The table associated with the model.
	 * 
	 * @var string
	 */
	protected $table = 'results_tests';

	/**
	 * The attributes that are mass assignable.
	 * 
	 * @var array
	 */
	protected $fillable = [];
}
