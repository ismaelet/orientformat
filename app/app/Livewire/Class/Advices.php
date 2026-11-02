<?php

namespace App\Livewire\Class;

use App\Models\Student\Advice;
use App\Models\User\Student;
use Illuminate\View\View;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Advices extends Component
{
    /**
     * Property: The student ID
     */
    #[Locked]
    public int $studentId;

    /**
     * Property: The available advices
     */
    #[Locked]
    public array $advices = [];

    /**
     * Property: The selected advice IDs
     */
    public array $selectedAdvices = [0, 0, 0];

    /**
     * Property: The number of times the save action has been triggered
     */
    public int $saveCount = 0;

    /**
     * Lifecycle hook: Initialize the component
     */
    public function mount(Student $student, array $advices): void
    {
        $this->studentId = $student->id;
        $this->advices = $advices;

        $selectedAdviceIds = $student->advice?->advices
            ? array_map(
                'intval',
                explode(',', $student->advice->advices),
            )
            : [];

        $this->selectedAdvices = array_pad(
            array_slice($selectedAdviceIds, 0, 3),
            3,
            0,
        );
    }

    /**
     * Lifecycle hook: Render the component view
     */
    public function render(): View
    {
        return view('livewire.class.advices');
    }

    /**
     * Action: Save the selected advices
     */
    public function save(): void
    {
        $student = Student::findOrFail($this->studentId);

        $adviceIds = collect($this->selectedAdvices)
            ->map(fn ($adviceId): int => (int) $adviceId)
            ->filter()
            ->unique()
            ->values()
            ->all();

        $student->advice()->updateOrCreate(
            [],
            [
                'advices' => implode(',', $adviceIds),
            ],
        );

        $this->saveCount++;

        session()->flash(
            'advice-saved',
            'Consiglio orientativo salvato correttamente.',
        );
    }
}
