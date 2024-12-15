<?php

namespace App\Models\User;

use App\Models\Schools\School;
use Illuminate\Database\Eloquent\Collection;
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

	/**
	 * The students that the administrator is responsible for.
	 * 
	 * @return Collection
	 */
	public function students(): Collection {
		return $this->school->students;
	}

	/**
	 * The IDs of the students that the administrator is responsible for.
	 * 
	 * @return array
	 */
	public function studentIds(): array {
		return $this->students()->pluck('id')->toArray();
	}
}
