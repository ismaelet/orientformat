<?php

namespace App\View\Components\ClassDashboard\StudentResult;

use App\Models\Schools\Grade as SchoolsGrade;
use App\Models\User\Student;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\View\Component;

class Grade extends Component {

	/**
	 * Property: The areas associated with the grade
	 */
	public SupportCollection $areas;

	/**
	 * Property: The sections associated with the grade
	 */
	public Collection $sections;

	/**
	 * Property: The title associated with the grade
	 */
	public string $title;

	/**
	 * Create a new component instance.
	 */
	public function __construct(public SchoolsGrade $grade, public Student $student) {
		$this->sections = $grade->sections
			->where('isStandard', true)
			->load('main_section')
			->sortBy('id');

		$this->areas = $this->sections
			->pluck('area')
			->unique('id')
			->sortBy('id');

		$this->title = __('misc.grade-description', ['numeral' => $grade->ordinal()]);
	}

	/**
	 * Get the view / contents that represent the component.
	 */
	public function render(): View|Closure|string {
		return view('components.class-dashboard.student-result.grade');
	}
}
