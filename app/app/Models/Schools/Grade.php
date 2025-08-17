<?php

namespace App\Models\Schools;

use App\Models\Activities\Section;
use App\Models\Activities\Test;
use App\Models\Results\User\GradeResult;
use App\Models\Results\User\TestResult;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Number;

class Grade extends Model {

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
	 * Get the sections that are completable for this grade
	 */
	public function completable_sections(): Collection {
		return $this->sections()->where('isStandard', true)->get();
	}

	public function slug(): string {
		return $this->number > 5 ?
			($this->is_professional ? $this->number . 'P' : $this->number . 'L') : $this->number;
	}

	public function isMiddleschool(): bool {
		return $this->number < 4;
	}

	public function tests(): Collection {
		return Test::join('activities_sections', 'activities_tests.sectionId', '=', 'activities_sections.id')
			->where('isStandard', true)
			->where('activities_tests.active', true)
			->where('activities_sections.active', true)
			->whereRaw('FIND_IN_SET(?, years)', [$this->slug()])
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
	 * Get a grade by its absolute number and professional status
	 */
	public static function getByNumber(int $number, bool $professional = false): ?self {
		return self::where('absolute_number', $number)->where('is_professional', $professional)->first();
	}

	/**
	 * Get the ordinal representation of the grade
	 */
	public function ordinal(): string {
		return __(Number::spellOrdinal($this->school_relative_number));
	}
}
