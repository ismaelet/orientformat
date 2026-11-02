<?php

namespace App\Livewire\ClassGraphs;

use App\Models\Activities\Section;
use App\Support\Graphs\GraphSections;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Area extends Component
{
    #[Locked]
    public string $areaName;

    #[Locked]
    public int $areaId;

    #[Locked]
    public int $schoolClassId;

    /**
     * @var array<int>
     */
    #[Locked]
    public array $sectionIds = [];

    /**
     * @var array<int, array{
     *     section_id: int,
     *     graph_key: string
     * }>
     */
    #[Locked]
    public array $graphItems = [];

    public int $position = 0;

    public function mount(
        int $areaId,
        string $areaName,
        int $schoolClassId,
        array $sectionIds,
    ): void {
        $this->areaId = $areaId;
        $this->areaName = $areaName;
        $this->schoolClassId = $schoolClassId;
        $this->sectionIds = $sectionIds;

        $sections = Section::query()
            ->whereIn('id', $sectionIds)
            ->get()
            ->keyBy('id');

        foreach ($sectionIds as $sectionId) {
            $section = $sections->get($sectionId);

            if ($section === null) {
                continue;
            }

            foreach (
                GraphSections::graphDefinitionsForSection(
                    $section,
                ) as $graphDefinition
            ) {
                $this->graphItems[] = [
                    'section_id' => $section->id,
                    'graph_key' => $graphDefinition->key,
                ];
            }
        }
    }

    public function previous(): void
    {
        $count = count($this->graphItems);

        if ($count === 0) {
            return;
        }

        $this->position =
            ($this->position - 1 + $count) % $count;
    }

    public function next(): void
    {
        $count = count($this->graphItems);

        if ($count === 0) {
            return;
        }

        $this->position =
            ($this->position + 1) % $count;
    }

    public function select(int $position): void
    {
        if (! isset($this->graphItems[$position])) {
            return;
        }

        $this->position = $position;
    }

    public function render(): View
    {
        $currentGraphItem =
            $this->graphItems[$this->position] ?? null;

        $currentSection = $currentGraphItem
            ? Section::find(
                $currentGraphItem['section_id'],
            )
            : null;

        return view('livewire.class-graphs.area', [
            'currentSection' => $currentSection,
            'currentGraphItem' => $currentGraphItem,
        ]);
    }
}
