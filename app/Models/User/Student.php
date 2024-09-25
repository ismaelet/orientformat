<?php

namespace App\Models\User;

use App\Models\Results\User\TestResult;
use App\Models\Schools\Grade;
use App\Models\Schools\SchoolClass;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model {

	use SoftDeletes;

	/**
	 * The attributes that are mass assignable.
	 * 
	 * @var array
	 */
	protected $fillable = [
		'schoolClassId',
		'created_at',
	];

	/**
	 * The user linked to the student
	 * 
	 * @return BelongsTo
	 */
	public function user(): BelongsTo {
		return $this->belongsTo(User::class, 'userId');
	}

	/**
	 * The class the student is in
	 * 
	 * @return BelongsTo
	 */
	public function school_class(): BelongsTo {
		return $this->belongsTo(SchoolClass::class, 'schoolClassId');
	}

	/**
	 * The test results of the student
	 * 
	 * @return HasMany
	 */
	public function test_results(): HasMany {
		return $this->hasMany(TestResult::class, 'studentId');
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
	 * Check if the student is in middle school
	 * 
	 * @return bool
	 */
	public function isMiddleSchoolStudent(): bool {
		return $this->school_class->isMiddleSchool();
	}

	/**
	 * Check if the student is in high school
	 */
	public function isHighSchoolStudent(): bool {
		return $this->school_class->isHighschool();
	}
}
