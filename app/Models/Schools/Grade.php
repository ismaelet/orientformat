<?php

namespace App\Models\Schools;

use App\Models\Activities\Test;
use App\Models\Results\User\GradeResult;
use App\Models\Results\User\TestResult;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class Grade {

	public $number;
	public $is_professional;

	public function __construct(int $number, bool $isProfessional) {
		$this->number = $number;
		$this->is_professional = $isProfessional;
	}

	/**
	 * * Accessors
	 * 
	 * ! NOT AN ACCESSOR
	 */
	public function relative_number(): int {
		return $this->isMiddleSchool() ? $this->number : $this->number - 3;
	}

	/**
	 * * Attributes
	 */

	/**
	 * Slug
	 */
	public function slug(): string {
		return $this->number > 5 ?
			($this->is_professional ? $this->number . 'P' : $this->number . 'L') : $this->number;
	}

	/**
	 * 
	 */
	public function isMiddleschool(): bool {
		return $this->number < 4;
	}

	/**
	 * Test IDs
	 */
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

	/**
	 * * Actions
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
}
