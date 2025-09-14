<?php

namespace App\Models\Schools;

use App\Models\Activities\Area;
use App\Models\Activities\Section;
use App\Models\Activities\Test;
use App\Models\Results\User\GradeResult;
use App\Models\Results\User\TestResult;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Number;

class Grade extends Model {

	public const MIDDLE_SCHOOL_GRADES = [1, 2, 3];

	public const HIGH_SCHOOL_GRADES = [4, 5, 6, 7, 8, 9];

	public const PROFESSIONAL_GRADES = [4, 5, 6, 7, 8];

	/**
	 * The table associated with the model
	 */
	protected $table = 'activities_grades';

	/**
	 * The attributes that are mass assignable
	 */
	protected $fillable = [
		'absolute_number',
		'school_relative_number',
		'is_highschool',
		'is_professional',
	];

	/**
	 * Attribute: The name of the grade
	 */
	public function name(): Attribute {
		return Attribute::make(
			get: fn() => ucfirst($this->ordinal()) . ' anno'
		);
	}

	/**
	 * Attribute: The full name of the grade
	 */
	public function fullName(): Attribute {
		return Attribute::make(
			get: fn() => ucfirst($this->ordinal()) . ' anno' . ($this->isMiddleschool() ? '' : ($this->is_professional ? ' (professionale)' : ' (liceo)'))
		);
	}

	/**
	 * Attribute: The relative number of the grade
	 */
	public function relativeNumber(): Attribute {
		return Attribute::make(
			get: fn() => $this->school_relative_number
		);
	}

	/**
	 * Relationship: The sections that belong to this grade
	 */
	public function sections(): BelongsToMany {
		return $this->belongsToMany(Section::class);
	}

	/**
	 * Relationship: The completable sections that belong to this grade
	 */
	public function completable_sections(): BelongsToMany {
		return $this->belongsToMany(Section::class)
			->where('active', true)
			->where('isStandard', true);
	}

	/**
	 * Relationship: The areas that belong to this grade
	 */
	public function areas(): BelongsToMany {
		return $this->belongsToMany(Area::class);
	}

	/**
	 * The sections that belong to this grade in a specific area
	 */
	public function sectionsInArea(Area $area): Collection {
		return $this->sections->where('areaId', $area->id);
	}

	/**
	 * Get the areas that belong to this grade
	 *
	 * ! To remove after migration in production
	 */
	public function legacy_areas(): Collection {
		return Area::whereIn('id', $this->sections()->pluck('areaId'))->get();
	}

	/**
	 * Get the slug for the grade
	 */
	public function slug(): string {
		return $this->number > 5 ?
			($this->is_professional ? $this->absolute_number . 'P' : $this->absolute_number . 'L') : $this->absolute_number;
	}

	/**
	 * Check if the grade is a middle school grade
	 */
	public function isMiddleschool(): bool {
		return $this->absolute_number < 4;
	}

	/**
	 * Get the tests for the grade
	 */
	public function tests(): Collection {
		$sections = $this->completable_sections;

		return Test::whereIn('sectionId', $sections->pluck('id'))
			->where('active', true)
			->get();
	}

	/**
	 * Test Count
	 */
	public function test_count(): int {
		return $this->tests()->count();
	}

	/**
	 * User's Progress
	 */
	private function user_progress() {
		$completedTestCount = TestResult::where('studentId', Auth::id())
			->where('completed', true)
			->whereIn('testId', $this->tests()->pluck('id'))
			->count();

		return round($completedTestCount / $this->test_count() * 100);
	}

	/**
	 * Update the progress for the grade
	 */
	public function updateProgress(): self {
		$progressPercentage = $this->user_progress();

		GradeResult::updateOrCreate([
			'gradeId' => $this->number,
			'studentId' => Auth::id(),
		], [
			'progressPercentage' => $progressPercentage,
		]);

		return $this;
	}

	/**
	 * Get the ordinal representation of the grade
	 */
	public function ordinal(): string {
		return __(Number::spellOrdinal($this->school_relative_number));
	}

	/**
	 * Get the roman numeral representation of the grade
	 */
	public function romanNumeral(): string {
		return toRoman($this->school_relative_number);
	}

	/**
	 * Convert a grade number to its displayed equivalent
	 */
	public static function convertToDisplayed(int $number) {
		return $number > Grade::MIDDLE_SCHOOL_GRADES[count(Grade::MIDDLE_SCHOOL_GRADES) - 1] ? $number - 3 : $number;
	}

	/**
	 * Get a grade by its absolute number and professional status
	 */
	public static function getByNumber(int $number, bool $professional = false): ?self {
		return self::where('absolute_number', $number)->where('is_professional', $professional)->first();
	}

	/**
	 * Get the last middle school grade
	 */
	public static function lastMiddleschool(): int {
		return Grade::MIDDLE_SCHOOL_GRADES[count(Grade::MIDDLE_SCHOOL_GRADES) - 1];
	}
}
