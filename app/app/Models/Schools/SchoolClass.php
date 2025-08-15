<?php

namespace App\Models\Schools;

use App\Models\User\Student;
use App\Models\User\Teacher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolClass extends Model {

	use SoftDeletes;

	/**
	 * The attributes that are mass assignable
	 */
	protected $fillable = [
		'schoolId',
		'referentId',
		'grade',
		'startingGrade',
		'letter',
		'code',
		'startingYear',
		'year',
		'ended',
		'professional',
	];

	/**
	 * * Accessors
	 */

	/**
	 * Get the class's name
	 */
	public function getNameAttribute(): string {
		return $this->isMiddleSchool() ? $this->grade()->relative_number() . $this->letter : $this->letter;
	}

	/**
	 * * Relationships
	 */

	/**
	 * School
	 */
	public function school(): BelongsTo {
		return $this->belongsTo(School::class, 'schoolId');
	}

	/**
	 * Students
	 */
	public function students(): HasMany {
		return $this->hasMany(Student::class, 'schoolClassId');
	}

	/**
	 * Grade
	 * 
	 * ! NOT A RELATIONSHIP
	 */
	public function grade(): Grade {
		return new Grade($this->grade, $this->professional);
	}

	public function teachers() {
		return Teacher::whereRaw("FIND_IN_SET(?, classes)", [$this->id])->get();
	}

	/**
	 * * Attributes
	 */

	/**
	 * Get the class's url
	 */
	public function url(): string {
		return route('class.show', ['class' => $this->id]);
	}

	/**
	 * Check if the class is in middle school
	 */
	public function isMiddleSchool(): bool {
		return $this->startingGrade < 4;
	}

	/**
	 * Check if the class is in high school
	 */
	public function isHighSchool(): bool {
		return $this->startingGrade > 3;
	}

	/**
	 * Get the last active year
	 */
	function lastActiveYear(): int {
		return $this->year;
	}

	/**
	 * Get the year range string
	 */
	public function yearRangeString(): string {
		return $this->lastActiveYear() . ' - ' . ($this->lastActiveYear() + 1);
	}

	/**
	 * Get grade numbers
	 */
	public function gradeNumbers(): array {
		if ($this->professional) {
			return range(4, 7);
		}

		if ($this->isHighSchool()) {
			return range(4, 8);
		}

		return range(1, 3);
	}

	/**
	 * Check if the class has a grade
	 */
	public function hasGrade(int $gradeNumber): bool {
		return in_array($gradeNumber, $this->gradeNumbers());
	}

	/**
	 * Get the grade number at a specific date
	 */
	public function gradeWhen(string $date): int {
		$lastYear = $this->isHighSchool() ? ($this->isprofessional ? 7 : 8) : 3;
		$year = date('Y', strtotime($date));
		$month = date('m', strtotime($date));
		$year = $month >= 9 ? $year : $year - 1;
		$diffYear = $year - $this->startingYear;

		return min($this->startingGrade + $diffYear, $lastYear);
	}
}
