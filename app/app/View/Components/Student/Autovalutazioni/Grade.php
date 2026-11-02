<?php

namespace App\View\Components\Student\Autovalutazioni;

use App\Models\Schools\Grade as SchoolsGrade;
use App\Models\User\Student;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class Grade extends Component
{
    public Collection $areas;

    /**
     * Create a new component instance.
     */
    public function __construct(public SchoolsGrade $grade, public Student $student)
    {
        $this->areas = $grade->areas;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.student.autovalutazioni.grade');
    }
}
