<?php

namespace App\Models\Schools;

use App\Models\Activities\Section;
use App\Models\Activities\Test;
use App\Models\Results\User\GradeResult;
use App\Models\Results\User\TestResult;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Grade extends Model {

	/**
	 * The table associated with the model
	 */
	protected $table = 'activities_grades';

	/**
	 * The attributes that are mass assignable
	 */
	protected $fillable = [];

	/**
	 * Relationship: The sections that belong to this grade
	 */
	public function sections(): BelongsToMany {
		return $this->belongsToMany(Section::class);
	}

	public function relative_number(): int {
		return $this->isMiddleSchool() ? $this->number : $this->number - 3;
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
}
