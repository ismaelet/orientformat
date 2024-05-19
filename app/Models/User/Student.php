<?php

namespace App\Models\User;

use App\Models\Schools\Grade;
use App\Models\Schools\SchoolClass;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model {

	/**
	 * The attributes that are mass assignable
	 */
	protected $fillable = [
		'created_at'
	];

	/**
	 * * Relationships
	 */

	/**
	 * School class
	 */
	public function school_class(): BelongsTo {
		return $this->belongsTo(SchoolClass::class, 'schoolClassId');
	}

	/**
	 * Grade
	 * 
	 * !TO FIX: Grade isn't a real model
	 */
	public function grade(): Grade {
		return $this->school_class->grade();
	}

	/**
	 * * Attributes
	 */
	public function isHighschoolStudent(): bool {
		return $this->school_class->isInHighschool();
	}
}
