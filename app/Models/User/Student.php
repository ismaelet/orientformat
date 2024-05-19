<?php

namespace App\Models\User;

use App\Models\Schools\SchoolClass;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model {

	/**
	 * The attributes that are mass assignable
	 */
	protected $fillable = [];

	/**
	 * * Relationships
	 */
	public function school_class(): BelongsTo {
		return $this->belongsTo(SchoolClass::class, 'schoolClassId');
	}

	/**
	 * * Attributes
	 */
	public function isHighschoolStudent(): bool {
		return $this->school_class->isInHighschool();
	}
}
