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
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model {

	use SoftDeletes;

	/**
	 * The primary key associated with the table
	 */
	protected $primaryKey = 'userId';

	/**
	 * The attributes that are mass assignable.
	 */
	protected $fillable = [
		'userId',
		'id',
		'schoolClassId',
		'created_at',
	];

	/**
	 * Get the student's inverted full name
	 */
	public function invertedFullName(): Attribute {
		return new Attribute(
			get: fn() => $this->user->inverted_full_name,
		);
	}

	/**
	 * The user linked to the student
	 */
	public function user(): BelongsTo {
		return $this->belongsTo(User::class, 'userId');
	}

	/**
	 * The class the student is in
	 */
	public function school_class(): BelongsTo {
		return $this->belongsTo(SchoolClass::class, 'schoolClassId');
	}

	/**
	 * Get the student's given advice
	 */
	public function advice(): HasOne {
		return $this->hasOne(Advice::class, 'userID', 'userId');
	}

	/**
	 * The test results of the student
	 */
	public function test_results(): HasMany {
		return $this->hasMany(TestResult::class, 'studentId');
	}

	/**
	 * The section results of the student
	 */
	public function section_results(): HasMany {
		return $this->hasMany(SectionResult::class, 'studentId');
	}

	/**
	 * The condensed section results of the student
	 */
	public function condensed_section_results(): HasMany {
		return $this->hasMany(CondensedSectionResult::class, 'student_id');
	}

	/**
	 * The grade results of the student
	 */
	public function grade_results(): HasMany {
		return $this->hasMany(GradeResult::class, 'studentId');
	}

	/**
	 * The test additional results of the student
	 */
	public function additional_results(): HasMany {
		return $this->hasMany(AdditionalResult::class, 'studentId');
	}

	/**
	 * The test other results of the student
	 */
	public function other_results(): HasMany {
		return $this->hasMany(OtherResult::class, 'userID');
	}

	/**
	 * The test permanent results of the student
	 */
	public function permanent_results(): HasMany {
		return $this->hasMany(PermanentResult::class, 'studentId');
	}

	/**
	 * The review results of the student
	 */
	public function review_results(): HasMany {
		return $this->hasMany(ReviewResult::class, 'studentId');
	}

	/**
	 * Grade
	 * !TO FIX: Grade isn't a real model
	 */
	public function grade(): Grade {
		return $this->school_class->grade();
	}

	/**
	 * Check if the student is in middle school
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

	/**
	 * Get the student's grade number at a specific date
	 */
	public function gradeWhen(string $date): ?int {
		$grade = $this->school_class?->gradeWhen($date);

		if ($grade) {
			return $grade;
		}

		return null;
	}
}
