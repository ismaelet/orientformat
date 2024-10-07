<?php

namespace App\Models\User;

use App\Models\Schools\School;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Administrator extends Model {

	/**
	 * The attributes that are mass assignable.
	 * 
	 * @var array
	 */
	protected $fillable = [
		'user_id',
		'school_id',
	];

	/**
	 * The school that the administrator belongs to.
	 * 
	 * @return BelongsTo
	 */
	public function school(): BelongsTo {
		return $this->belongsTo(School::class);
	}
}
