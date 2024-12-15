<?php

namespace App\Models\Schools;

use App\Models\User\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

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

	/**
	 * The students that belong to the school.
	 * 
	 * @return HasManyThrough 
	 */
	public function students(): HasManyThrough {
		return $this->hasManyThrough(Student::class, SchoolClass::class, 'schoolId', 'schoolClassId');
	}
}
