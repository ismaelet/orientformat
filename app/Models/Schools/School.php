<?php

namespace App\Models\Schools;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class School extends Model {

	/**
	 * The attributes that are mass assignable.
	 * 
	 * @var array
	 */
	protected $fillable = [
		'name',
		'has_high_school',
	];

	/**
	 * The classes that belong to the school.
	 * 
	 * @return HasMany
	 */
	public function school_classes(): HasMany {
		return $this->hasMany(SchoolClass::class, 'schoolId')->orderByDesc('year')->orderByDesc('grade')->orderBy('letter');
	}
}
