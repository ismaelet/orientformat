<?php

namespace App\Livewire\Admin\DataDownload;

use Livewire\Component;

class Details extends Component
{
    /**
     * Property: School year
     */
    public ?int $schoolYear = null;

    /**
     * Property: School type
     */
    public string $schoolType = 'all';

    /**
     * Property: Download only active students
     */
    public bool $activeStudents = false;

    /**
     * Lifecycle Hook: Render the component view
     */
    public function render()
    {
        return view('livewire.admin.data-download.details');
    }

    public function downloadData()
    {
        return redirect()->route('admin.data-download.details', [
            'schoolYear' => $this->schoolYear,
            'schoolType' => $this->schoolType,
            'activeStudents' => $this->activeStudents,
        ]);
    }
}
