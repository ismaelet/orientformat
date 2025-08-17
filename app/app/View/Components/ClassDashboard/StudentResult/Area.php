<?php

namespace App\View\Components\ClassDashboard\StudentResult;

use App\Models\Activities\Area as ActivitiesArea;
use App\Models\Schools\Grade;
use App\Models\User\Student;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class Area extends Component {

	/**
	 * Create a new component instance.
	 */
	public function __construct(
		public ActivitiesArea $area,
		public Student $student,
		public Collection $sections,
	) {
		$this->sections = $sections
			->where('areaId', $this->area->id)
			->sortBy('id');
	}

	/**
	 * Get the view / contents that represent the component.
	 */
	public function render(): View|Closure|string {
		return view('components.class-dashboard.student-result.area');
	}
}
