<?php

namespace App\Livewire\ClassGraphs;

use App\Models\Activities\Section;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Area extends Component {

    #[Locked]
    public string $areaName;

    #[Locked]
    public int $areaId;

    #[Locked]
    public int $schoolClassId;

    /**
     * Section IDs available in this area.
     */
    #[Locked]
    public array $sectionIds = [];

    /**
     * Currently visible section position.
     */
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
        $this->sectionIds = array_values($sectionIds);
    }

    public function previous(): void {
        $count = count($this->sectionIds);

        if ($count === 0) {
            return;
        }

        $this->position = $this->position <= 0
            ? $count - 1
            : $this->position - 1;
    }

    public function next(): void {
        $count = count($this->sectionIds);

        if ($count === 0) {
            return;
        }

        $this->position = $this->position >= $count - 1
            ? 0
            : $this->position + 1;
    }

    public function select(int $position): void {
        if (!array_key_exists($position, $this->sectionIds)) {
            return;
        }

        $this->position = $position;
    }

    public function render(): View {
        $sections = Section::query()
            ->whereIn('id', $this->sectionIds)
            ->get()
            ->keyBy('id');

        $orderedSections = collect($this->sectionIds)
            ->map(
                fn(int $sectionId) => $sections->get($sectionId),
            )
            ->filter()
            ->values();

        return view('livewire.class-graphs.area', [
            'sections' => $orderedSections,
            'currentSection' => $orderedSections->get(
                $this->position,
            ),
        ]);
    }
}
