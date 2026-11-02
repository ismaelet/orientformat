<?php

namespace App\Livewire\Class\Progress;

use Livewire\Attributes\Modelable;
use Livewire\Component;

class Toggler extends Component
{
    /**
     * Modelable Property: Whether to consider a section complete if the minimum amount of students have completed it
     */
    #[Modelable]
    public bool $rounded = false;

    /**
     * Lifecycle hook: Initialize component state
     */
    public function mount() {}

    /**
     * Lifecycle hook: Render the component view
     */
    public function render()
    {
        return view('livewire.class.progress.toggler');
    }

    /**
     * Event: Updated rounded
     */
    public function updatedRounded()
    {
        $this->dispatch('togglerUpdated', $this->rounded);
    }
}
