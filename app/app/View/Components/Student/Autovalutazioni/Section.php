<?php

namespace App\View\Components\Student\Autovalutazioni;

use App\Helpers\SectionResultHelper;
use App\Models\Activities\Section as ActivitiesSection;
use App\Models\Activities\Test;
use App\Models\User\Student;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Section extends Component {

	public string $resultLabel;

	public string $userType;

	public ?string $result = null;

	public Test $selfEvaluationTest;

	public bool $hasDependentTests;

	/**
	 * Create a new component instance.
	 */
	public function __construct(public ActivitiesSection $section, public Student $student, public int $key) {
		$this->userType = is_teacher() ? 'teacher' : 'student';

		// Result data
		$this->resultLabel = $section->result_label ?: 'Risultato dell\'autovalutazione';
		$student->load('section_results', 'section_results.student', 'section_results.section', 'section_results.section.evaluation_test');
		$this->result = SectionResultHelper::label($student, $section);
		$this->selfEvaluationTest = $section->evaluation_test;

		// Reset data
		$this->hasDependentTests = (bool) $this->selfEvaluationTest->dependent_tests()?->count();
	}

	/**
	 * Get the view / contents that represent the component.
	 */
	public function render(): View|Closure|string {
		return view('components.student.autovalutazioni.section');
	}
}
