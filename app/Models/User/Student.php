<?php

namespace App\Models\User;

use App\Models\Results\User\AdditionalResult;
use App\Models\Results\User\CondensedSectionResult;
use App\Models\Results\User\GradeResult;
use App\Models\Results\User\OtherResult;
use App\Models\Results\User\PermanentResult;
use App\Models\Results\User\SectionResult;
use App\Models\Results\User\TestResult;
use App\Models\ReviewResult;
use App\Models\Schools\Grade;
use App\Models\Schools\SchoolClass;
use App\Models\Student\Advice;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model {

	use SoftDeletes;

	/**
	 * The primary key associated with the table.
	 * 
	 * @var string
	 */
	protected $primaryKey = 'userId';

	/**
	 * The attributes that are mass assignable.
	 * 
	 * @var array
	 */
	protected $fillable = [
		'userId',
		'id',
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
	 * Get the student's given advice
	 * 
	 * @return HasOne
	 */
	public function advice(): HasOne {
		return $this->hasOne(Advice::class, 'userID', 'userId');
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
	 * The section results of the student
	 * 
	 * @return HasMany
	 */
	public function section_results(): HasMany {
		return $this->hasMany(SectionResult::class, 'studentId');
	}

	/**
	 * The condensed section results of the student
	 * 
	 * @return HasMany
	 */
	public function condensed_section_results(): HasMany {
		return $this->hasMany(CondensedSectionResult::class, 'student_id');
	}

	/**
	 * The grade results of the student
	 * 
	 * @return HasMany
	 */
	public function grade_results(): HasMany {
		return $this->hasMany(GradeResult::class, 'studentId');
	}

	/**
	 * The test additional results of the student
	 * 
	 * @return HasMany
	 */
	public function additional_results(): HasMany {
		return $this->hasMany(AdditionalResult::class, 'studentId');
	}

	/**
	 * The test other results of the student
	 * 
	 * @return HasMany
	 */
	public function other_results(): HasMany {
		return $this->hasMany(OtherResult::class, 'userID');
	}

	/**
	 * The test permanent results of the student
	 * 
	 * @return HasMany
	 */
	public function permanent_results(): HasMany {
		return $this->hasMany(PermanentResult::class, 'studentId');
	}

	/**
	 * The review results of the student
	 * 
	 * @return HasMany
	 */
	public function review_results(): HasMany {
		return $this->hasMany(ReviewResult::class, 'studentId');
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
