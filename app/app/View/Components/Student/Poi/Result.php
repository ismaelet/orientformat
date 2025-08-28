<?php

namespace App\View\Components\Student\Poi;

use App\Helpers\SectionResultHelper;
use App\Models\Activities\Section;
use App\Models\User\Student;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Result extends Component {

	public ?string $result = null;

	public string $name;

	public ?string $description = null;

	/**
	 * Create a new component instance.
	 */
	public function __construct(Student $student, public Section $section) {
		$this->name = $section->name;
		$this->description = $section->result_label;
		$this->result = SectionResultHelper::label($student, $section);
	}

	/**
	 * Get the view / contents that represent the component.
	 */
	public function render(): View|Closure|string {
		return view('components.student.poi.result');
	}
}
