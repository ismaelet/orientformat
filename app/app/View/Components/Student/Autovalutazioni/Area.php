<?php

namespace App\View\Components\Student\Autovalutazioni;

use App\Models\Activities\Area as ActivitiesArea;
use App\Models\Schools\Grade;
use App\Models\User\Student;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class Area extends Component {

	public Collection $sections;

	/**
	 * Create a new component instance.
	 */
	public function __construct(public ActivitiesArea $area, public Student $student, public Grade $grade) {
		$this->sections = $grade->sectionsInArea($area)
			->whereNotNull('evaluation_test_id')
			->values();
	}

	/**
	 * Get the view / contents that represent the component.
	 */
	public function render(): View|Closure|string {
		return view('components.student.autovalutazioni.area');
	}
}
