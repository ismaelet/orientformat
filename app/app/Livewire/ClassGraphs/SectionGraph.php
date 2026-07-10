<?php

namespace App\Livewire\ClassGraphs;

use App\Models\Activities\Section;
use App\Models\Schools\SchoolClass;
use App\Services\Graphs\SectionGraphData;
use App\Services\Results\PlatformSectionResultProvider;
use App\Services\Results\ClassSectionResultProvider;
use App\Services\Results\SectionGroupResultCalculator;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Locked;
use Livewire\Component;

#[Lazy]
class SectionGraph extends Component {
    #[Locked]
    public int $sectionId;

    #[Locked]
    public int $schoolClassId;

    public ?array $graph = null;

    public function mount(
        int $sectionId,
        int $schoolClassId,
        ClassSectionResultProvider $schoolClassResultProvider,
        PlatformSectionResultProvider $platformResultProvider,
        SectionGraphData $graphData,
    ): void {
        $this->sectionId = $sectionId;
        $this->schoolClassId = $schoolClassId;

        $section = Section::findOrFail(
            $sectionId,
        );

        $class = SchoolClass::findOrFail(
            $schoolClassId,
        );

        $schoolClassResult =
            $schoolClassResultProvider->get(
                section: $section,
                class: $class,
            );

        $platformResult =
            $platformResultProvider->get(
                $section,
            );

        $this->graph = $graphData->buildComparison(
            section: $section,
            schoolClassResult: $schoolClassResult,
            platformResult: $platformResult,
        );
    }

    public function render(): View {
        return view(
            'livewire.class-graphs.section-graph',
        );
    }

    public function placeholder(): View {
        return view(
            'livewire.class-graphs.section-graph-placeholder',
        );
    }
}
