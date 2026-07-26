<?php

namespace App\Livewire\ClassGraphs;

use App\Models\Activities\Section;
use App\Models\Schools\SchoolClass;
use App\Services\Graphs\SectionGraphData;
use App\Services\Results\ClassSectionResultProvider;
use App\Services\Results\PlatformSectionResultProvider;
use App\Support\Graphs\GraphSections;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Locked;
use Livewire\Component;

#[Lazy]
class SectionGraph extends Component {
    #[Locked]
    public int $sectionId;

    #[Locked]
    public string $graphKey;

    #[Locked]
    public int $schoolClassId;

    #[Locked]
    public int $areaId;

    #[Locked]
    public string $sectionName;

    #[Locked]
    public int $iconSectionId;

    public ?array $graph = null;

    public function mount(
        int $sectionId,
        int $schoolClassId,
        int $areaId,
        string $graphKey,
        ClassSectionResultProvider $schoolClassResultProvider,
        PlatformSectionResultProvider $platformResultProvider,
        SectionGraphData $graphData,
    ): void {
        $this->sectionId = $sectionId;
        $this->schoolClassId = $schoolClassId;
        $this->areaId = $areaId;
        $this->graphKey = $graphKey;

        $section = Section::findOrFail($sectionId);

        $graphDefinition =
            GraphSections::graphDefinitionForSection(
                section: $section,
                graphKey: $graphKey,
            );

        $this->sectionName =
            $graphDefinition->displayTitle();

        $this->iconSectionId =
            $section->effectiveMainSectionId();

        $schoolClass = SchoolClass::findOrFail(
            $schoolClassId,
        );

        $schoolClassResult =
            $schoolClassResultProvider->getForGraph(
                graph: $graphDefinition,
                schoolClass: $schoolClass,
            );

        $platformResult =
            $platformResultProvider->getForGraph(
                graph: $graphDefinition,
            );

        $this->graph =
            $graphData->buildComparisonForGraph(
                graph: $graphDefinition,
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
