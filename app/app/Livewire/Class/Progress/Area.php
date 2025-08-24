<?php

namespace App\Livewire\Class\Progress;

use App\Models\Activities\Area as ActivitiesArea;
use App\Models\Schools\Grade;
use App\Models\Schools\SchoolClass;
use Livewire\Attributes\On;
use Livewire\Component;

class Area extends Component {

	public $rounded = false;

	public $tollerance = 0.75;

	public int $totalSections = 0;

	public int $completedSections = 0;

	public int $completionPercentage = 0;

	public ActivitiesArea $area;

	public Grade $grade;

	public SchoolClass $class;

	public function boot() {
		$this->setup();
	}

	/**
	 * Lifecycle hook: Render the component view
	 */
	public function render() {
		return view('livewire.class.progress.area');
	}

	/**
	 * Event: Toggler updated
	 */
	#[On('togglerUpdated')]
	public function onTogglerUpdated(bool $value): void {
		$this->rounded = $value;
		$this->setup();
	}

	public function setup() {
		$this->area->load('completable_sections', 'completable_sections.grades');

		$sections = $this->area->completable_sections->where('grades', '!=', null)
			->filter(function ($section) {
				return $section->grades->contains($this->grade);
			});

		$students = $this->class->active_students->load('section_results');

		$studentCount = $students->count();

		// Count the number of completed sections
		$completedSections = $sections->filter(function ($section) use ($students, $studentCount) {
			$completedCount = 0;

			foreach ($students as $student) {
				if ($student->hasCompletedSection($section)) {
					$completedCount++;
				}
			}

			return $studentCount ?
				($this->rounded ?
					$studentCount > 0 && ($completedCount / $studentCount) >= $this->tollerance :
					$completedCount >= $studentCount) :
				0;
		});

		$this->totalSections = $sections->count();
		$this->completedSections = $completedSections->count();

		$this->completionPercentage = $this->totalSections > 0 ? ($this->completedSections / $this->totalSections) * 100 : 0;
	}
}
