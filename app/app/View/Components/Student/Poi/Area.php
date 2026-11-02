<?php

namespace App\View\Components\Student\Poi;

use App\Models\Activities\Section;
use App\Models\User\Student;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Area extends Component
{
    public string $name;

    public string $subtitle;

    public string $description;

    public array $sections = [];

    /**
     * Create a new component instance.
     */
    public function __construct(public array $area, public Student $student)
    {
        $this->name = $this->area['name'];
        $this->subtitle = $this->area['subtitle'];
        $this->description = $this->area['description'];

        foreach ($this->area['sections'] as $sectionId) {
            $this->sections[] = Section::find($sectionId);
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.student.poi.area');
    }
}
