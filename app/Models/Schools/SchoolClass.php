<?php

namespace App\Models\Schools;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SchoolClass extends Model {

	/**
	 * The attributes that are mass assignable
	 */
	protected $fillable = [];

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
	 * Grade
	 * 
	 * ! NOT A RELATIONSHIP
	 */
	public function grade(): Grade {
		return new Grade($this->grade, $this->professional);
	}

	/**
	 * * Attributes
	 */

	/**
	 * Get the class's url
	 */
	public function url(): string {
		return client_url('/class?class-id=' . $this->id);
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
		return $this->startingYear + $this->currentGrade - $this->startingGrade;
	}

	/**
	 * Get the year range string
	 */
	public function yearRangeString(): string {
		return $this->lastActiveYear() . ' - ' . ($this->lastActiveYear() + 1);
	}
}
