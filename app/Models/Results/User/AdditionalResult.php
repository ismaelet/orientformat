<?php

namespace App\Models\Results\User;

use Illuminate\Database\Eloquent\Model;

class AdditionalResult extends Model {

	/**
	 * The table associated with the model.
	 * 
	 * @var string
	 */
	protected $table = 'results_additional';

	/**
	 * The attributes that are mass assignable.
	 * 
	 * @var array
	 */
	protected $fillable = [
		'studentId',
		'testId',
		'primaryResults',
		'secondaryResults',
	];
}
